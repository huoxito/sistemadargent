<?php
class FrequenciasController extends AppController {

	var $name = 'Frequencias';
	var $helpers = array('Html', 'Form');
    
    
    function beforeFilter(){
        parent::beforeFilter();
        
        if($this->Acl->check($this->Auth->user('login'), 'root')){
            # you root !!
        }else{
            $this->cakeError('error404');  
        }
    }
    
	function index() {
         
        $this->Frequencia->recursive = 0;
        $this->set('frequencias', $this->paginate());
    }

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Frequencia', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('frequencia', $this->Frequencia->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Frequencia->create();
			if ($this->Frequencia->save($this->data)) {
				$this->Session->setFlash(__('The Frequencia has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Frequencia could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Frequencia', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Frequencia->save($this->data)) {
				$this->Session->setFlash(__('The Frequencia has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Frequencia could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Frequencia->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Frequencia', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Frequencia->del($id)) {
			$this->Session->setFlash(__('Frequencia deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Frequencia was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>