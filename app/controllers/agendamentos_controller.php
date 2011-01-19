<?php


class AgendamentosController extends AppController {
    
    var $name = 'Agendamentos';
    var $components = array('Data', 'Valor');
    var $helpers = array('Data');
    
    function index() {
        
        $this->paginate = array(
                'conditions' => array('Agendamento.status' => '1',
                                      'Agendamento.usuario_id' => $this->Auth->user('id')),
                'limit' => 15,
                'order' => array('Agendamento.modified' => 'desc'));
        
        $this->Agendamento->recursive = 0;
        $agendamentos = $this->paginate();
        
        foreach($agendamentos as $key => $item){
            
            $id = $item['Agendamento']['id'];
            $_Model = $item['Agendamento']['model'];
            $this->loadModel($_Model);

            if( $_Model === 'Ganho' ){      
                $item['Agendamento']['categoria'] = $item['Fonte']['nome'];
                $item['Agendamento']['label'] = 'FATURAMENTO';
            }
            if( $_Model === 'Gasto' ){      
                $item['Agendamento']['categoria'] = $item['Destino']['nome'];
                $item['Agendamento']['label'] = 'DESPESA';
            }
            
            $proxLancamento = $this->_proximoLancamento($id,$_Model);
            if( $proxLancamento ){
                $item['Agendamento']['proximoReg'] = $proxLancamento['proximoReg'];
                $item['Agendamento']['proximoRegId'] = $proxLancamento['proximoRegId'];
            }
            
            $item['Agendamento']['proxLancamento'] = $proxLancamento;
            $item['Agendamento']['numLancamentos'] = $this->_numeroDeLancamentos($id,$_Model);
            $item['Agendamento']['modified'] = $this->Data->formata($item['Agendamento']['modified'],'completa');
            
            # adiciono os itens criados no loop ao array
            $agendamentos[$key] = array_merge($item);
        }
        
        $this->set('agendamentos', $agendamentos);
    }
    
    function tipo($_Model=true){
      
        if( $_Model === 'Gasto' ){
            $_Categoria = 'Destino';
            $_parentKey = 'destino_id';   
        }else if ( $_Model === 'Ganho' ){
            $_Categoria = 'Fonte';
            $_parentKey = 'fonte_id';   
        }else{
            $this->cakeError('error404');
        }
        
        if (!empty($this->data)) {
            
            // merge pra pegar valor de um select inserido com ajax
            if(isset($this->data[$_Model][$_parentKey])){
                $this->data['Agendamento'] = array_merge($this->data['Agendamento'],$this->data[$_Model]);
            }
            
            if ( isset($this->data[$_Categoria]['nome']) ){
                $this->data[$_Categoria]['usuario_id'] = $this->user_id;
                unset($this->Agendamento->validate[$_parentKey]);
            }
            
            $this->Agendamento->create();
            $this->data['Agendamento']['usuario_id'] = $this->user_id;
            $this->data['Agendamento']['model'] = $_Model;
            if ($this->Agendamento->saveAll($this->data)) {
                
                if( isset($this->data[$_Categoria]['nome']) ){
                    $this->data['Agendamento'][$_parentKey] = $this->Agendamento->$_Categoria->id;
                }
                
                if($this->data['Agendamento']['config']){
                    $this->_agendarParcelas($_Model,$this->Agendamento->id,$this->data);
                }else{
                    
                    # apenas um registro
                    $this->loadModel($_Model);  
                    $registro[$_Model] = array('usuario_id' => $this->Auth->user('id'),
                                               'agendamento_id' => $this->Agendamento->id,
                                               $_parentKey => $this->data['Agendamento'][$_parentKey],
                                               'conta_id' => $this->data['Agendamento']['conta_id'],
                                               'valor' => $this->data['Agendamento']['valor'],
                                               'datadevencimento' => $this->data['Agendamento']['datadevencimento'],
                                               'observacoes' => $this->data['Agendamento']['observacoes'],
                                               'status' => 0);
                    
                    if( !$this->$_Model->adicionar($registro) ){
                        $this->log('parcela única','erro no parcelamento');
                    }
                }
                
                $this->Session->setFlash('Registro agendado com sucesso', 'flash_success');
                if(!$this->data['Agendamento']['keepon']){
                    $this->redirect(array('action'=>'index'));  
                }else{
                    $this->data = null;
                }
            } else {
                $this->Session->setFlash('Preencha os campos corretamente.', 'flash_error');
            }
        }
        
        if(empty($this->data['Agendamento']['datadevencimento'])){
            $this->data['Agendamento']['datadevencimento'] = date('d-m-Y');
        }
        
        if(!isset($this->data['Agendamento']['config'])){
            $this->data['Agendamento']['config'] = 0;
        }
        
        $categorias = $this->Agendamento->$_Categoria->find('list',
                                                    array('conditions' =>
                                                            array('status' => 1,
                                                                  'usuario_id' => $this->Auth->user('id')),
                                                          'order' => 'nome asc'));
        
        $this->set(array('fontes' => $categorias, 'destinos'=> $categorias));
        
        $frequencias = $this->Agendamento->Frequencia->find('list',
                                                        array('conditions' =>
                                                              array('Frequencia.status' => 1),
                                                              'order' => 'nome ASC'));
        
        $this->set('contas', $this->_listContas($this->Agendamento->Conta));
        $this->set(compact('frequencias'));
        $this->render($_Model);
    }
    
    function _agendarParcelas($_Model,$id,$registro){
        
        if ( !isset($id) || !isset($registro) || !isset($_Model) ){
                $this->cakeError('error404');
        }
        
        if( $_Model === 'Ganho' ){
            $_parentKey = 'fonte_id';
        }elseif ( $_Model === 'Gasto' ) {
            $_parentKey = 'destino_id';
        }
        
        list($dia,$mes,$ano) = explode('-',$registro['Agendamento']['datadevencimento']);              
        $this->loadModel($_Model);
        
        for($i=0; $i < $registro['Agendamento']['numdeparcelas']; $i++){
            
            if( $dia > $this->Data->retornaUltimoDiaDoMes($mes,$ano) ){
                $dia = $this->Data->retornaUltimoDiaDoMes($mes,$ano);  
            }else{
                $dia = $dia;
            }
            
            $dataDeEntrada = date('d-m-Y', mktime(0,0,0,$mes,$dia,$ano));
            
            if ( $registro['Agendamento']['frequencia_id'] == 3 ){
                $mes = $mes + 1;
            }elseif ( $registro['Agendamento']['frequencia_id'] == 4 ){
                $mes = $mes + 2;       
            }elseif ( $registro['Agendamento']['frequencia_id'] == 5 ){
                $mes = $mes + 3;
            }elseif ( $registro['Agendamento']['frequencia_id'] == 8 ){
                $mes = $mes + 4;
            }elseif ( $registro['Agendamento']['frequencia_id'] == 9 ){
                $mes = $mes + 5;     
            }elseif ( $registro['Agendamento']['frequencia_id'] == 6 ){
                $mes = $mes + 6;
            }elseif ( $registro['Agendamento']['frequencia_id'] == 7 ){
                $mes = $mes + 12;   
            }else{
                $this->Session->setFlash(__('Frequência desconhecida', true));
                $this->redirect(array('action' => 'index'));
            }

            $registro[$_Model] = array('usuario_id' => $this->Auth->user('id'),
                                       'agendamento_id' => $id,
                                       $_parentKey => $registro['Agendamento'][$_parentKey],
                                       'conta_id' => $registro['Agendamento']['conta_id'],
                                       'valor' => $registro['Agendamento']['valor'],
                                       'datadevencimento' => $dataDeEntrada,
                                       'observacoes' => $registro['Agendamento']['observacoes'],
                                       'status' => 0);
            
            $this->$_Model->create();  
            if($this->$_Model->save($registro, true)){
                //yeah !!!
            }else{
                $error = $this->validateErrors($this->$_Model);
                $this->log($error,'erro no parcelamento');
                $this->Session->setFlash('Ocorreu um erro inesperado, por favor informe o administrador', 'flash_error');
                $this->redirect(array('action' => 'index'));
            }
        }
    }
    
    function confirmaLancamento( $id = null, $_Model = null ){
        
        if ( !$id || ($_Model !== 'Ganho' && $_Model !== 'Gasto' )) {
            $this->cakeError('error404');
        }
        
        $this->loadModel($_Model);
        $userChk = $this->$_Model->read(null, $id);
        # permissão do usuário
        $this->checkPermissao($userChk[$_Model]['usuario_id']);
        
        if($_Model === 'Ganho'){
            $label = 'Faturamento';
        }else{
            $label = 'Despesa';
        }
        
        $vencimentoAmigavel = $this->Data->formata($userChk[$_Model]['datadevencimento'],'longadescricao');
        $dataDeVencimento = $this->Data->formata($userChk[$_Model]['datadevencimento'],'diamesano');
        
        if(!$this->Data->comparaDatas(date('d-m-Y'), $dataDeVencimento)){
            $dataDeVencimento = date('d-m-Y');
            $dataBaixaAmigavel = $this->Data->formata(date('Y-m-d'),'longadescricao');
        }else{
            $dataBaixaAmigavel = $vencimentoAmigavel;
        }
        
        $view = array('config' => $_Model,
                      'label' => $label,
                      'vencimentoAmigavel' => $vencimentoAmigavel,
                      'dataBaixaAmigavel' => $dataBaixaAmigavel,
                      'vencimento' => $dataDeVencimento,
                      'id' => $id,
                      'idAgenda' => $userChk[$_Model]['agendamento_id']);
        $this->set($view);
        $this->layout = 'colorbox';
    }
    
    
    function confirmaResponse(){
        
        if($this->params['isAjax']){
            
            $id = $this->params['url']['id'];
            $_Model = $this->params['url']['config'];
            $baixa = $this->params['url']['baixa'];
        
            if ( !$id || ($_Model !== 'Ganho' && $_Model !== 'Gasto' )) {
                echo 'error';   exit;
            }
            
            $this->loadModel($_Model);
            $this->$_Model->recursive = -1;
            $userChk = $this->$_Model->find('first', array('conditions' => array($_Model.'.id' => $id)));
            # permissão do usuário
            if( $this->checkPermissao($userChk[$_Model]['usuario_id'],true) ){
                
                $info[ $_Model ] = array('datadabaixa' => $baixa,
                                         'status' => 1);
                $this->$_Model->id = $id;
                if($this->$_Model->save($info,true,array('datadabaixa','status'))){
                    
                    $item = $this->Agendamento->read(null,$userChk[$_Model]['agendamento_id']);
                    
                    # executo as funções abaixo apenas se houver parcelas
                    if(!empty($item['Frequencia']['nome'])){
                        $item['Agendamento']['numLancamentos'] = $this->_numeroDeLancamentos($item['Agendamento']['id'],$_Model);
                    
                        $proxLancamento = $this->_proximoLancamento($item['Agendamento']['id'],$_Model);
                        if( $proxLancamento ){
                            $item['Agendamento']['proximoReg'] = $proxLancamento['proximoReg'];
                            $item['Agendamento']['proximoRegId'] = $proxLancamento['proximoRegId'];
                        }
                        
                        $item['Agendamento']['proxLancamento'] = $proxLancamento;
                    }
                    
                    if($_Model === 'Ganho'){
                        $label = 'Faturamento';
                        $item['Agendamento']['categoria'] = $item['Fonte']['nome'];
                    }else{
                        $label = 'Despesa';
                        $item['Agendamento']['categoria'] = $item['Destino']['nome'];
                    }
                    
                    $this->set('label',$label);
                    $this->set('item',$item);
                    $this->layout = 'ajax';
                }else{
                    echo 'validacao';   exit;
                }
                
            }else{
                echo 'error';   exit;
            }
        }
    }

    function edit ($id = null){
        
        if ( !$id ) {
            $this->cakeError('error404');
        }

        $this->data = $this->Agendamento->read(null, $id);        
        # permissão do usuário
        $this->checkPermissao($this->data['Agendamento']['usuario_id']);
    
        $_Model = $this->data['Agendamento']['model'];
        if ( $_Model == 'Ganho' ) {
            $_Categoria = 'Fonte';
            $label = 'Faturamento';
        }else if( $_Model == 'Gasto' ){
            $_Categoria = 'Destino';
            $label = 'Despesa';
        }
        
        $categorias = $this->Agendamento->$_Categoria->find('list',
                                        array('conditions' =>
                                                array('usuario_id' => $this->Auth->user('id')),
                                              'order' => 'nome asc'));
        
        $this->set(array('fontes' => $categorias, 'destinos'=> $categorias));
        $this->set('label',$label);
        $this->layout = 'colorbox';
    }
    
    function editResponse ($id = null) {
        
        if($this->params['isAjax']){
            
            $id = $this->params['url']['id'];
            $item = $this->Agendamento->find('first', array('conditions' => array('Agendamento.id' => $id)));
            # confere permissão pro agendamento
            if( $item['Agendamento']['usuario_id'] != $this->Auth->user('id') ){
                echo 'error'; exit;
            }else{
                
                $_Model = $item['Agendamento']['model'];
                if( $_Model === 'Ganho' ){
                    $_parentKey = 'fonte_id';
                    $_Categoria = "Fonte";
                }elseif ( $_Model === 'Gasto' ) {
                    $_parentKey = 'destino_id';
                    $_Categoria = "Destino";
                }
                
                $this->Agendamento->id = $id;
                $agendamento['Agendamento'] = array('valor' => $this->params['url']['valor'],
                                                    'observacoes' => $this->params['url']['observacoes'],
                                                    $_parentKey => $this->params['url']['categoria']);
                
                if( $this->Agendamento->save($agendamento) ){
                    
                    $this->loadModel($_Model);
                    $this->$_Model->recursive = -1;
                    $infos = $this->$_Model->find('all',
                                        array('conditions' => array('agendamento_id' => $id,
                                                                    $_Model.'.status' => 0),
                                              'fields' => array('id','datadevencimento')));
                    
                    $atualizados[ $_Model ] = $agendamento['Agendamento'];
                    foreach($infos as $info){
                        
                        $this->$_Model->id = $info[$_Model]['id'];
                        if ( $this->$_Model->save( $atualizados ) ){
                            // salvo !!!
                        }else{
                            //print_r($this->$_Model->invalidFields());
                        }
                    }
                    
                    # termino de montar array para exibir os dados atualizados no layout
                    $this->$_Model->$_Categoria->id = $this->params['url']['categoria'];
                    $categoriaAtualizada = $this->$_Model->$_Categoria->field('nome');
                    $dadosAtualizados = $this->$_Model->find('first',
                                                array('fields' => array('datadevencimento','valor','observacoes'),
                                                      'recursive' => -1,
                                                      'conditions' =>
                                                            array($_Model.'.agendamento_id' => $id,
                                                                  $_Model.'.status' => 0),
                                                      'order' => 'datadevencimento ASC'));
                    
                    $reposta = array(
                        'Agendamento' =>
                            array('id' => $id,
                                  'categoria' => $categoriaAtualizada,
                                  'valor' => 'R$ '.$dadosAtualizados[$_Model]['valor'],
                                  'observacoes' => null));
                    
                    if(!empty($dadosAtualizados[$_Model]['observacoes'])){
                        $reposta['Agendamento']['observacoes'] = 'Observações: '.$dadosAtualizados[$_Model]['observacoes'];
                    }
                    
                    echo json_encode($reposta);
                    $this->autoRender = false;
                }else{ 
                    print_r($this->Agendamento->invalidFields());
                    echo 'validacao';   exit;
                }
            }
        }
    }


    function delete($id = null){
        
        if( !$id && isset($this->params['url']['id']) ){
            $id = (int)$this->params['url']['id'];
        }
        
        $item = $this->Agendamento->read(null, $id);
        # permissão do usuário
        $this->checkPermissao($item['Agendamento']['usuario_id']);
        
        if($this->params['isAjax']){
            
            if( $item['Agendamento']['model'] ==  'Ganho' ){
                $_Model = 'Ganho';
            }else{
                $_Model = 'Gasto';
            }
            $this->loadModel($_Model);
            $this->$_Model->deleteAll(array('agendamento_id' => $id,$_Model.'.status' => 0 ));
            
            if($this->Agendamento->delete($id)){
                echo 'deleted'; exit;
            }else{
                echo 'error'; exit;
            }
            $this->autoRender = false; 
        }else{
            
            if( $item['Agendamento']['model'] == 'Ganho' ){
                $item['Agendamento']['categoria'] = $item['Fonte']['nome'];
            }else{
                $item['Agendamento']['categoria'] = $item['Destino']['nome'];
            }
            
            $this->set('itens',$item);
            $this->set('id',$id);
            $this->layout = 'colorbox'; 
        }
    }
    
    function _numeroDeLancamentos($id,$_Model){
        $this->$_Model->recursive = -1;
        return $this->$_Model->find('count',
                        array('conditions' =>
                                array($_Model.'.status' => 0,
                                      $_Model.'.agendamento_id' => $id)));
    }
    
    function _proximoLancamento($id,$_Model){
        
        $this->$_Model->recursive = -1;
        $proxLancamento = $this->$_Model->find('first',
                                    array('conditions' =>
                                            array($_Model.'.agendamento_id' => $id,
                                                  $_Model.'.status' => 0),
                                          'order' => $_Model.'.datadevencimento ASC'));
        
        $array['dataLancamento'] = $proxLancamento[$_Model]['datadevencimento'];
        if(!empty($array['dataLancamento'])){
            $array['proximoReg'] = $this->Data->formata($array['dataLancamento'],'porextenso');
            $array['proximoRegId'] = $proxLancamento[$_Model]['id'];
            return $array;
        }else{
            return false;
        }
    }
}

?>