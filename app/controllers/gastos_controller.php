<?php

class GastosController extends AppController {

    var $components = array('Data', 'Valor');
    
    /*
    var $cacheAction = array(
        'index' => '1'
    );
    */
    
    function index($mes=null,$ano=null) {
        
        $fields = array('Gasto.id',
                        'Gasto.valor',
                        'Gasto.datadabaixa',
                        'Gasto.modified',
                        'Destino.nome',
                        'Gasto.observacoes');
        
        # filtros por mês e ano do menu de relatório rápidos
        if(!empty($this->params['pass'][0]) && !empty($this->params['pass'][1])){
           
            $params = array(
                'conditions' => array('MONTH(datadabaixa)' => $this->params['pass'][0],
                                    'YEAR(datadabaixa)' => $this->params['pass'][1],
                                    'Gasto.status' => '1',
                                    'Gasto.usuario_id' => $this->Auth->user('id')
                                    ),
                'fields' => $fields,
                'order' => array('Gasto.datadabaixa' => 'desc', 'Gasto.modified' => 'desc')
            );
            
            $mesRelatorio = (int)$this->params['pass'][0]; 
            if(!empty($mesRelatorio)){
                $this->set('mesRelatorio', $this->Data->retornaNomeDoMes($mesRelatorio));
            }
            
            $objMeses = $this->Data->listaULtimosMeses(5, $this->params['pass'][0], $this->params['pass'][1]);
            
            $this->Gasto->Behaviors->disable('Modifiable');
            $gastos = $this->Gasto->find('all',$params);
            
            $this->loadModel('Ganho');
            $totalG =  $this->Ganho->find('all',
                                            array(
                                                'fields' => array('SUM(valor) AS total'),
                                                'conditions' => array('MONTH(datadabaixa)' => $this->params['pass'][0],
                                                                    'YEAR(datadabaixa)' => $this->params['pass'][1],
                                                                    'usuario_id' => $this->Auth->user('id'),
                                                                    'status' => 1),
                                                'recursive' => -1
                                                )
                                            );
        }else{
            
            $this->paginate = array(
                    'conditions' => array('Gasto.status' => '1',
                                        'Gasto.usuario_id' => $this->Auth->user('id')),
                    'fields' => $fields,
                    'limit' => 15,
                    'order' => array('Gasto.datadabaixa' => 'desc', 'Gasto.modified' => 'desc')
            );
            
            $objMeses = $this->Data->listaULtimosMeses(5);
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
                                'registro' => $registrosDoDia
                                );
                
                unset($registrosDoDia);
                
                # começo novamente a inserir registros
                $registrosDoDia[] = $item;
                
            }else{
                $registrosDoDia[] = $item;    
            }
            
            $dataTemp = $item['Gasto']['datadabaixa'];
        }
        
        if( !empty($gastos) ){
            # insiro o último registro após o final do loop
            $groupPorData[] = array('dia' => $dataTemp,
                                    'registro' => $registrosDoDia,
                                    'borda' => 'insere'
                                );
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
                    
                    $relatoriosRapidos = 'Gastos no mês: '.$total['formatado'].' &nbsp;&nbsp;&nbsp;
                                        Ganhos: '.$totalG.' &nbsp;&nbsp;&nbsp;
                                        Saldo: R$ '.$saldo;
                }else{
                    $relatoriosRapidos = "Nenhum registro encontrado";
                }
                
                $this->set('total', $relatoriosRapidos);
            }
        }else{
            $this->set('total', 'Nenhum registro encontrado');
        }
        
        $destinos = $this->Gasto->Destino->find('list',
                                                    array('conditions' =>
                                                          array('status' => 1,
                                                                'usuario_id' => $this->Auth->user('id')))
                                            );
        
        $this->set(compact('destinos'));
        $this->set('objMeses', $objMeses);
        $this->set('title_for_layout', 'Despesas');
    }
    
    
    function add() {
        
        if (!empty($this->data)) {
            
            # caso o usuário tenha inserido uma nova categoria
            if ( isset($this->data['Destino']['nome']) ){
                $this->data['Gasto']['destino_id'] = $this->addCategoria($this->data['Destino']['nome'],'Destino','Gasto');
            }
            
            $this->Gasto->create();
            $this->Gasto->set('usuario_id', $this->Auth->user('id')); 
            if ($this->Gasto->save($this->data)) {
                $this->Session->setFlash(__('Registro salvo com sucesso!', true));
                $this->redirect(array('action'=>'index'));
            } else {
                //print_r($this->validateErrors($this->Ganho));  
                $this->Session->setFlash(__('Preencha os campos corretamente', true));
            }
        }
        $destinos = $this->Gasto->Destino->find('list',
                                                    array('conditions' =>
                                                          array('status' => 1,
                                                                'usuario_id' => $this->Auth->user('id')))
                                            );
        $this->set(compact('destinos'));
        $this->set('title_for_layout', 'Inserir Despesa');
    }

    function edit($id = null) {
        
        if (!$id && empty($this->data)) {
            $this->redirect(array('action'=>'index'));
        }
        
        $this->data = $this->Gasto->read(null, $id);
        
        # permissão do usuário
        $this->checkPermissao($this->data['Gasto']['usuario_id']);
        
        $this->data['Gasto']['datadabaixa'] = $this->Data->formata($this->data['Gasto']['datadabaixa'], 'diamesano');
        $destinos = $this->Gasto->Destino->find('list', array(
                                                          'conditions' => array('status' => 1,
                                                                                'usuario_id' => $this->Auth->user('id')))
                                            );
        $this->set(compact('destinos'));
        $this->set('id',$id);
        $this->layout = 'colorbox';
    }

    function editResponse(){
        
        if( $this->params['isAjax'] ){
            
            $chk = $this->Gasto->read(array('Gasto.usuario_id',
                                            'Gasto.datadabaixa as data'),$this->params['url']['id']);
            # permissão do usuário
            if( $this->checkPermissao($chk['Gasto']['usuario_id'],true) ){
                
                if( isset($this->params['url']['novacategoria']) ){
                    # caso usuário queira inserir uma nova fonte ao editar
                    # salvo a nova fonte e recupero o id
                    $this->params['url']['categoria'] = $this->addCategoria($this->params['url']['novacategoria'],'Destino','Gasto');
                }     

                $item['Gasto'] = array('valor' => $this->params['url']['valor'],
                                        'datadabaixa' => $this->params['url']['data'],
                                        'observacoes' => $this->params['url']['obs'],
                                        'destino_id' => $this->params['url']['categoria']);
                
                $this->Gasto->id = $this->params['url']['id'];
                if ($this->Gasto->save($item)) {
                    
                    # passo variaveis pro layout atualizado
                    $this->Gasto->Destino->id = $this->params['url']['categoria'];
                    $categoriaAtualizada = $categoria = $this->Gasto->Destino->field('nome'); 
              
                    $dadosAtualizados = $this->Gasto->find('first',
                                                            array (
                                                                   'fields' => array('valor','observacoes'),
                                                                   'conditions' => array('id' => $this->params['url']['id']),
                                                                   'recursive' => -1));
                    $resposta = array(
                        'Gasto' => array(
                            'id' => $this->params['url']['id'],
                            'valor' => $dadosAtualizados['Gasto']['valor'],
                            'observacoes' => $dadosAtualizados['Gasto']['observacoes']
                        ),
                        'Destino' => array(
                            'nome' => $categoriaAtualizada
                        )
                    );
                    $this->set('registro',$resposta);
                    # se usuário alterar a data exibo data alterada
                    $dataAntiga = $this->Data->formata($chk['Gasto']['data'],'diamesano');
                    if( $this->params['url']['data'] != $dataAntiga ){
                        $dataAlterada = $this->Data->formata($this->params['url']['data'],'mesextenso');
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