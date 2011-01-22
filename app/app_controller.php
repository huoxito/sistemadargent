<?php

class AppController extends Controller{
    
    var $components = array('Session', 'Auth','RequestHandler', 'Acl');
    var $helpers = array('Js' => array('Jquery'), 'Session', 'Time', 'Cache','Valor');  
    
    function beforeFilter(){
        parent::beforeFilter();
    
        $this->Auth->allow('cadastro', 'login','enviarSenha','confirmarNovaSenha');
        $this->Auth->userModel = 'Usuario';
        $this->Auth->fields = array('username' => 'login', 'password' => 'password');
        $this->Auth->userScope = array('Usuario.status' => 1);
        $this->Auth->loginError = "Login ou senha incorretos";
        $this->Auth->loginAction = array('admin' => false, 'controller' => 'usuarios', 'action' => 'login');
        $this->Auth->loginRedirect = array('controller' => 'usuarios', 'action' => 'afterLogin');
        $this->Auth->authError = "Log in para entrar no sistema";
        
        $this->user_id = $this->Auth->user('id');
        /* condição pra mudar a renderização do menu lateral */
        if($this->Auth->user('login') === 'godfather'){
            $godfather = true;
        }else{
            $godfather = false;
        }
        $this->set('godfather',$godfather);
    }   
    
    function search(){
            
        // thanks to Christophe Cholot - http://www.formation-cakephp.com/30/pagination-avec-criteres-de-filtrage-complexes
        // exclusion du 1er argument de $this->params['url'] (l'URL courante)
        array_shift($this->params['url']);
        $passedArgs = array();

        // exclusion des données nulles
        $criterias = array_filter(
            $this->params['url'],
            create_function(
              '$item',
              'return !empty($item);'
            )
        );
       
        // transformation des données au format du Paginator
        foreach($criterias as $key => $value)
        {
            array_push($passedArgs, $key . ':' . urlencode($value));
        }
        
        // redirect vers la Vue, en passant en argument les critères de recherche retenus.
        $this->redirect('index/'.join('/', $passedArgs));
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
                    'base' => $this->base
                );
                $this->cakeError('error',$opts);
            }
        }else{
            return true;
        }
    }
    
    # retorna id da nova categoria ou de uma já criada
    function addCategoria($nome,$categoria,$model){
        
        $this->$model->$categoria->recursive = -1;
        $chk = $this->$model->$categoria->find('first',
                                   array('conditions' =>
                                         array($categoria.'.nome' => $nome,
                                                $categoria.'.usuario_id' => $this->Auth->user('id'))));
        
        if ( !isset($chk[$categoria]['nome']) ){
            # se não houver uma fonte com o mesmo nome
            $this->$model->$categoria->set(array('nome' => $nome,
                                                'usuario_id' => $this->Auth->user('id')));
            if($this->$model->$categoria->save()){
                return $this->$model->$categoria->id;
            }else{
                return 'error';
            }
        
        }else{
            # retorna id da fonte que já existia
            return $chk[$categoria]['id'];
        }
    }
    
/*
 * Imprimir array formatado
 */
    function _pa($array){
        echo '<pre>';
        print_r($array);
        echo '</pre>';
    }
    
}

?>