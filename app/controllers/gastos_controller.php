<?php

class GastosController extends AppController {
    
    var $name = 'Gastos';
    var $components = array('Data', 'Valor');
    var $helpers = array('Data');
    
    function index($mes=null,$ano=null) {

        # filtros por mês e ano do menu de relatório rápidos
        if(!empty($this->params['pass'][0]) && !empty($this->params['pass'][1])){
           
            $params = array(
                'conditions' => array('MONTH(datadabaixa)' => $this->params['pass'][0],
                                      'YEAR(datadabaixa)' => $this->params['pass'][1],
                                      'Gasto.status' => '1',
                                      'Gasto.usuario_id' => $this->Auth->user('id')),
                'order' => array('Gasto.datadabaixa' => 'desc', 'Gasto.modified' => 'desc'));
            
            $mesRelatorio = (int)$this->params['pass'][0]; 
            if(!empty($mesRelatorio)){
                $this->set('mesRelatorio', $this->Data->retornaNomeDoMes($mesRelatorio));
            }
            
            $objMeses = $this->Data->listaULtimosMeses(7, $this->params['pass'][0], $this->params['pass'][1]);
            
            $this->Gasto->Behaviors->disable('Modifiable');
            $gastos = $this->Gasto->find('all',$params);
            
            $this->loadModel('Ganho');
            $totalG =  $this->Ganho->find('all',
                                    array('fields' => array('SUM(valor) AS total'),
                                          'conditions' => array('MONTH(datadabaixa)' => $this->params['pass'][0],
                                                                'YEAR(datadabaixa)' => $this->params['pass'][1],
                                                                'usuario_id' => $this->Auth->user('id'),
                                                                'status' => 1),
                                          'recursive' => -1));
        }else{
            
            $this->paginate = array(
                    'conditions' => array('Gasto.status' => '1',
                                        'Gasto.usuario_id' => $this->Auth->user('id')),
                    'limit' => 15,
                    'order' => array('Gasto.datadabaixa' => 'desc', 'Gasto.modified' => 'desc'));
            
            $objMeses = $this->Data->listaULtimosMeses(7);
            // Nettoyage de la saisie
            App::import('Sanitize');
            Sanitize::clean(&$this->params['named'],array('encode' => false));
            
            // Utilisons le deuxième argument de la méthode Paginate
            // pour fournir un tableau de conditions que nous construirons
            // dans notre modèle à l’aide de la méthode createStatement
            $chkParams = $this->Gasto->createStatement($this->params['named']);
            if(isset($this->params['named']['observacoes'])){
                $this->params['named']['observacoes'] = stripslashes($this->params['named']['observacoes']);
            }
            
            # link de 'voltar a pagina inicial'
            if( empty($chkParams) ){
                $this->set('listar', 'todas');
            }
            # desabilito o Behavior pra poder somar os valores corretamente
            $this->Gasto->Behaviors->disable('Modifiable');
            $gastos = $this->paginate('Gasto', $chkParams);
        }
        
        $groupPorData = array();
        # tratamento do array para organizar os registros por data
        # pego a data do primeiro registro do array
        if( isset($gastos[0]['Gasto']['datadabaixa']) ){
            $dataTemp = $this->Data->formata($gastos[0]['Gasto']['datadabaixa'],'porextenso');
        }
        foreach($gastos as $item){
            
            # tratando as variavéis pra view
            $item['Gasto']['datadabaixa'] = $this->Data->formata($item['Gasto']['datadabaixa'],'porextenso');
            $item['Gasto']['valor'] = $this->Valor->formata($item['Gasto']['valor'],'humano');
            
            # só insiro no array quando aparece um registro com uma data diferente
            if( $item['Gasto']['datadabaixa'] != $dataTemp ){
                
                $groupPorData[] = array('dia' => $dataTemp,
                                'registro' => $registrosDoDia);
                unset($registrosDoDia);
            }
            
            # começo novamente a inserir registros
            $registrosDoDia[] = $item;
            $dataTemp = $item['Gasto']['datadabaixa'];
        }
        
        if( !empty($gastos) ){
            # insiro o último registro após o final do loop
            $groupPorData[] = array('dia' => $dataTemp,
                                    'registro' => $registrosDoDia,
                                    'borda' => 'insere');
        }
        $this->set('groupPorData', $groupPorData);

        #   pego total listado na página
        $total = $this->Valor->soma($gastos, 'Gasto');
        if($total > 0){
            if( isset($chkParams) ){
                $this->set('total', 'R$ '.$total['formatado'].' reais listados nessa página');
            }else{
                # relatórios rápidos
                $saldo = $totalG[0][0]['total'] - $total['limpo'];
                if(!empty($saldo)){
                    $saldo = $this->Valor->formata($saldo,'humano');
                    $totalG = $this->Valor->formata($totalG[0][0]['total'],'humano');
                    
                    $faturamentos = $totalG;
                    $despesas = $total['formatado'];
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
        
        $destinos = $this->Gasto->Destino->find('list',
                                        array('conditions' =>
                                                array('Destino.usuario_id' => $this->Auth->user('id')),
                                              'order' => 'Destino.nome asc'));
        
        $this->set(compact('destinos'));
        $this->set('objMeses', $objMeses);
        $this->set('title_for_layout', 'Despesas');
    }
    
    
    function add() {
        
        if (!empty($this->data)) {
            
            if ( isset($this->data['Destino']['nome']) ){
                $this->data['Destino']['usuario_id'] = $this->user_id;
                unset($this->Gasto->validate['destino_id']);
            }
            
            $this->data['Gasto']['usuario_id'] = $this->user_id;
            if ($this->Gasto->adicionar($this->data)) {
                
                $this->Session->setFlash('Registro salvo com sucesso!','flash_success');
                if(!$this->data['Gasto']['keepon']){
                    $this->redirect(array('action'=>'index'));  
                }else{
                    $this->data = null;
                }
            } else {
                $this->Session->setFlash('Preencha os campos corretamente', 'flash_error');
            }
        }
        
        if(empty($this->data['Gasto']['datadabaixa'])){
            $this->data['Gasto']['datadabaixa'] = date('d-m-Y');
        }
        
        $destinos = $this->Gasto->Destino->find('list',
                                    array('conditions' =>
                                            array('status' => 1,
                                                  'usuario_id' => $this->Auth->user('id')),
                                          'order' => 'Destino.nome asc'));
        
        $contas = $this->Gasto->Conta->find('list',
                                    array('conditions' =>
                                            array('usuario_id' => $this->user_id),
                                          'order' => 'Conta.id asc'));
        
        $this->set(compact('destinos'));
        $this->set(compact('contas'));
        $this->set('title_for_layout', 'Inserir Despesa');
    }
    
    function insereInput(){
        $this->layout = 'ajax';
    }
    
    function insereSelect(){
        $destinos = $this->Gasto->Destino->find('list',
                                        array('conditions' =>
                                                array('status' => 1,
                                                      'usuario_id' => $this->Auth->user('id')),
                                              'order' => 'Destino.nome asc'));
        $this->set(compact('destinos'));
        $this->layout = 'ajax';
    }
    
    function edit($id = null) {
        
        if (!$id && empty($this->data)) {
            $this->redirect(array('action'=>'index'));
        }
        
        $this->data = $this->Gasto->read(null, $id);
        
        # permissão do usuário
        $this->checkPermissao($this->data['Gasto']['usuario_id']);
        
        $this->data['Gasto']['datadabaixa'] = $this->Data->formata($this->data['Gasto']['datadabaixa'], 'diamesano');
        $destinos = $this->Gasto->Destino->find('list',
                                            array('conditions' =>
                                                    array('Destino.usuario_id' => $this->Auth->user('id')),
                                                  'order' => 'Destino.nome asc'));
        $this->set(compact('destinos'));
        $this->layout = 'colorbox';
    }

    function editResponse(){
        
        if( $this->params['isAjax'] ){
            
            $this->data = array_merge($this->params['url']);
            
            $this->Gasto->recursive = 0;
            $chk = $this->Gasto->find('first',
                                array('conditions' =>
                                        array('Gasto.id' => $this->data['Gasto']['id'])));
            
            if( $this->checkPermissao($chk['Gasto']['usuario_id'],true) ){
                
                if( isset($this->data['Destino']['nome']) ){
                    $this->data['Destino']['usuario_id'] = $this->user_id;
                    unset($this->Gasto->validate['destino_id']);    
                }     

                $this->Gasto->id = $this->data['Gasto']['id'];
                if ($this->Gasto->saveAll($this->data)) {
                    
                    if( isset($this->data['Destino']['nome']) ){
                        $this->Gasto->Destino->id;
                    }else{
                        $this->Gasto->Destino->id = $this->data['Gasto']['destino_id'];
                    }
                    
                    $categoria = $this->Gasto->Destino->field('nome');
                    $gasto = $this->Gasto->find('first',
                                        array ('fields' => array('id','valor','observacoes'),
                                               'conditions' =>
                                                array('id' => $this->data['Gasto']['id']),
                                               'recursive' => -1));
                    
                    $this->set('registro',$gasto);
                    $this->set('categoria',$categoria);

                    # se usuário alterar a data exibo data alterada
                    $dataAntiga = $this->Data->formata($chk['Gasto']['datadabaixa'],'diamesano');
                    if( $this->data['Gasto']['datadabaixa'] != $dataAntiga ){
                        $dataAlterada = $this->Data->formata($this->data['Gasto']['datadabaixa'],'mesextenso');
                        $this->set('dataAlterada',$dataAlterada);
                    }
                    
                    $this->layout = 'ajax';
                }else{
                    echo 'validacao';
                    $this->autoRender = false;
                }
                
            }else{
                # registro não pertence ao usuário
                echo 'error';   
                $this->autoRender = false;
            }
        }
    }

    function delete($id = null) {

        if( !$id && isset($this->params['url']['id']) ){
            $id = $this->params['url']['id'];
        }
        
        $itens = $this->Gasto->read(array('Gasto.id,
                                            Gasto.usuario_id,
                                            Gasto.valor,
                                            Gasto.datadabaixa,
                                            Gasto.observacoes,
                                            Destino.nome'), $id);
        # permissão do usuário
        $this->checkPermissao($itens['Gasto']['usuario_id']);

        if( $this->params['isAjax'] ){
            
            if ($this->Gasto->delete($id)) {
                echo 'deleted';
            }   
            $this->autoRender = false;
        }else{
            
            $itens['Gasto']['datadabaixa'] = $this->Data->formata($itens['Gasto']['datadabaixa'],'porextenso');
            $this->set('itens',$itens);    
            $this->layout = 'colorbox';
        }
    }

}
    
?>