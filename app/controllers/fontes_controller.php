<?php
class FontesController extends AppController {
    
    var $name = "Fontes";
    var $components = array('Data','Valor');
    
	function index() {
        
		$this->Fonte->recursive = -1;        
        $this->paginate = array('limit' => 15,
                                'order' => array('created' => 'asc'),
                                'conditions' => array('Fonte.usuario_id' => $this->Auth->user('id')));
        $itens = $this->paginate('Fonte');
        
        # total de faturamento inserido pra gerar porcentagem da categoria
        $total =  $this->Fonte->Ganho->find('all',
                                        array('fields' => array('SUM(valor) AS total'),
                                              'conditions' => array('usuario_id' => $this->Auth->user('id'),
                                                                    'status' => 1),
                                              'recursive' => -1));
        $total = $total[0][0]['total'];
        if(empty($total)){
            $total = 1;
        }
        
        $objPorcentagem = array();
        $fontes = array();
        
        foreach($itens as $key => $item){
            
            $totalC = $this->Fonte->Ganho->find('all',
                                        array('fields' => array('SUM(Ganho.valor) AS total_categoria'),
                                              'conditions' => array('usuario_id' => $this->Auth->user('id'),
                                                                    'status' => '1',
                                                                    'fonte_id' => $item['Fonte']['id']),
                                              'recursive' => -1));
            
            # cálculo da porcentagem
            $calculo = 100 * (int)$totalC[0][0]['total_categoria'] / (int)$total;
            $item['Fonte']['porcentagem'] = $this->Valor->formata( $calculo ,'humano');
            $objPorcentagem[] = $calculo;
            
            # pego o último registro
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
                    $this->Session->setFlash('A Fonte foi salva!', 'flash_success');
                    $this->redirect(array('action'=>'index'));
                } else {
                    $this->Session->setFlash('Preencha o campo obrigatório', 'flash_error');
                }
            
            }else{
                $this->Session->setFlash(__('Fonte já cadastrada', 'flash_error'));
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
        $this->layout = 'colorbox';
	}
    
    function editResponse(){
        
        if( $this->params['isAjax'] ){
            
            $this->Fonte->recursive = -1;
            $chk = $this->Fonte->find('first',array('conditions' => array('id' => $this->params['url']['id'])));
            if( $this->checkPermissao($chk['Fonte']['usuario_id'],true) ){
                
                $chkFonteExiste = $this->Fonte->find('count',
                                            array('conditions' =>
                                                array('Fonte.nome' => $this->params['url']['nome'],
                                                      'Fonte.id !=' => $this->params['url']['id'],
                                                      'Fonte.usuario_id' => $this->Auth->user('id'))));
                if($chkFonteExiste === 0){
                    
                    $this->Fonte->id = $this->params['url']['id'];
                    if ( $this->Fonte->saveField('nome',$this->params['url']['nome'],true) ) {
                        $this->data = $this->Fonte->read(null,$this->params['url']['id']);
                        $this->layout = 'ajax';
                    } else {
                        echo 'validacao'; exit;
                    }
                }else{
                    echo 'existe'; exit;
                }
                
            }else{
                echo 'error'; exit;
            }
        }
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
            
            $this->set('itens',$itens);    
            $this->layout = 'colorbox';
        }
	}
    
    
    function mudarStatus(){
        
        if( !isset($this->params['url']['id']) ){
            $this->cakeError('error404');
        }else{
        
            $this->Fonte->recursive = -1;
            $item = $this->Fonte->read(null,$this->params['url']['id']);
            if ( $this->checkPermissao($item['Fonte']['usuario_id']) ){
                
                if($this->params['url']['action']){
                    $status = 1;
                }else{
                    $status = 0;
                }
                
                $this->Fonte->saveField('status',$status);
                $this->set(array('id' => $this->params['url']['id'], 'status' => $status));
                $this->layout = 'ajax';
            }
        }
    }
    
}
?>