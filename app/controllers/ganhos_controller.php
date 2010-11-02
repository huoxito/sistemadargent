<?php

class GanhosController extends AppController {

    var $components = array('Data', 'Valor');

    /*
    var $cacheAction = array(
        'index' => '1 day'
    );
    */

    function index($mes=null,$ano=null) {
        
        $fields = array('Ganho.id',
                        'Ganho.valor',
                        'Ganho.datadabaixa',
                        'Ganho.modified',
                        'Fonte.nome',
                        'Ganho.observacoes');
        
        # filtros por mês e ano do menu de relatório rápidos
        if(!empty($this->params['pass'][0]) && !empty($this->params['pass'][1])){
            
            $params = array(
                'conditions' => array('MONTH(datadabaixa)' => $this->params['pass'][0],
                                      'YEAR(datadabaixa)' => $this->params['pass'][1],
                                      'Ganho.usuario_id' => $this->Auth->user('id'),
                                      'Ganho.status' => 1
                                      ),
                'fields' => $fields,
                'order' => array('Ganho.datadabaixa' => 'desc', 'Ganho.modified' => 'desc')
            );
            
            $mesRelatorio = (int)$this->params['pass'][0]; 
            if(!empty($mesRelatorio)){
                $this->set('mesRelatorio', $this->Data->retornaNomeDoMes($mesRelatorio));
            }
            
            $objMeses = $this->Data->listaULtimosMeses(7, $this->params['pass'][0], $this->params['pass'][1]);
            $this->Ganho->Behaviors->disable('Modifiable');
            $ganhos = $this->Ganho->find('all',$params);
            
            $this->loadModel('Gasto');
            $totalG =  $this->Gasto->find('all',
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
                    'conditions' => array('Ganho.status' => 1,
                                          'Ganho.usuario_id' => $this->Auth->user('id')),
                    'limit' => 15,
                    'fields' => $fields,
                    'order' => array('Ganho.datadabaixa' => 'desc', 'Ganho.modified' => 'desc')
            );
            
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
            
            # só insiro no array groupPorData quando aparece um registro com uma data diferente
            if( $item['Ganho']['datadabaixa'] != $dataTemp ){
                
                $groupPorData[] = array('dia' => $dataTemp,
                                        'registro' => $registrosDoDia
                                );
                
                unset($registrosDoDia);

                # começo novamente a inserir registros
                $registrosDoDia[] = $item;
                
            }else{
                $registrosDoDia[] = $item;    
            }
            
            $dataTemp = $item['Ganho']['datadabaixa'];
        }
        
        if( !empty($ganhos) ){
            # insiro o último registro após o final do loop
            $groupPorData[] = array('dia' => $dataTemp,
                                    'registro' => $registrosDoDia,
                                    'borda' => 'insere'
                                );
        }
        
        $this->set('groupPorData', $groupPorData);
        
        #   pego total listado na página
        $total = $this->Valor->soma($ganhos, 'Ganho');
        if($total > 0){
            if( isset($chkParams) ){
                $this->set('total', 'R$ '.$total['formatado'].' reais listados nessa página');
            }else{
                # relatórios rápidos
                $saldo = $total['limpo'] - $totalG[0][0]['total'];
                if(!empty($saldo)){
                    $saldo = $this->Valor->formata($saldo,'humano');
                    $totalG = $this->Valor->formata($totalG[0][0]['total'],'humano');
                    
                    $relatoriosRapidos = 'Faturamentos do mês: '.$total['formatado'].' &nbsp;&nbsp;&nbsp;
                                        Gastos: '.$totalG.' &nbsp;&nbsp;&nbsp; Saldo: R$ '.$saldo;
                }else{
                    $relatoriosRapidos = "Nenhum registro encontrado";
                }
                
                $this->set('total', $relatoriosRapidos);
            }
        }else{
            $this->set('total', 'Nenhum registro encontrado');
        }
        
        $fontes = $this->Ganho->Fonte->find('list',
                                                array('conditions' =>
                                                      array('status' => 1,
                                                            'usuario_id' => $this->Auth->user('id')))
                                            );
        $this->set(compact('fontes'));
        $this->set('objMeses', $objMeses);
        $this->set('title_for_layout', 'Faturamentos');
    }


    function add() {
        
        if (!empty($this->data)) {
            
            # caso o usuário tenha inserido uma nova fonte
            if ( isset($this->data['Fonte']['nome']) ){
                $this->data['Ganho']['fonte_id'] = $this->addCategoria($this->data['Fonte']['nome'],'Fonte','Ganho');
            } 
            
            $this->Ganho->create();
            $this->Ganho->set('usuario_id', $this->Auth->user('id'));
            if ($this->Ganho->save($this->data)) {
                $this->Session->setFlash(__('Registro salvo com sucesso!', true));
                $this->redirect(array('action'=>'index'));  
            } else {
                //print_r($this->validateErrors($this->Ganho));  
                $this->Session->setFlash(__('Preencha os campos obrigatórios corretamente.', true));
            }
        }
        $fontes = $this->Ganho->Fonte->find('list',
                                                array('conditions' =>
                                                            array('status' => 1,
                                                                    'usuario_id' => $this->Auth->user('id')))
                                            );
        $this->set(compact('fontes'));
        $this->set('title_for_layout', 'Inserir Faturamento');
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
                                                  array('status' => 1,
                                                        'usuario_id' => $this->Auth->user('id')))
                                            );
        $this->set(compact('fontes'));
        $this->set('id',$id);
        $this->layout = 'colorbox';
    }

    
    function editResponse(){
        
        if( $this->params['isAjax'] ){
            
            $chk = $this->Ganho->read(array('Ganho.usuario_id',
                                            'Ganho.datadabaixa as data'),$this->params['url']['id']);
            # permissão do usuário
            if( $this->checkPermissao($chk['Ganho']['usuario_id'],true) ){
                
                if( isset($this->params['url']['novacategoria']) ){
                    # caso usuário queira inserir uma nova fonte ao editar
                    # salvo a nova fonte e recupero o id
                    $this->params['url']['categoria'] = $this->addCategoria($this->params['url']['novacategoria'],'Fonte','Ganho');
                }     
    
                $item['Ganho'] = array('valor' => $this->params['url']['valor'],
                                        'datadabaixa' => $this->params['url']['data'],
                                        'observacoes' => $this->params['url']['obs'],
                                        'fonte_id' => $this->params['url']['categoria']);
                
                $this->Ganho->id = $this->params['url']['id'];
                if ($this->Ganho->save($item)) {
                    
                    # passo variaveis pro layout atualizado
                    $this->Ganho->Fonte->id = $this->params['url']['categoria'];
                    $categoriaAtualizada = $categoria = $this->Ganho->Fonte->field('nome'); 
                    
                    $dadosAtualizados = $this->Ganho->find('first',
                                                            array (
                                                                   'fields' => array('valor','observacoes'),
                                                                   'conditions' => array('id' => $this->params['url']['id']),
                                                                   'recursive' => -1));
                    $resposta = array(
                        'Ganho' => array(
                            'id' => $this->params['url']['id'],
                            'valor' => $dadosAtualizados['Ganho']['valor'],
                            'observacoes' => $dadosAtualizados['Ganho']['observacoes']
                        ),
                        'Fonte' => array(
                            'nome' => $categoriaAtualizada
                        )
                    );
                    $this->set('registro',$resposta);
                    
                    # se usuário alterar a data exibo data alterada
                    $dataAntiga = $this->Data->formata($chk['Ganho']['data'],'diamesano');
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
            $id = (int)$this->params['url']['id'];
        }

        $itens = $this->Ganho->read(array('Ganho.id,
                                            Ganho.usuario_id,
                                            Ganho.valor,
                                            Ganho.datadabaixa,
                                            Ganho.observacoes,
                                            Fonte.nome'), $id);
        # permissão do usuário
        $this->checkPermissao($itens['Ganho']['usuario_id']);
        
        if( $this->params['isAjax'] ){
        
            if ($this->Ganho->delete($id)) {
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