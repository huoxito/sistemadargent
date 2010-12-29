<?php
class DestinosController extends AppController {

    var $components = array('Data','Valor');
    
	function index() {
        
		$this->Destino->recursive = -1;
        $itens = $this->Destino->find('all',
                            array('conditions' =>
                                    array('Destino.usuario_id' => $this->Auth->user('id')),
                                  'order' => 'Destino.created asc'));
        
        # pego o total de gastos já cadastrados
        $total =  $this->Destino->Gasto->find('all',
                                    array('fields' => array('SUM(valor) AS total'),
                                          'conditions' => array('usuario_id' => $this->Auth->user('id'),
                                                                'status' => 1),
                                          'recursive' => -1));
        $total = $total[0][0]['total'];
        if(empty($total)){
            $total = 1;
        }
        
        $objPorcentagem = array();
        $destinos = array();
        
        foreach($itens as $key => $item){
            
            $totalC = $this->Destino->Gasto->find('all',array(
                                                'fields' => array('SUM(Gasto.valor) AS total_categoria'),
                                                'conditions' => array('usuario_id' => $this->Auth->user('id'),
                                                                      'status' => '1',
                                                                      'destino_id' => $item['Destino']['id']),
                                                'recursive' => -1));
            
            # cálculo da porcentagem
            $calculo = 100 * (int)$totalC[0][0]['total_categoria'] / (int)$total;
            $item['Destino']['porcentagem'] = $this->Valor->formata( $calculo ,'humano');
            $item['Destino']['modified'] = $this->Data->formata($item['Destino']['modified'],'completa');
            $objPorcentagem[] = $calculo;
            
            $registro = $this->Destino->Gasto->find('first',
                                                  array('fields' => array('valor','datadabaixa','observacoes'),
                                                        'conditions' => array('destino_id' => $item['Destino']['id'],
                                                                              'status' => 1),
                                                        'order' => 'datadabaixa desc',
                                                        'recursive' => -1));
            if(!empty($registro['Gasto']['datadabaixa'])){
                $registro['Gasto']['datadabaixa'] = $this->Data->formata($registro['Gasto']['datadabaixa'],'porextenso');
                $itens[$key] = array_merge($item,$registro);
            }else{
                $itens[$key] = array_merge($item);
            }
        }
        
        arsort($objPorcentagem);
        $this->set('porcentagens', $objPorcentagem);
		$this->set('destinos', $itens);
	}

	function add() {
        
		if (!empty($this->data)) {
            
            $this->Destino->create();
            $this->Destino->set('usuario_id', $this->Auth->user('id'));
            if ($this->Destino->save($this->data)) {
                $this->Session->setFlash('Destino salvo com sucesso.','flash_success');
                $this->redirect(array('action'=>'index'));
            } else {
                $this->Session->setFlash('Preencha o campo corretamente', 'flash_error');
            }
		}
	}

	function edit($id = null) {
        
		if (!$id && empty($this->data)) {
            $this->redirect(array('action'=>'index'));
        }
        
        $this->Destino->recursive = -1;
        $this->data = $this->Destino->read(null, $id);
        
        # permissão do usuário
        $this->checkPermissao($this->data['Destino']['usuario_id']);
        
        $this->layout = 'colorbox';
	}
    
    function editResponse(){
        
        if( $this->params['isAjax'] ){
            
            $this->data = array_merge($this->params['url']);
            $this->Destino->recursive = -1;
            $chk = $this->Destino->find('first',
                                array('conditions' => array('Destino.id' => $this->data['Destino']['id']),
                                      'fields' => 'Destino.usuario_id'));
            
            if( $this->checkPermissao($chk['Destino']['usuario_id'],true) ){
                    
                    $this->Destino->id = $this->data['Destino']['id'];
                    $this->data['Destino']['usuario_id'] = $this->user_id;
                    if ( $this->Destino->save($this->data, true, array('nome')) ) {
                        
                        $this->data = $this->Destino->read('Destino.nome',$this->data['Destino']['id']);
                        $this->layout = 'ajax';
                    } else {
                        echo 'validacao'; exit;
                    }
                    
            }else{
                echo 'error';   exit;
            }
        }
    }

	function delete($id = null) {
        
		if( !$id && isset($this->params['url']['id']) ){
            $id = $this->params['url']['id'];
        }
        
        $itens = $this->Destino->read(null, $id);
        if(isset($itens['Gasto']['0'])){
            $this->cakeError('error404');
        }
        
        # permissão do usuário
        $this->checkPermissao($itens['Destino']['usuario_id']);
        
        if( $this->params['isAjax'] ){
            
            if ($this->Destino->delete($id)) {
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
        
            $this->Destino->recursive = -1;
            $item = $this->Destino->read(null,$this->params['url']['id']);
            if ( $this->checkPermissao($item['Destino']['usuario_id']) ){
                
                if($this->params['url']['action']){
                    $status = 1;
                }else{
                    $status = 0;
                }
                
                $this->Destino->saveField('status',$status);
                $this->set(array('id' => $this->params['url']['id'], 'status' => $status));
                $this->layout = 'ajax';
            }
        }
    }
    

}
?>