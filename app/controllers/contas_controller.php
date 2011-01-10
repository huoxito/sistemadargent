<?php
class ContasController extends AppController {

	var $name = 'Contas';

	function index() {
		$this->Conta->recursive = 0;
		$this->set('contas', $this->paginate());
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