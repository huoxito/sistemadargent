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
        if (!empty($this->request->data)) {

            $this->Usuario->create();
            $this->Usuario->set(array(
                'numdeacessos' => 1, 'ultimologin' => date('Y-m-d H:i:s'),
                'email'  => $this->request->data["Usuario"]["email_register"]
            ));
            if ($this->Usuario->save($this->request->data)) {

                $regNewId = $this->Usuario->getLastInsertID();
                $login = array_merge($this->request->data["Usuario"], array('id' => $regNewId));
                if($this->Auth->login($login)){
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

        if (!empty($this->request->data)) {

            $this->Usuario->set( $this->request->data );

            $this->Usuario->recursive = -1;
            $info = $this->Usuario->findByEmail($this->request->data['Usuario']['email']);

            if($info){

                $hash = sha1(time().$info['Usuario']['created'].'.,>');

                $this->Usuario->id = $info['Usuario']['id'];
                $this->Usuario->saveField('hash', $hash);

                $this->Email->to = $this->request->data['Usuario']['email'];
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
            throw new NotFoundException();
        }

        $this->layout = 'signup';
    }

    function insereInput(){
        if($this->request->params['isAjax']){

            $this->set('value',$this->request->params['url']['value']);
            $this->set('campo',$this->request->params['url']['campo']);
            $this->layout = 'ajax';
        }
    }

    function editResponse() {

        if($this->request->params['isAjax']){

            if( $this->request->params['url']['campo'] === 'Name' ){
                $campo = 'nome';
            }else{
                $campo = 'email';
            }

            $this->Usuario->id = $this->Auth->user('id');
            $this->request->data['Usuario'][$campo] = $this->request->params['url']['value'];
            if ( $this->Usuario->save($this->request->data, true, array($campo)) ){

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

        if (!empty($this->request->data)){

            # adiciona o id no array $this->request->data['Usuario']
            $this->request->data['Usuario']['id'] = $this->Auth->user('id');
            if ($this->Usuario->save($this->request->data)) {
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

        if($this->request->is('post')){
            if($this->Auth->login()){
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
/*
 * Adiciono esse método para evitar erro se o usuário tentar entrar diretamente
 * em uma url do sistema sem estar logado. Ele será redirecionado para esse método
 * mas a login de fato ocorrerá no método signin
 */
    function login(){
        $this->layout = "home";
    }

    function delete($id = null) {

        if( $this->Acl->check( array('model' => 'Usuario', 'foreign_key' => $this->Auth->user('id') ), 'root') ){
            # you root !
        }else{
            throw new NotFoundException();
        }

        if (!$id) {
            $this->Session->setFlash(__('Invalid id for Usuario'));
            $this->redirect(array('action'=>'index'));
        }
        if ($this->Usuario->delete($id)) {
            $this->Session->setFlash(__('Usuario deleted'));
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
                throw new NotFoundException();
            }
            Cache::write('usr_index_'.$this->user_id, $chk, 'long');
        }elseif($value === 'out'){
            throw new NotFoundException();
        }

        $usuarios = $this->paginate('Usuario');
        $this->set(compact('usuarios'));
    }
    
    function excluirMovimentacoes(){
        
        if( $this->request->params['isAjax'] ){
            
            $result = $this->Usuario->excluirMovimentacoes($this->user_id); 
            echo json_encode($result); 
            $this->autoRender = false; 
        }else{
            $this->layout = 'colorbox';
        }
    }
        
    function excluirCategorias(){
        
        if( $this->request->params['isAjax'] ){
            
            $result = $this->Usuario->excluirCategorias($this->user_id); 
            echo json_encode($result); 
            $this->autoRender = false; 
        }else{
            $this->layout = 'colorbox';
        }
    }
    
    function excluirConta(){
        
        if( $this->request->params['isAjax'] ){
            
            $result = $this->Usuario->excluirConta($this->user_id); 
            if($result){
                echo json_encode($result); 
                $this->Auth->logout();
                $this->Session->setFlash('Conta excluída com sucesso.');
            }
            //$this->layout = 'ajax';
            $this->autoRender = false; 
        }else{
            $this->layout = 'colorbox';
        }
    }


}


?>
