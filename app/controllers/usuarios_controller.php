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
                    
                        $this->Session->setFlash(__('Bem vindo '.$this->data['Usuario']['nome'].' !', true));
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
        
        
        function addUsers(){
            
            $aro = new Aro();
            $users = array(
                0 => array(
                    'alias' => 'godfather',
                    'parent_id' => 2,
                    'model' => 'Usuario',
                    'foreign_key' => 25,
                ),
                1 => array(
                    'alias' => 'luis123',
                    'parent_id' => 1,
                    'model' => 'Usuario',
                    'foreign_key' => 72,
                )
            );
            
            foreach($users as $data)
            {
                $aro->create();
                $aro->save($data);
            }
            
            $this->autoRender = false; 
        }
        
        
        function setUpAcl(){
            
            $aro =& $this->Acl->Aro;
            $aroGroups = array(
                0 => array(
                    'alias' => 'users'
                ),
                1 => array(
                    'alias' => 'godfather'
                )
            );
        
            foreach($aroGroups as $data)
            {
                $aro->create();
                $aro->save($data);
            }
            
            $aco =& $this->Acl->Aco;
            $acoGroups = array(
                0 => array(
                    'alias' => 'users'
                ),
                1 => array(
                    'alias' => 'godfather'
                )
            );
            
            foreach($acoGroups as $data)
            {
                
                $aco->create();
                $aco->save($data);
            }
            
            $acoSubGroups = array(
                0 => array(
                    'alias' => 'usuario',
                    'parent_id' => 1,
                    'model' => 'Usuario'
                ),
                1 => array(
                    'alias' => 'ganho',
                    'parent_id' => 1,
                    'model' => 'Ganho'
                ),
                2 => array(
                    'alias' => 'gasto',
                    'parent_id' => 1,
                    'model' => 'Gasto'
                ),
                3 => array(
                    'alias' => 'destino',
                    'parent_id' => 1,
                    'model' => 'Destino'
                ),
                4 => array(
                    'alias' => 'fonte',
                    'parent_id' => 1,
                    'model' => 'Fonte'
                ),
                5 => array(
                    'alias' => 'agendamento',
                    'parent_id' => 1,
                    'model' => 'Agendamento'
                ),
                6 => array(
                    'alias' => 'sugestao',
                    'parent_id' => 1,
                    'model' => 'Sugestao'
                ),
                7 => array(
                    'alias' => 'frequencia',
                    'parent_id' => 2,
                    'model' => 'Frequencia'
                ),
                8 => array(
                    'alias' => 'valormensal',
                    'parent_id' => 1,
                    'model' => 'Valormensal'
                )
            );
            
            foreach($acoSubGroups as $data)
            {
                $aco->create();
                $aco->save($data);
            }
            
            $this->autoRender = false;
            
        }
        
        
        function setPermissions(){
            
            $this->Acl->deny('users','godfather');
            $this->Acl->deny('users','users','delete');
            $this->Acl->deny('users','users','delete');
            
            //$this->Acl->allow('godfather','godfather');
            
            //$this->Acl->deny('users', array('model' => 'Ganho', 'foreign_key' => 72));
            //$this->Acl->deny('users', 'Usuario', 'delete');
            //$this->Acl->deny('users', 'Frequencia');
            
            $this->autoRender = false;
        }
        
    }
    

?>