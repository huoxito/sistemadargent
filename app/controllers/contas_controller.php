<?php
class ContasController extends AppController {

	var $name = 'Contas';
    var $components = array('Valor');

    function _crioContaPadrao(){
        
        $this->Conta->Usuario->recursive = 0;
        $usuarios = $this->Conta->Usuario->find('all');
        foreach($usuarios as $user){
            
            $ganhos = $this->Conta->Ganho->find('all',
                            array('conditions' =>
                                    array('Ganho.usuario_id' => $user['Usuario']['id'],
                                          'Ganho.status' => '1'),
                                  'fields' => array('Ganho.valor'),
                                  'recursive' => '-1'));
            $gastos = $this->Conta->Gasto->find('all',
                            array('conditions' =>
                                    array('Gasto.usuario_id' => $user['Usuario']['id'],
                                          'Gasto.status' => '1'),
                                  'fields' => array('Gasto.valor'),
                                  'recursive' => '-1'));
            
            $saldo = $this->Valor->saldo($ganhos,$gastos);
            
            $conta = array(
                'usuario_id' => $user['Usuario']['id'],
                'nome' => 'livre',
                'saldo' => $saldo,
                'tipo' => 'cash'
            );
            
            $this->Conta->create();
            if($this->Conta->save($conta,false)){
                
            }else{
                $this->log('não salvou os dados '.print_r($conta),'erro_criar_contas');
            }
            
            $result[] = array(
                'user' => $user['Usuario']['nome'],
                'saldo' => $saldo
            );
        }
        
        $this->set('result',$result);
        $this->layout = 'ajax';
    }
    
	function index() {
        
        $this->helpers[] = 'Valor';
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
			$this->Conta->create();
			if ($this->Conta->save($this->data)) {
				$this->Session->setFlash(__('The conta has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The conta could not be saved. Please, try again.', true));
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