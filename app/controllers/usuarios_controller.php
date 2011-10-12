<?php

class UsuariosController extends AppController {

    var $name = 'Usuarios';
    var $helpers = array('Html', 'Form','Data');
    var $components = array('Email');

    function perfil() {

        $this->Usuario->recursive = -1;
        $itens = $this->Usuario->find('first',
                                    array('conditions' => array('id' => $this->Auth->user('id'))));
        $this->set('item',$itens);
    }

    function cadastro() {

        if($this->Auth->user()){
            $this->redirect(array('controller' => 'moves', 'action'=>'index'));
        }

        $this->loadModel('Usuario');
        if (!empty($this->data)) {

            $this->Usuario->create();
            $this->Usuario->set(array('numdeacessos' => 1, 'ultimologin' => date('Y-m-d H:i:s')));
            if ($this->Usuario->save($this->data)) {

                $regNewId = $this->Usuario->getLastInsertID();
                if($this->Auth->login($this->Usuario->read(null,$regNewId))){
                    
                    $conta = array(
                        'usuario_id' => $this->Usuario->id,
                        'nome' => 'livre',
                        'saldo' => '0',
                        'tipo' => 'cash'
                    );
                    $this->Usuario->Conta->save($conta,false);
                    
                    $this->Session->setFlash(
                        'Bem vindo ! Navegue no menu lateral para conhecer o sistema e começar a inserir os dados',
                        'flash_success'
                    );
                    $this->redirect(array('controller' => 'moves', 'action'=>'index'));
                }else{
                    $this->Session->setFlash('Falha ao logar usuário');
                }

            } else {
                $errors = $this->validateErrors($this->Usuario);
            }
        }
        $this->layout = 'home';
        $this->render('login');
    }

    function enviarSenha(){

        if($this->Auth->user()){
            $this->redirect(array('controller' => 'moves', 'action'=>'index'));
        }

        if (!empty($this->data)) {

            $this->Usuario->set( $this->data );

            $this->Usuario->recursive = -1;
            $info = $this->Usuario->findByEmail($this->data['Usuario']['email']);

            if($info){

                $hash = sha1(time().$info['Usuario']['created'].'.,>');

                $this->Usuario->id = $info['Usuario']['id'];
                $this->Usuario->saveField('hash', $hash);

                $this->Email->to = $this->data['Usuario']['email'];
                $this->Email->subject = 'Envio de senha';
                $this->Email->replyTo = null;
                $this->Email->from = 'Sistema Dargent <admin@sistemadargent.com.br>';
                $this->Email->template = 'senha';
                $this->Email->sendAs = 'html';
                //$this->Email->delivery = 'debug';
                $this->set('info', $info);
                $this->set('hash', $hash);
                $this->Email->send();

                $this->Session->setFlash('
                    Enviamos um email para o endereço indicado com as instruções
                    para gerar sua senha. <br /> Caso o email não apareça na caixa
                    de entrada, confira a pasta de spams ou lixo do seu email.',
                    'flash_success'
                );
            }else{
                $this->Session->setFlash('Seu email não foi encontrado em nosso banco','flash_error');
            }
        }

        $this->layout = 'signup';
    }

    function confirmarNovaSenha($hash){

        if($this->Auth->user()){
            $this->redirect(array('controller' => 'moves', 'action'=>'index'));
        }

        $info = $this->Usuario->findByHash($hash);
        if($info){

            $hash = sha1(time().$info['Usuario']['nome'].'.,>');
            $senhaProvisoria = substr($hash,2,8);
            $senhaProvisoriaHash = Security::hash($senhaProvisoria, null, true);

            $this->Usuario->id = $info['Usuario']['id'];
            $this->Usuario->saveField('password', $senhaProvisoriaHash, false);

            $this->set('senha',$senhaProvisoria);
            $this->set('info',$info);
        }else{
            $this->cakeError('error404');
        }

        $this->layout = 'signup';
    }

    function insereInput(){
        if($this->params['isAjax']){

            $this->set('value',$this->params['url']['value']);
            $this->set('campo',$this->params['url']['campo']);
            $this->layout = 'ajax';
        }
    }

    function editResponse() {

        if($this->params['isAjax']){

            if( $this->params['url']['campo'] === 'Name' ){
                $campo = 'nome';
            }else{
                $campo = 'email';
            }

            $this->Usuario->id = $this->Auth->user('id');
            $this->data['Usuario'][$campo] = $this->params['url']['value'];
            if ( $this->Usuario->save($this->data, true, array($campo)) ){

                $this->Usuario->id = $this->Auth->user('id');
                $value = $this->Usuario->field($campo);

                $this->Session->write('Auth.Usuario.'.$campo, $value);
                $this->set('campo',$campo);
                $this->layout = 'ajax';
            }else{

                //$errors = $this->validateErrors($this->Usuario);
                echo 'validacao'; exit;
            }
        }
    }

    function imageResponseP(){
        $this->layout = 'ajax';
    }
    function imageResponseT(){
        $this->layout = 'ajax';
    }

    function mudarSenha(){

        if (!empty($this->data)){

            # adiciona o id no array $this->data['Usuario']
            $this->data['Usuario']['id'] = $this->Auth->user('id');
            if ($this->Usuario->save($this->data)) {
                $this->Session->setFlash('Senha atualizada com sucesso','flash_success');
                $this->redirect(array('action'=>'perfil'));
            } else {
                $errors = $this->validateErrors($this->Usuario);
                $this->Session->setFlash('Preencha os campos corretamente','flash_error');
            }
        }
    }
/*
 * Logo usuário manualmente. Isso evita confusão entre os forms na home.
 */
    function signin(){

        if($this->data){
            $data = array(
                'email' => $this->data["Usuario"]["username"], 
                'password' => $this->Auth->password($this->data["Usuario"]["password"])
            );
            if($this->Auth->login($data)){
                $dados = array('numdeacessos' => 'numdeacessos+1', 'ultimologin' => '\''.date('Y-m-d H:i:s').'\'');
                $this->Usuario->updateAll($dados, array('Usuario.id' => $this->Auth->user('id')));
            }else{
                $this->Session->setFlash('Email ou senha inválidos');
            }
        }

        if($this->Auth->user()){
            $this->redirect(array('controller' => 'moves', 'action'=>'index'));
        }

        $this->layout = 'home';
        $this->render('login');
        $this->set('title_for_layout', 'Login');
    }

    function logout(){
        $this->Auth->logout();
        $this->redirect(array('action' => 'signin'));
    }


    function delete($id = null) {

        if( $this->Acl->check( array('model' => 'Usuario', 'foreign_key' => $this->Auth->user('id') ), 'root') ){
            # you root !
        }else{
            $this->cakeError('error404');
        }

        if (!$id) {
            $this->Session->setFlash(__('Invalid id for Usuario', true));
            $this->redirect(array('action'=>'index'));
        }
        if ($this->Usuario->delete($id)) {
            $this->Session->setFlash(__('Usuario deleted', true));
            $this->redirect(array('action'=>'index'));
        }
    }

    function index(){

        $this->paginate = array(
            'limit' => 25,
            'recursive' => -1,
            'order' => 'created desc');

        $value = Cache::read('usr_index_'.$this->user_id, 'long');
        if ($value === false) {
            $chk = $this->Acl->check(array('model' => 'Usuario', 'foreign_key' => $this->user_id), 'root');
            if(!$chk){
                Cache::write('usr_index_'.$this->user_id, 'out', 'long');
                $this->cakeError('error404');
            }
            Cache::write('usr_index_'.$this->user_id, $chk, 'long');
        }elseif($value === 'out'){
            $this->cakeError('error404');
        }

        $usuarios = $this->paginate('Usuario');
        $this->set(compact('usuarios'));
    }
    
    function excluirMovimentacoes(){
        
        if( $this->params['isAjax'] ){
            
            $result = $this->Usuario->excluirMovimentacoes($this->user_id); 
            echo json_encode($result); 
            $this->autoRender = false; 
        }else{
            $this->layout = 'colorbox';
        }
    }
        
    function excluirCategorias(){
        
        if( $this->params['isAjax'] ){
            
            $result = $this->Usuario->excluirCategorias($this->user_id); 
            echo json_encode($result); 
            $this->autoRender = false; 
        }else{
            $this->layout = 'colorbox';
        }
    }
    
    function excluirConta(){
        
        if( $this->params['isAjax'] ){
            
            $result = $this->Usuario->excluirConta($this->user_id); 
            if($result){
                echo json_encode($result); 
                $this->Auth->logout();
            }
            //$this->layout = 'ajax';
            $this->autoRender = false; 
        }else{
            $this->layout = 'colorbox';
        }
    }


}


?>
