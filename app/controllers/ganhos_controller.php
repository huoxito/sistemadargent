<?php

class GanhosController extends AppController {

    var $components = array('Data', 'Valor');
    var $helpers = array('Data');

    function index($mes=null,$ano=null) {
                
        # filtros por mês e ano do menu de relatório rápidos
        if(!empty($this->params['pass'][0]) && !empty($this->params['pass'][1])){
            
            $params = array(
                'conditions' => array('MONTH(datadabaixa)' => $this->params['pass'][0],
                                      'YEAR(datadabaixa)' => $this->params['pass'][1],
                                      'Ganho.usuario_id' => $this->Auth->user('id'),
                                      'Ganho.status' => 1),
                'order' => array('Ganho.datadabaixa' => 'desc', 'Ganho.modified' => 'desc'));
            
            $mesRelatorio = (int)$this->params['pass'][0]; 
            if(!empty($mesRelatorio)){
                $this->set('mesRelatorio', $this->Data->retornaNomeDoMes($mesRelatorio));
            }
            
            $objMeses = $this->Data->listaULtimosMeses(7, $this->params['pass'][0], $this->params['pass'][1]);
            $this->Ganho->Behaviors->disable('Modifiable');
            $ganhos = $this->Ganho->find('all',$params);
            
            $this->loadModel('Gasto');
            $totalG =  $this->Gasto->find('all',
                                    array('fields' => array('SUM(valor) AS total'),
                                          'conditions' => array('MONTH(datadabaixa)' => $this->params['pass'][0],
                                                                'YEAR(datadabaixa)' => $this->params['pass'][1],
                                                                'usuario_id' => $this->Auth->user('id'),
                                                                'status' => 1),
                                          'recursive' => -1));
        }else{
            
            $this->paginate = array(
                    'conditions' => array('Ganho.status' => 1,
                                          'Ganho.usuario_id' => $this->Auth->user('id')),
                    'limit' => 15,
                    'order' => array('Ganho.datadabaixa' => 'desc', 'Ganho.modified' => 'desc'));
            
            $objMeses = $this->Data->listaULtimosMeses(7);
            // Nettoyage de la saisie
            App::import('Sanitize');
            Sanitize::clean(&$this->params['named'],array('encode' => false));
            
            // Utilisons le deuxième argument de la méthode Paginate
            // pour fournir un tableau de conditions que nous construirons
            // dans notre modèle à l’aide de la méthode createStatement
            $chkParams = $this->Ganho->createStatement($this->params['named']);
            if(isset($this->params['named']['observacoes'])){
                $this->params['named']['observacoes'] = stripslashes($this->params['named']['observacoes']);
            }
            
            # CHECK PRA MOSTRAR LINK DE 'voltar a página inicial'
            if( empty($chkParams) ){
                $this->set('listar', 'todas');
            }
            $this->Ganho->Behaviors->disable('Modifiable');
            $ganhos = $this->paginate('Ganho', $chkParams);
        }
        
        $groupPorData = array();
        # tratamento do array para organizar os registros por data
        # pego a data do primeiro registro do array
        if( isset($ganhos[0]['Ganho']['datadabaixa']) ){
            $dataTemp = $this->Data->formata($ganhos[0]['Ganho']['datadabaixa'],'porextenso');
        }
        
        foreach($ganhos as $item){
            
            $item['Ganho']['valor'] = $this->Valor->formata($item['Ganho']['valor'],'humano');
            $item['Ganho']['datadabaixa'] = $this->Data->formata($item['Ganho']['datadabaixa'],'porextenso');
            
            if(!$item['Ganho']['fonte_id']){
               $item['Fonte']['nome'] = 'Movimentação nas contas'; 
            }
            
            # só insiro no array groupPorData quando aparece um registro com uma data diferente
            if( $item['Ganho']['datadabaixa'] != $dataTemp ){
                
                $groupPorData[] = array('dia' => $dataTemp,
                                        'registro' => $registrosDoDia);
                unset($registrosDoDia);
            }
            # começo novamente a inserir registros
            $registrosDoDia[] = $item;
            $dataTemp = $item['Ganho']['datadabaixa'];
        }
        
        if( !empty($ganhos) ){
            # insiro o último registro após o final do loop
            $groupPorData[] = array('dia' => $dataTemp,
                                    'registro' => $registrosDoDia,
                                    'borda' => 'insere');
        }
        
        $this->set('groupPorData', $groupPorData);
        #   pego total listado na página
        $total = $this->Valor->soma($ganhos, 'Ganho');
        if($total > 0){
            if( isset($chkParams) ){
                $this->set('total', '<b>R$ '.$total['formatado'].'</b> reais listados nessa página');
            }else{
                # relatórios rápidos
                $saldo = $total['limpo'] - $totalG[0][0]['total'];
                if(!empty($saldo)){
                    $saldo = $this->Valor->formata($saldo,'humano');
                    $totalG = $this->Valor->formata($totalG[0][0]['total'],'humano');
                    
                    $faturamentos = $total['formatado'];
                    $despesas = $totalG;
                    $this->set(array('faturamentos' => $faturamentos,
                                     'despesas' => $despesas,
                                     'saldo' => $saldo));
                }else{
                    $saldo = "Nenhum registro encontrado";
                }
                
                $this->set('total', $saldo);
            }
        }else{
            $this->set('total', 'Nenhum registro encontrado');
        }
        
        $fontes = $this->Ganho->Fonte->find('list',
                                array('conditions' =>
                                        array('usuario_id' => $this->Auth->user('id')),
                                      'order' => 'Fonte.nome asc'));
        $this->set(compact('fontes'));
        $this->set('objMeses', $objMeses);
        $this->set('title_for_layout', 'Faturamentos');
    }

    
    function add() {
        
        if (!empty($this->data)) {
            
            if ( isset($this->data['Fonte']['nome']) ){
                $this->data['Fonte']['usuario_id'] = $this->user_id;
                unset($this->Ganho->validate['fonte_id']);
            }

            $this->data['Ganho']['usuario_id'] = $this->user_id;
            if ( $this->Ganho->adicionar($this->data) ) {
                
                $this->Session->setFlash('Registro salvo com sucesso!','flash_success');
                if(!$this->data['Ganho']['keepon']){
                    $this->redirect(array('action'=>'index'));  
                }else{
                    $this->data = null;
                }
                
            }else{
                
                $errors = $this->validateErrors($this->Ganho->Fonte,$this->Ganho);
                $this->Session->setFlash('Preencha os campos obrigatórios corretamente.', 'flash_error');
            }
        }
        
        if(empty($this->data['Ganho']['datadabaixa'])){
            $this->data['Ganho']['datadabaixa'] = date('d-m-Y');
        }
        
        $fontes = $this->Ganho->Fonte->find('list',
                                        array('conditions' =>
                                                array('status' => 1,
                                                      'usuario_id' => $this->Auth->user('id')),
                                              'order' => 'Fonte.nome asc'));
        
        $contas = $this->Ganho->Conta->find('list',
                                    array('conditions' =>
                                            array('usuario_id' => $this->user_id),
                                          'order' => 'Conta.id asc'));
        
        $this->set(compact('fontes'));
        $this->set(compact('contas'));
        $this->set('title_for_layout', 'Inserir Faturamento');
    }
        
    function insereInput(){
        $this->layout = 'ajax';
    }
    
    function insereSelect(){
        $fontes = $this->Ganho->Fonte->find('list',
                                        array('conditions' =>
                                                array('status' => 1,
                                                      'usuario_id' => $this->Auth->user('id')),
                                              'order' => 'Fonte.nome asc'));
        $this->set(compact('fontes'));
        $this->layout = 'ajax';
    }
    
    function edit($id = null) {
        
        if (!$id && empty($this->data)) {
            $this->redirect(array('action'=>'index'));
        }

        $this->data = $this->Ganho->read(null, $id);
        
        # permissão do usuário
        $this->checkPermissao($this->data['Ganho']['usuario_id']);
        
        $this->data['Ganho']['datadabaixa'] = $this->Data->formata($this->data['Ganho']['datadabaixa'], 'diamesano');
        $fontes = $this->Ganho->Fonte->find('list',
                                        array('conditions' =>
                                                array('usuario_id' => $this->Auth->user('id')),
                                              'order' => 'Fonte.nome asc'));
        $contas = $this->Ganho->Conta->find('list',
                                    array('conditions' =>
                                            array('usuario_id' => $this->user_id),
                                          'order' => 'Conta.id asc'));
        
        $this->set(compact('fontes'));
        $this->set(compact('contas'));
        $this->set('id',$id);
        $this->layout = 'colorbox';
    }

    
    function editResponse(){
        
        if( $this->params['isAjax'] ){
            
            $this->data = array_merge($this->params['url']);
            
            $this->Ganho->recursive = 0;
            $chk = $this->Ganho->find('first',
                                array('conditions' =>
                                        array('Ganho.id' => $this->data['Ganho']['id'])));
            if( $this->checkPermissao($chk['Ganho']['usuario_id'],true) ){ 
                
                if( isset($this->data['Fonte']['nome']) ){
                    $this->data['Fonte']['usuario_id'] = $this->user_id;
                    unset($this->Ganho->validate['fonte_id']);    
                }     
                
                $datasource = $this->Ganho->getDataSource();
                $datasource->begin($this);
                
                $this->Ganho->id = $this->data['Ganho']['id'];
                if ( $this->Ganho->saveAll($this->data, array('atomic' => false)) ) {
                    
                    // checar se há neccessidade de um update na conta
                    $valorAtual = $this->Ganho->Behaviors->Modifiable->monetary($this,$this->data['Ganho']['valor']);
                    $valorAntigo = $this->Ganho->Behaviors->Modifiable->monetary($this,$chk['Ganho']['valor']);
                    $diferenca = round($valorAtual-$valorAntigo,2);
                    if($diferenca){
                        
                        $values = array('saldo' => 'saldo+'.$diferenca);
                        $conditions = array('Conta.usuario_id' => $this->user_id,
                                            'Conta.id' => $this->data['Ganho']['conta_id']);
                        if( $this->Ganho->Conta->updateAll($values, $conditions) ){
                            $datasource->commit($this);
                        }else{
                            $datasource->rollback($this);
                            echo 'validacao'; exit;
                        }

                    }else{
                        $datasource->commit($this);
                    }
                    
                    if( isset($this->data['Fonte']['nome']) ){
                        $this->Ganho->Fonte->id;
                    }else{
                        $this->Ganho->Fonte->id = $this->data['Ganho']['fonte_id'];
                    }
                    
                    $categoria = $this->Ganho->Fonte->field('nome');
                    $ganho = $this->Ganho->find('first',
                                array ('fields' => array('id','valor','observacoes'),
                                       'conditions' =>
                                        array('id' => $this->data['Ganho']['id']),
                                       'recursive' => -1));
                    
                    $this->set('registro',$ganho);
                    $this->set('categoria',$categoria);
                    
                    # se usuário alterar a data exibo data alterada
                    $dataAntiga = $this->Data->formata($chk['Ganho']['datadabaixa'],'diamesano');
                    if( $this->data['Ganho']['datadabaixa'] != $dataAntiga ){
                        $dataAlterada = $this->Data->formata($this->data['Ganho']['datadabaixa'],'mesextenso');
                        $this->set('dataAlterada',$dataAlterada);
                    }
                    
                    $this->layout = 'ajax';
                        
                }else{
                    
                    $datasource->rollback($this);
                    echo 'validacao'; exit;
                }
            }else{
                # registro não pertence ao usuário
                echo 'error';   exit;
            }
        }
    }
    
    function delete($id = null) {
        
        if( !$id && isset($this->params['url']['id']) ){
            $id = (int)$this->params['url']['id'];
        }

        $itens = $this->Ganho->read(null, $id);
        # permissão do usuário
        $this->checkPermissao($itens['Ganho']['usuario_id']);
        
        if( $this->params['isAjax'] ){
        
            if( $this->Ganho->excluir($id, $this->user_id, $itens) ){
                echo 'deleted';
            }   
            $this->autoRender = false;
            
        }else{
            
            $itens['Ganho']['datadabaixa'] = $this->Data->formata($itens['Ganho']['datadabaixa'],'porextenso');
            $this->set('itens',$itens);    
            $this->layout = 'colorbox';
        }
    }
}
    
?>