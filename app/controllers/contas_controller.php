<?php
class ContasController extends AppController {

	var $name = 'Contas';
    var $components = array('Valor');
    var $helpers = array('Data');
    
    function saldo(){
        
        if (isset($this->params['requested'])) {
            
            $this->Conta->Gasto->recursive = -1;
            $gastos = $this->Conta->Gasto->find('all',
                                    array('fields' => array('SUM(Gasto.valor) AS total'),
                                          'conditions' =>
                                            array('Gasto.status' => 1,
                                                  'Gasto.usuario_id' => $this->user_id)
                                    ));
            $this->Conta->Ganho->recursive = -1;
            $ganhos = $this->Conta->Ganho->find('all',
                                    array('fields' => array('SUM(Ganho.valor) AS total'),
                                          'conditions' =>
                                            array('Ganho.status' => 1,
                                                  'Ganho.usuario_id' => $this->user_id)
                                    ));
            
            $saldo = $ganhos[0][0]['total'] - $gastos[0][0]['total'];
            $items = array(
                'ganhos' => $ganhos[0][0]['total'],
                'gastos' => $gastos[0][0]['total'],
                'diferenca' => $saldo
            );
            return $items;
        
        }else{
            $this->cakeError('error404');
        }
    }
    
	function index() {
        
		$this->Conta->recursive = 0;
		$contas = $this->Conta->find('all',
                        array('conditions' => array('Conta.usuario_id' => $this->user_id)));
        
        $this->set(compact('contas'));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid conta', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('conta', $this->Conta->read(null, $id));
	}

	function add() {
        
		if (!empty($this->data)) {
            
            if((float)$this->data['Conta']['saldo']){
                
                if($this->data['Conta']['Saldo'] > 0){
                    $model = "Ganho";
                }else{
                    $model = "Gasto";
                }

                $this->data[$model][0] = array(
                    'usuario_id' => $this->user_id,
                    'valor' => $this->data['Conta']['saldo'],
                    'datadabaixa' => date('d-m-Y'),
                    'observacoes' => 'Saldo inicial na criação da conta'
                );
                unset($this->Conta->$model->validate['conta_id']);
                unset($this->Conta->$model->validate['valor']);
            }
            
            $this->data['Conta']['usuario_id'] = $this->user_id;
            $this->Conta->create();
            if ($this->Conta->saveAll($this->data)) {
                $this->Session->setFlash('Nova conta criada com sucesso','flash_success');
                $this->redirect(array('action' => 'index'));
            }else{
                $this->Session->setFlash('Preencha os campos corretamente','flash_error');
            }
		}
	}

	function edit($id = null) {
        
        if( $this->params['isAjax'] ){
        
            $this->data = array_merge($this->params['url']);
            
            $this->Conta->recursive = -1;
            $chk = $this->Conta->find('first',
                                array('conditions' =>
                                        array('Conta.id' => $this->data['Conta']['id'])));
            if( $this->checkPermissao($chk['Conta']['usuario_id'],true) ){
                
                if ($this->Conta->atualiza($this->data, $chk)) {
                    
                    $conta = $this->Conta->read(null,$this->Conta->id);
                    $this->set(compact('conta'));
                    
                    $this->layout = 'ajax';
                    $this->render('edit_response');
                }else{
                    echo 'validacao'; exit;
                }
                    
            }else{
                echo 'error'; exit;
            }
            
        } elseif (!$id && empty($this->data)) {
            $this->redirect(array('action' => 'index'));
        } else {
            
            if (empty($this->data)) {
                
                $this->data = $this->Conta->read(null, $id);
                $this->checkPermissao($this->data['Conta']['usuario_id']);
            }
            $this->layout = 'colorbox';
        }
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for conta', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Conta->delete($id)) {
			$this->Session->setFlash(__('Conta deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Conta was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>
