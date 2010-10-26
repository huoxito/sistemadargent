<?php
    class SugestosController extends AppController {
    
        var $name = 'Sugestos';
        var $helpers = array('Html', 'Form');
        var $components = array('Email');
        
        
        function index() {
            $this->Sugesto->recursive = 0;
            $this->set('sugestos', $this->paginate());
        }
    
        function view($id = null) {
            if (!$id) {
                $this->Session->setFlash(__('Invalid Sugesto', true));
                $this->redirect(array('action' => 'index'));
            }
            $this->set('sugesto', $this->Sugesto->read(null, $id));
        }
        
        
        function _sendEmail($id){       # PRIVATE METHOD?!
            
            $sugestao = $this->Sugesto->read(null, $id);
            
            #### ENVIO DO EMAIL
            $this->Email->to = 'huoxito@gmail.com';
            $this->Email->bcc = array('huoxito@hotmail.com');  
            $this->Email->subject = 'Welcome to our really cool thing';
            $this->Email->replyTo = $sugestao['Usuario']['email'];
            $this->Email->from = 'Cool Web App <admin@testsoh.com.br>';
            $this->Email->template = 'sugestao'; // note no '.ctp'
            //Send as 'html', 'text' or 'both' (default is 'text')
            $this->Email->sendAs = 'both'; // because we like to send pretty mail
            //$this->Email->delivery = 'debug';
            //Set view variables as normal
            $this->set('usuario', $sugestao['Usuario']['nome']);
            $this->set('titulo', $sugestao['Sugesto']['titulo']);
            $this->set('texto', $sugestao['Sugesto']['texto']);
            //Do not pass any args to send()
            $this->Email->send();
            
        
        }
        
        
        function add() {
            
            if (!empty($this->data)) {
                
                $this->Sugesto->create();
                $this->Sugesto->set('usuario_id', $this->Auth->user('id')); # SETO O USUÁRIO LOGADO COMO O RESPONSÁVEL PELO REGISTRO
                if ($this->Sugesto->save($this->data)) {
                    
                    $this->Session->setFlash(__('Sugestão salva com sucesso', true));
                    $this->_sendEmail( $this->Sugesto->id );
                    $this->redirect(array('controller' => 'usuarios', 'action' => 'index'));
                    
                } else {
                    
                    $this->Session->setFlash(__('The Sugesto could not be saved. Please, try again.', true));
                }
            }
            
            $usuarios = $this->Sugesto->Usuario->find('list');
            $this->set(compact('fontes', 'usuarios'));
        }
    
        function edit($id = null) {
            
            if (!$id && empty($this->data)) {
                $this->Session->setFlash(__('Invalid Sugesto', true));
                $this->redirect(array('action' => 'index'));
            }
            if (!empty($this->data)) {
                if ($this->Sugesto->save($this->data)) {
                    $this->Session->setFlash(__('The Sugesto has been saved', true));
                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash(__('The Sugesto could not be saved. Please, try again.', true));
                }
            }
            if (empty($this->data)) {
                $this->data = $this->Sugesto->read(null, $id);
            }
            $fontes = $this->Sugesto->Fonte->find('list');
            $usuarios = $this->Sugesto->Usuario->find('list');
            $this->set(compact('fontes', 'usuarios'));
        
        }
    
        function delete($id = null) {
        
                if (!$id) {
                    $this->Session->setFlash(__('Invalid id for Sugesto', true));
                    $this->redirect(array('action'=>'index'));
                }
                if ($this->Sugesto->del($id)) {
                    $this->Session->setFlash(__('Sugesto deleted', true));
                    $this->redirect(array('action'=>'index'));
                }
                $this->Session->setFlash(__('Sugesto was not deleted', true));
                $this->redirect(array('action' => 'index'));
        
        }
    }
?>