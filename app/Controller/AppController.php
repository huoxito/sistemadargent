<?php
class AppController extends Controller{
    
    var $components = array('Session', 'Auth','RequestHandler', 'Acl');
    var $helpers = array('Form', 'Html', 'Js' => array('Jquery'), 'Session', 'Time', 'Cache','Valor');  
    
    function beforeFilter(){
        parent::beforeFilter();
    
        $this->Auth->allow('cadastro', 'signin','enviarSenha','confirmarNovaSenha');
        $this->Auth->authenticate = array(
            'Form' => array('userModel' => 'Usuario', 'fields' => array('username' => 'email'))
        );
        
        $this->user_id = $this->Auth->user('id');
        /* condição pra mudar a renderização do menu lateral */
        if($this->Auth->user('login') === 'godfather'){
            $godfather = true;
        }else{
            $godfather = false;
        }
        $this->set('godfather',$godfather);
    }   
    
    // thanks to http://nuts-and-bolts-of-cakephp.com/2009/04/30/give-all-of-your-error-messages-a-different-layout/
    function beforeRender () {
        $this->_setErrorLayout();
    }
    function _setErrorLayout() {
        if($this->name == 'CakeError') {
            $this->layout = 'error';
        }
    }
    
    # usuario só pode ver seus registros
    function checkPermissao($usuarioId,$ajax=false){
        if($usuarioId != $this->Auth->user('id')){
            if($ajax){
                # trato a resposta no próprio arquivo
                return false;
            }else{
                $opts = array(
                    'name' => 'Página não encontrada',
                    'code' => 404,
                    'message' => '',
                    'base' => $this->request->base
                );
                $this->cakeError('error',$opts);
            }
        }else{
            return true;
        }
    }
    
}

?>
