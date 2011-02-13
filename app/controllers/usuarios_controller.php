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

        $registrosPorTabela = 13;
        # loops pra montar as últimas interaçes do usuário
        # faço a consulta nas três tabelas
        $ganhos = $this->Usuario->Ganho->find('all',
                                    array('conditions' =>
                                            array('Ganho.usuario_id' => $this->Auth->user('id'),
                                                  'Ganho.status' => 1),
                                        'limit' => $registrosPorTabela,
                                        'group' => 'Ganho.modified',
                                        'order' => 'Ganho.modified desc'));

        $gastos = $this->Usuario->Gasto->find('all',
                                    array('conditions' =>
                                            array('Gasto.usuario_id' => $this->Auth->user('id'),
                                                  'Gasto.status' => 1),
                                        'limit' => $registrosPorTabela,
                                        'group' => 'Gasto.modified',
                                        'order' => 'Gasto.modified desc'));

        $agendamentos = $this->Usuario->Agendamento->find('all',
                                    array('conditions' =>
                                            array('Agendamento.usuario_id' => $this->Auth->user('id')),
                                        'limit' => $registrosPorTabela,
                                        'order' => 'Agendamento.modified desc'));

        # jogo os resultados das constultas dentro do mesmo array
        $modelsDatas = array();
        foreach($ganhos as $key => $item){
            $modelsDatas[] = array('data' => $item['Ganho']['modified'],
                                   'model' => 'Faturamento',
                                   'valor' => $item['Ganho']['valor'],
                                   'datadabaixa' => $item['Ganho']['datadabaixa'],
                                   'categoria' => $item['Fonte']['nome'],
                                   'observacoes' => $item['Ganho']['observacoes']);
        }

        foreach($gastos as $key => $item){
            $modelsDatas[] = array('data' => $item['Gasto']['modified'],
                                   'model' => 'Despesa',
                                   'valor' => $item['Gasto']['valor'],
                                   'datadabaixa' => $item['Gasto']['datadabaixa'],
                                   'categoria' => $item['Destino']['nome'],
                                   'observacoes' => $item['Gasto']['observacoes']);
        }

        foreach($agendamentos as $key => $item){

            if(!empty($item['Agendamento']['fonte_id'])){
                $categoriaAgendamento = $item['Fonte']['nome'];
            }else{
                $categoriaAgendamento = $item['Destino']['nome'];
            }

            $modelsDatas[] = array('data' => $item['Agendamento']['modified'],
                                   'model' => 'Agendamento',
                                   'valor' => $item['Agendamento']['valor'],
                                   'categoria' => $categoriaAgendamento,
                                   'frequencia' => $item['Frequencia']['nome']);
        }

        # separo o campo modified para ordernar as datas
        $objdata = array();
        foreach($modelsDatas as $key => $data){
            $objdata[] = $data['data'];
        }

        # orderno as datas
        arsort($objdata);

        # organizo um novo array com todos os dados da consulta
        $ultimasInteracoes = array();
        $count  = 1;
        foreach($objdata as $key => $value){

            if($count === $registrosPorTabela){
                break;
            }

            if($modelsDatas[$key]['model'] === 'Faturamento' || $modelsDatas[$key]['model'] === 'Despesa'){

                $ultimasInteracoes[] = array('Model' => $modelsDatas[$key]['model'],
                                             'datadabaixa' => $modelsDatas[$key]['datadabaixa'],
                                             'valor' => $modelsDatas[$key]['valor'],
                                             'categoria' => $modelsDatas[$key]['categoria'],
                                             'observacoes' => $modelsDatas[$key]['observacoes'],
                                             'modified' => $modelsDatas[$key]['data'],'completa'
                                            );
            }else{
                $ultimasInteracoes[] = array('Model' => $modelsDatas[$key]['model'],
                                             'frequencia' => $modelsDatas[$key]['frequencia'],
                                             'valor' => $modelsDatas[$key]['valor'],
                                             'categoria' => $modelsDatas[$key]['categoria'],
                                             'modified' => $modelsDatas[$key]['data']
                                            );
            }
            $count++;
        }

        $this->set('ultimasInteracoes',$ultimasInteracoes);
    }

    function cadastro() {

        if($this->Auth->user()){
            $this->redirect(array('controller' => 'homes', 'action'=>'index'));
        }

        if (!empty($this->data)) {

            $this->Usuario->create();
            $this->Usuario->set(array('numdeacessos' => 1, 'ultimologin' => date('Y-m-d H:i:s')));
            if ($this->Usuario->save($this->data)) {

                $data = array('login' => $this->data['Usuario']['login'],
                              'password' => $this->Auth->password($this->data['Usuario']['passwd']));
                if( $this->Auth->login($data) == 1 ){
                    
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
                    $this->redirect(array('controller' => 'homes', 'action'=>'index'));
                }else{
                    $this->redirect(array('controller' => 'usuarios', 'action'=>'login'));
                }

            } else {
                $errors = $this->validateErrors($this->Usuario);
            }
        }

        $this->layout = 'signup';
    }

    function enviarSenha(){

        if($this->Auth->user()){
            $this->redirect(array('controller' => 'homes', 'action'=>'index'));
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
            $this->redirect(array('controller' => 'homes', 'action'=>'index'));
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

    function login(){

        if($this->Auth->user()){
            $this->redirect(array('controller' => 'homes', 'action'=>'index'));
        }

        $this->layout = 'home';
        $this->set('title_for_layout', 'Login');
    }


    function afterLogin(){

        $dados = array('numdeacessos' => 'numdeacessos+1',
                        'ultimologin' => '\''.date('Y-m-d H:i:s').'\'');

        $this->Usuario->updateAll($dados, array('Usuario.id' => $this->Auth->user('id')));
        if($this->Auth->user('login') === 'godfather'){
            $this->redirect(array('controller' => 'usuarios','action'=>'index'));
        }else{
            $this->redirect(array('controller' => 'homes','action'=>'index'));
        }
    }


    function logout(){
        $this->redirect($this->Auth->logout());
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
