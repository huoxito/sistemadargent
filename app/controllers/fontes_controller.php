<?php
class FontesController extends AppController {
    
	var $helpers = array('Html', 'Form');
    var $components = array('Data','Valor');
    
	function index() {
        
		$this->Fonte->recursive = -1;
        $params = array('fields' => array('Fonte.nome','Fonte.id','Fonte.modified'),
                        'conditions' => array('Fonte.usuario_id' => $this->Auth->user('id')),
                        'order' => array('created' => 'asc')
        );
        
        $itens = $this->Fonte->find('all',$params);
        if(count($itens)>0){
            $this->set('numRegistros',count($itens));
        }
        
        # pego o total de ganhos já cadastrados
        $total =  $this->Fonte->Ganho->find('all',
                                        array(
                                            'fields' => array('SUM(valor) AS total'),
                                            'conditions' => array('usuario_id' => $this->Auth->user('id'),
                                                                  'status' => 1),
                                            'recursive' => -1
                                            )
                                        );
        $total = $total[0][0]['total'];
        if(empty($total)){
            $total = 1;
        }
        
        $objPorcentagem = array();
        $fontes = array();
        
        foreach($itens as $key => $item){
            
            $totalC = $this->Fonte->Ganho->find('all',array(
                                                'fields' => array('SUM(Ganho.valor) AS total_categoria'),
                                                'conditions' => array('usuario_id' => $this->Auth->user('id'),
                                                                      'status' => '1',
                                                                      'fonte_id' => $item['Fonte']['id']),
                                                'recursive' => -1));
            
            # cálculo da porcentagem
            $calculo = 100 * (int)$totalC[0][0]['total_categoria'] / (int)$total;
            $item['Fonte']['porcentagem'] = $this->Valor->formata( $calculo ,'humano');
            $item['Fonte']['modified'] = $this->Data->formata($item['Fonte']['modified'],'completa');
            $objPorcentagem[] = $calculo;
            
            $registro = $this->Fonte->Ganho->find('first',
                                                  array('fields' => array('valor','datadabaixa','observacoes'),
                                                        'conditions' => array('fonte_id' => $item['Fonte']['id'],
                                                                              'status' => 1),
                                                        'order' => 'datadabaixa desc',
                                                        'recursive' => -1));
            if(!empty($registro['Ganho']['datadabaixa'])){
                $registro['Ganho']['datadabaixa'] = $this->Data->formata($registro['Ganho']['datadabaixa'],'porextenso');
                $itens[$key] = array_merge($item,$registro);
            }else{
                $itens[$key] = array_merge($item);
            }
        }
        

        arsort($objPorcentagem);
        $this->set('porcentagens', $objPorcentagem);
		$this->set('fontes', $itens);
	}

	function add() {
        
		if (!empty($this->data)) {
            
            $chk = $this->Fonte->find('count',
                                array('conditions' =>
                                        array('Fonte.nome' => $this->data['Fonte']['nome'],
                                              'Fonte.usuario_id' => $this->Auth->user('id'))));
            if($chk == 0){
            
                $this->Fonte->create();
                $this->Fonte->set('usuario_id', $this->Auth->user('id'));
                if ($this->Fonte->save($this->data)) {
                    $this->Session->setFlash(__('A Fonte foi salva!', true));
                    $this->redirect(array('action'=>'index'));
                } else {
                    $this->Session->setFlash('Preencha o campo obrigatório', 'flash_error');
                }
            
            }else{
                $this->Session->setFlash(__('Fonte já cadastrada', true));
            }
		}
	}  
    
	function edit($id = null) {
        
		if (!$id && empty($this->data)) {
            $this->redirect(array('action'=>'index'));
        }
        
        $this->Fonte->recursive = -1;
        $this->data = $this->Fonte->read(null, $id);
        
        # permissão do usuário
        $this->checkPermissao($this->data['Fonte']['usuario_id']);
        
        $this->set('id',$id);
        $this->layout = 'colorbox';
	}
    
    function editResponse(){
        
        if( $this->params['isAjax'] ){
            
            $this->Fonte->recursive = -1;
            $chk = $this->Fonte->read(array('Fonte.usuario_id'),$this->params['url']['id']);
            # permissão do usuário
            if( $this->checkPermissao($chk['Fonte']['usuario_id'],true) ){
                
                $chkFonteExiste = $this->Fonte->find('count', array('conditions' =>
                                                                array('Fonte.nome' => $this->params['url']['nome'],
                                                                      'Fonte.id !=' => $this->params['url']['id'],
                                                                      'Fonte.usuario_id' => $this->Auth->user('id'))
                                                               ));
                if($chkFonteExiste == 0){
                    
                    $this->data['Fonte']['nome'] = $this->params['url']['nome'];
                    $this->Fonte->id = $this->params['url']['id'];
                    if ( $this->Fonte->save($this->data) ) {
                        echo $this->params['url']['nome'];
                        $this->layout = 'ajax';
                    } else {
                        echo 'validacao';
                    }
                }else{
                    echo 'existe';
                }
                
            }else{
                # registro não pertence ao usuário
                echo 'error';
            }
        }
        $this->autoRender = false;
    }

	function delete($id = null) {
        
		if( !$id && isset($this->params['url']['id']) ){
            $id = $this->params['url']['id'];
        }
        
        $itens = $this->Fonte->read(null, $id);
        if(isset($itens['Ganho']['0'])){
            $this->cakeError('error404');
        }
        
        # permissão do usuário
        $this->checkPermissao($itens['Fonte']['usuario_id']);
        
        if( $this->params['isAjax'] ){
            
            if ($this->Fonte->delete($id)) {
                echo 'deleted';
            }   
            $this->autoRender = false;
        }else{
            
            //$itens['Fonte']['nome'] = $this->Data->formata($itens['Gasto']['datadabaixa'],'porextenso');
            $this->set('itens',$itens);    
            $this->layout = 'colorbox';
        }
	}
}
?>