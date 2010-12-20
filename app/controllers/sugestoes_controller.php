<?php

class SugestoesController extends AppController {
    
    var $uses = array('Sugestao');
    var $components = array('Email');
    var $paginate = array('order' => 'Sugestao.created DESC');
    
    
    function index() {
        
        $this->paginate = array(
            'conditions' => array('Sugestao.usuario_id' => $this->Auth->user('id')),
            'limit' => 15,
            'order' => array('Sugestao.created' => 'desc')
        );
        
        $this->Sugestao->recursive = 0;
        $sugestoes = $this->paginate('Sugestao');
        $this->set('sugestos', $sugestoes);
    }
    
    function _sendEmail($id){   
        
        $sugestao = $this->Sugestao->read(null, $id);
        
        #### ENVIO DO EMAIL
        $this->Email->to = 'mail@mail.com';
        $this->Email->subject = $sugestao['Sugestao']['titulo'];
        $this->Email->replyTo = $sugestao['Usuario']['email'];
        $this->Email->from = 'Sistema Dargent <admin@sistemadargent.com.br>';
        $this->Email->template = 'sugestao'; 
        $this->Email->sendAs = 'html'; 
        //$this->Email->delivery = 'debug';
        $this->set('usuario', $sugestao['Usuario']['nome']);
        $this->set('titulo', $sugestao['Sugestao']['titulo']);
        $this->set('texto', $sugestao['Sugestao']['texto']);
        $this->Email->send();
    }
    
    
    function add() {
        
        if (!empty($this->data)) {
            
            $this->Sugestao->create();
            $this->Sugestao->set('usuario_id', $this->Auth->user('id'));
            if ($this->Sugestao->save($this->data)) {
                $this->data = null;
                $this->Session->setFlash(__('Sugestão enviada com sucesso', true),'flash_success');
                $this->_sendEmail($this->Sugestao->id);
            } else {
                $this->Session->setFlash('Preencha os campos abaixo corretamente','flash_error');
            }
        }
    }

    function delete($id = null) {
    
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for Sugestao', true));
            $this->redirect(array('action'=>'index'));
        }
        if ($this->Sugestao->del($id)) {
            $this->Session->setFlash(__('Sugestao deleted', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->Session->setFlash(__('Sugestao was not deleted', true));
        $this->redirect(array('action' => 'index'));
    
    }
}

?>