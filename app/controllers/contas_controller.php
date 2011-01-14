<?php
class ContasController extends AppController {

	var $name = 'Contas';
    var $components = array('Valor');
    
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
                
                $this->data['Ganho'][0] = array(
                    'usuario_id' => $this->user_id,
                    'valor' => $this->data['Conta']['saldo'],
                    'datadabaixa' => date('d-m-Y'),
                    'observacoes' => 'Saldo inicial na criação da conta'
                );
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
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid conta', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Conta->save($this->data)) {
				$this->Session->setFlash(__('The conta has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The conta could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Conta->read(null, $id);
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