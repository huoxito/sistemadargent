<?php
    class SugestoesController extends AppController {
        
        var $uses = array('Sugestao');
        var $components = array('Email');
        var $paginate = array('order' => 'Sugestao.id DESC');
        
        
        function index() {
            $this->Sugestao->recursive = 0;
            $this->set('sugestos', $this->paginate());
        }
    
        function view($id = null) {
            if (!$id) {
                $this->Session->setFlash(__('Invalid Sugestao', true));
                $this->redirect(array('action' => 'index'));
            }
            $this->set('sugesto', $this->Sugestao->read(null, $id));
        }
        
        
        function _sendEmail($id){   
            
            $sugestao = $this->Sugestao->read(null, $id);
            
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
            $this->set('titulo', $sugestao['Sugestao']['titulo']);
            $this->set('texto', $sugestao['Sugestao']['texto']);
            //Do not pass any args to send()
            $this->Email->send();
            
        
        }
        
        
        function add() {
            
            if (!empty($this->data)) {
                
                //$this->Sugestao->create();
                $this->Sugestao->set('usuario_id', $this->Auth->user('id'));
                if ($this->Sugestao->save($this->data)) {
                    
                    $this->Session->setFlash(__('Sugestão salva com sucesso', true));
                    $this->_sendEmail( $this->Sugestao->id );
                    //$this->redirect(array('controller' => 'sugestoes', 'action' => 'index'));
                    
                } else {
                    
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