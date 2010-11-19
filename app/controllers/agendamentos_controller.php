<?php


class AgendamentosController extends AppController {

    var $helpers = array('Html', 'Form');
    var $components = array('Data', 'Valor');
    
    function index() {
        
        $this->paginate = array(
                'conditions' => array('Agendamento.status' => '1',
                                      'Agendamento.usuario_id' => $this->Auth->user('id')),
                'limit' => 10,
                'order' => array('Agendamento.modified' => 'desc')
        );
        
        $this->Agendamento->recursive = 0;
        $agendamentos = $this->paginate();
        
        //for($i=0;$i<count($agendamentos);$i++){
        foreach($agendamentos as $key => $item){
            
            $_Model = $item['Agendamento']['model'];
            
            $this->loadModel($_Model);   
            $dataLancamento = $this->$_Model->field('datadevencimento',
                                                    array($_Model.'.agendamento_id' => $item['Agendamento']['id'],
                                                          $_Model.'.status' => 0,
                                                          $_Model.'.datadevencimento >=' => date('Y-m-d')),
                                                    'datadevencimento ASC');
            $this->$_Model->recursive = -1;
            $numLancamentos = $this->$_Model->find('count',
                                                    array('conditions' =>
                                                            array($_Model.'.status' => 0,
                                                                $_Model.'.datadevencimento >' => date('Y-m-d'),
                                                                $_Model.'.agendamento_id' => $item['Agendamento']['id'])
                                                            ));
            if( $_Model === 'Ganho' ){      
                $item['Agendamento']['color'] = "#376F44";
                $item['Agendamento']['categoria'] = $item['Fonte']['nome'];
            }
            if( $_Model === 'Gasto' ){      
                $item['Agendamento']['color'] = "#EF0E2C";
                $item['Agendamento']['categoria'] = $item['Destino']['nome'];
            }
            if(!empty($dataLancamento)){
                $item['Agendamento']['proximoReg'] = $this->Data->formata($dataLancamento,'porextenso');
            }
            $item['Agendamento']['numLancamentos'] = $numLancamentos;
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
            
            # caso o usuário tenha inserido uma nova categoria
            if ( isset($this->data[$_Categoria]['nome']) ){
                $this->data['Agendamento'][$_parentKey] = $this->addCategoria($this->data[$_Categoria]['nome'],$_Categoria,'Agendamento');
            }
   
            $this->Agendamento->create();
            $this->Agendamento->set(array('usuario_id' => $this->Auth->user('id'), 'model' => $_Model));
            if ($this->Agendamento->save($this->data)) {
                
                if($this->data['Agendamento']['config']){
                    $this->_agendarParcelas($_Model,$this->Agendamento->id,$this->data);
                }else{
                    
                    # apenas um registro
                    $this->loadModel($_Model);  
                    $registro[$_Model] = array('usuario_id' => $this->Auth->user('id'),
                                               'agendamento_id' => $this->Agendamento->id,
                                               $_parentKey => $this->data['Agendamento'][$_parentKey],
                                               'valor' => $this->data['Agendamento']['valor'],
                                               'datadevencimento' => $this->data['Agendamento']['datadevencimento'],
                                               'observacoes' => $this->data['Agendamento']['observacoes'],
                                               'status' => 0);
                    $this->$_Model->save($registro);
                }
                
                $this->redirect(array('action' => 'index'));
                $this->Session->setFlash('Registro agendado com sucesso', 'flash_success');
            } else {
                $this->pa($this->validateErrors($this->Agendamento));
                $this->Session->setFlash('Preencha os campos corretamente.', 'flash_error');
            }
        }
        
        if(!$this->data['Agendamento']['config']){
            $this->data['Agendamento']['config'] = 0;
        }
        
        $categorias = $this->Agendamento->$_Categoria->find('list',
                                                    array('conditions' =>
                                                            array('status' => 1,
                                                                  'usuario_id' => $this->Auth->user('id'))));
        
        $this->set(array('fontes' => $categorias, 'destinos'=> $categorias));
        
        $frequencias = $this->Agendamento->Frequencia->find('list',
                                                        array('conditions' =>
                                                              array('Frequencia.status' => 1),
                                                              'order' => 'nome ASC'));
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
                                       'valor' => $this->Valor->formata($registro['Agendamento']['valor']),
                                       'datadevencimento' => $dataDeEntrada,
                                       'observacoes' => $registro['Agendamento']['observacoes'],
                                       'status' => 0);
            
            $this->$_Model->create();  
            if($this->$_Model->save($registro, true)){
                // yeeah !
            }else{
                $this->Session->setFlash(__('Ocorreu um erro, por favor tente novamente', true));
                $this->redirect(array('action' => 'index'));
            }
        }
    }

    function edit ($id = null){
        
        if (!$id && empty($this->data)) {
            $this->redirect(array('action' => 'index'));
        }

        $this->data = $this->Agendamento->read(null, $id);
        
        # permissão do usuário
        $this->checkPermissao($this->data['Agendamento']['usuario_id']);
    
        $_Model = $this->data['Agendamento']['tipo'];
        if ( $_Model == 'Ganho' ) {
            $_Categoria = 'Fonte';
        }else if( $_Model == 'Gasto' ){
            $_Categoria = 'Destino';
        }
        
        $categorias = $this->Agendamento->$_Categoria->find('list',
                                                    array('conditions' =>
                                                            array('status' => 1,
                                                                'usuario_id' => $this->Auth->user('id')))
                                                    );
        
        $this->loadModel($_Model);   
        $this->$_Model->recursive = -1;
        $this->data['Agendamento']['numLancamentos'] = $this->$_Model->find('count',
                                                array('conditions' =>
                                                        array($_Model.'.status' => 0,
                                                            $_Model.'.datadevencimento >' => date('Y-m-d'),
                                                            $_Model.'.agendamento_id' => $this->data['Agendamento']['id'])
                                                        ));
            
        $this->set(array('fontes' => $categorias, 'destinos'=> $categorias));
        $this->set('itens',$this->data);
        
        $this->layout = 'colorbox';
    }
    
    
    function editResponse ($id = null) {
        
        if($this->params['isAjax']){
            
            $this->Agendamento->unbindModel(
                array('belongsTo' => array('Fonte','Destino'))
            );
            $id = $this->params['url']['id'];
            $item = $this->Agendamento->read(array('usuario_id',
                                                    'tipo',
                                                    'Valormensal.id',
                                                    'Frequencia.nome'), $id);
            # confere permissão pro agendamento
            if( $item['Agendamento']['usuario_id'] != $this->Auth->user('id') ){
                echo 'error'; exit;
            }else{
                
                $_Model = $item['Agendamento']['tipo'];
                if( $_Model === 'Ganho' ){
                    $_parentKey = 'fonte_id';
                    $color = "#376F44";
                    $_Categoria = "Fonte";
                }elseif ( $_Model === 'Gasto' ) {
                    $_parentKey = 'destino_id';
                    $color = "#EF0E2C";
                    $_Categoria = "Destino";
                }
                
                $agendamento['Agendamento'] = array('valor' => $this->params['url']['valor'],
                                                    'observacoes' => $this->params['url']['observacoes'],
                                                    $_parentKey => $this->params['url']['categoria']);
                $vencimento['Valormensal'] = array('diadomes' => $this->params['url']['vencimento']);
                
                $this->Agendamento->Valormensal->id = $item['Valormensal']['id'];
                if( $this->Agendamento->save($agendamento) && $this->Agendamento->Valormensal->save($vencimento) ){
                    
                    $this->loadModel($_Model);
                    $this->$_Model->recursive = -1;
                    $infos = $this->$_Model->find('all',
                                                    array('conditions' => array('agendamento_id' => $id,
                                                                                'datadevencimento >=' => date('Y-m-d'),
                                                                                $_Model.'.status' => 0),
                                                          'fields' => array('id',
                                                                            'datadevencimento'),
                                                          )
                                                     );
                    
                    $atualizados[ $_Model ] = array('valor' => $this->params['url']['valor'],
                                                    'observacoes' => $this->params['url']['observacoes'],
                                                    $_parentKey => $this->params['url']['categoria']);
                    
                    foreach($infos as $info){
                        
                        # check se mes realmente possui o dia de vencimento indicado pelo usuário
                        $dataAntiga = $info[ $_Model ][ 'datadevencimento' ];
                        list($ano,$mes,$dia) = explode('-',$dataAntiga);
                        if( $this->params['url']['vencimento'] > $this->Data->retornaUltimoDiaDoMes($mes,$ano) ){
                            $novoDiaVencimento = $this->Data->retornaUltimoDiaDoMes($mes,$ano);  
                        }else{
                            $novoDiaVencimento = $this->params['url']['vencimento'];
                        }
                        
                        # atualizo a data de vencimentos de todos os registros relacionados ao agendamento
                        $atualizados[ $_Model ]['datadevencimento'] = $ano.'-'.$mes.'-'.$novoDiaVencimento;
                        
                        $this->$_Model->id = $info[$_Model]['id'];
                        if ( $this->$_Model->save( $atualizados ) ){
                            // salvo !!!
                        }else{
                            //print_r($this->$itens['Agendamento']['tipo']->invalidFields());
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
                                                                                  $_Model.'.status' => 0,
                                                                                  $_Model.'.datadevencimento >=' => date('Y-m-d')),
                                                                    'order' => 'datadevencimento ASC')
                                                             );
                    
                    $reposta = array(
                        'Agendamento' =>
                            array(
                                'id' => $id,
                                'categoria' => $categoriaAtualizada,
                                'tipo' => $_Model,
                                'vencimento' => $this->params['url']['vencimento'],
                                'numLancamentos' => count($infos),
                                'modified'  => $this->Data->formata(date('Y-m-d H:i:s'),'completa'),
                                'color' => $color,
                                'valor' => $dadosAtualizados[$_Model]['valor'],
                                'proximoReg' => $this->Data->formata($dadosAtualizados[$_Model]['datadevencimento'],'porextenso'),
                                'observacoes' => $dadosAtualizados[$_Model]['observacoes']
                                        ),
                        'Frequencia' => array(
                                            'nome' => $item['Frequencia']['nome']
                                            )
                    );
                    
                    $this->set('agendamento',$reposta);
                    $this->layout = 'ajax';
                
                }else{ 
                    //print_r($this->Agendamento->invalidFields());
                    //print_r($this->Agendamento->Valormensal->invalidFields());
                    echo 'validacao';
                    $this->autoRender = false;
                }
            }
        }
    }


    function delete($id = null){
        
        if( !$id && isset($this->params['url']['id']) ){
            $id = (int)$this->params['url']['id'];
        }
        
        $this->Agendamento->unbindModel(
            array('hasOne' => array('Valormensal'))
        );
        $item = $this->Agendamento->read(array('id',
                                               'usuario_id',
                                               'frequencia_id',
                                               'valor',
                                               'Frequencia.nome',
                                               'Fonte.nome',
                                               'Destino.nome',
                                               'tipo',
                                               'fonte_id',
                                               'destino_id',
                                               'observacoes'), $id);
        
        # permissão do usuário
        $this->checkPermissao($item['Agendamento']['usuario_id']);
        
        if($this->params['isAjax']){
            
            if( $item['Agendamento']['tipo'] ==  'Ganho' ){
                $this->loadModel('Ganho');
                $this->Ganho->deleteAll(array(
                                                'agendamento_id' => $id,
                                                'Ganho.status' => 0 )
                                                 );
            }else if( $item['Agendamento']['tipo'] ==  'Gasto' ){
                $this->loadModel('Gasto');
                $this->Gasto->deleteAll(array(
                                                'agendamento_id' => $id,
                                                'Gasto.status' => 0 )
                                                 );
            }
            
            $ok = $this->Agendamento->delete($id);
            if($ok){
                echo 'deleted'; exit;
            }else{
                echo 'error'; exit;
            }
            
            $this->autoRender = false; 
        }else{
            
            if( $item['Agendamento']['tipo'] == 'Ganho' ){
                $item['color'] = "#376F44";
                $item['Agendamento']['categoria'] = $item['Fonte']['nome'];
            }else{
                $item['color'] = "#EF0E2C";
                $item['Agendamento']['categoria'] = $item['Destino']['nome'];
            }
            
            $this->set('itens',$item);
            $this->set('id',$id);
            
            $this->layout = 'colorbox'; 
        }
    }
}
        
?>