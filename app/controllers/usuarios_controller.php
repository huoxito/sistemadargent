<?php

class UsuariosController extends AppController {

    var $name = 'Usuarios';
    var $helpers = array('Html', 'Form');
    var $components = array('Data');
    
    var $paginate = array(
                'limit' => 10,
                'order' => array(
                    'Usuario.modified' => 'desc'
            )
    );
    
    function perfil() {
        
        $this->Usuario->recursive = -1; 
        $itens = $this->Usuario->find('first',
                                    array('conditions' => array('id' => $this->Auth->user('id'))));
        $this->set('item',$itens);
        
        # loops pra montar as últimas interaçes do usuário
        # faço a consulta nas três tabelas
        $ganhos = $this->Usuario->Ganho->find('all',
                                    array('conditions' =>
                                            array('Ganho.usuario_id' => $this->Auth->user('id'),
                                                  'Ganho.status' => 1),
                                        'limit' => '5',
                                        'group' => 'Ganho.modified',
                                        'order' => 'Ganho.modified desc'));
        
        $gastos = $this->Usuario->Gasto->find('all',
                                    array('conditions' =>
                                            array('Gasto.usuario_id' => $this->Auth->user('id'),
                                                  'Gasto.status' => 1),
                                        'limit' => '5',
                                        'group' => 'Gasto.modified',
                                        'order' => 'Gasto.modified desc'));
        
        $this->Usuario->Agendamento->unbindModel(
            array('hasOne' => array('Valormensal'))
        );
        $agendamentos = $this->Usuario->Agendamento->find('all',
                                    array('conditions' =>
                                            array('Agendamento.usuario_id' => $this->Auth->user('id')),
                                        'limit' => '5',
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
        foreach($objdata as $key => $value){
            
            if($modelsDatas[$key]['model'] === 'Faturamento' || $modelsDatas[$key]['model'] === 'Despesa'){

                $ultimasInteracoes[] = array('Model' => $modelsDatas[$key]['model'],
                                             'datadabaixa' => $this->Data->formata($modelsDatas[$key]['datadabaixa'],'porextenso'),
                                             'valor' => $modelsDatas[$key]['valor'],
                                             'categoria' => $modelsDatas[$key]['categoria'],
                                             'observacoes' => $modelsDatas[$key]['observacoes'],
                                             'modified' => $this->Data->formata($modelsDatas[$key]['data'],'completa')
                                            );
            }else{
                $ultimasInteracoes[] = array('Model' => $modelsDatas[$key]['model'],
                                             'frequencia' => $modelsDatas[$key]['frequencia'],
                                             'valor' => $modelsDatas[$key]['valor'],
                                             'categoria' => $modelsDatas[$key]['categoria'],
                                             'modified' => $this->Data->formata($modelsDatas[$key]['data'],'completa')
                                            );
            }
        }
        
        $this->set('ultimasInteracoes',$ultimasInteracoes);
        
    }

    function cadastro() {
        
        if($this->Auth->user()){
            $this->redirect(array('controller' => 'homes', 'action'=>'index'));
        }
        
        if (!empty($this->data)) {
            
            if( empty($this->data['Usuario']['foto']['name']['tmp_name']) ){
                unset($this->data['Usuario']['foto']);
            }
            
            $this->Usuario->create();
            $this->Usuario->set('numdeacessos',1);
            if ($this->Usuario->save($this->data)) {
                
                $data = array('login' => $this->data['Usuario']['login'],
                              'password' => $this->Auth->password($this->data['Usuario']['passwd']));
                if( $this->Auth->login($data) == 1 ){
                    
                    $registered = $this->Usuario->read(null,$this->Usuario->id);
                    
                    $aro = new Aro(); 
                    $aro->create();
                    $aro->save(array(
                         'model'        => 'Usuario',
                         'foreign_key'    => $this->Usuario->id,
                         'parent_id'    => 1, # users
                         'alias'        => $registered['Usuario']['login']));
                    
                    $this->Session->setFlash(__('Bem vindo '.$registered['Usuario']['nome'].' !', true));
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
    
    function mudarImagem($id = null){
        
        $this->layout = 'colorbox';
        $this->set('title_for_layout', 'Alteração do Avatar');
        
        if (!empty($this->data)) {
            
            //print_r($this->data);
            $this->Usuario->id = $this->Auth->user('id');
            if($this->Usuario->save($this->data, true, array('foto'))){
                
                $this->Usuario->id = $this->Auth->user('id');
                $value = $this->Usuario->field('foto');
                $this->Session->write('Auth.Usuario.foto', $value);
                # executo na view javascript p/ fechar colorbox e mudar imagens no layout
                $this->set('runAjax', true);
            }else{
                
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
                $this->Session->setFlash(__('Senha atualizada !!', true));
                $this->redirect(array('action'=>'perfil'));    
            } else {
                $errors = $this->validateErrors($this->Usuario);  
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
        
        $this->Usuario->id = $this->Auth->user('id');
        $this->Usuario->updateAll($dados);
        
        $this->redirect(array('controller' => 'homes', 'action'=>'index'));
    }
    
    
    function logout(){
        $this->redirect($this->Auth->logout());
    }
    
    
    
    function delete($id = null) {
        
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for Usuario', true));
            $this->redirect(array('action'=>'index'));
        }
        if ($this->Usuario->delete($id)) {
            $this->Session->setFlash(__('Usuario deleted', true));
            //$this->redirect(array('action'=>'index'));
        }
    }
    
    
}


?>