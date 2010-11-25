<?php
/*
 *  Script deve ser rodado na instalação do sistema, antes que qualquer usuário seja cadastrado.
 *  As tabelas de Acl devem estar limpas, truncadas, vazias.
 *  Senha do usuário godfather (root) deve ser alterada logo após execução do script
 *  Descomentar método beforeFilter abaixo
 * 
 *  Ações
 *  Seta a tree de usuário (Aro) [root] => ([admin] => [administradores],
 *                                          [users] => [usuarios do sistema])
 *  Seta a tree de dados (Aco) [root] => ([admin] => [acoes dos admins],
 *                                        [users] => [acoes dos usuarios])
 *  Cadastra usuário root ( godfather )
 */
class AclConfigController extends AppController {
    
    var $uses = array('Usuario');
    
    /*
    function beforeFilter(){
        parent::beforeFilter();
        
        if($this->Acl->check(array('model' => 'Usuario', 'foreign_key' => $this->Auth->user('id')), 'root')){
            # you root !
        }else{
            $this->cakeError('error404');  
        }
    }
    */    
    
    function index(){
        
        $aro =& $this->Acl->Aro;
        $aroRoot = array(
            0 => array(
                'alias' => 'root'
            ),
            1 => array(
                'alias' => 'users'
            ),
            2 => array(
                'alias' => 'admin'
            )
        );
    
        foreach($aroRoot as $data)
        {
            $aro->create();
            if($aro->save($data)){
                
            }else{
                $error = $this->validateErrors($aro);
                $this->pa($error);
                exit;
            }
        }
        
        $aco =& $this->Acl->Aco;
        $acoRoot = array(
            0 => array(
                'alias' => 'root'
            )
        );
    
        foreach($acoRoot as $data)
        {
            $aco->create();
            $aco->save($data);
        }
        
        $acoGroups = array(
            0 => array(
                'alias' => 'users',
                'parent_id' => 1
            ),
            1 => array(
                'alias' => 'admin',
                'parent_id' => 1
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
                'parent_id' => 2,
                'model' => 'Usuario'
            ),
            1 => array(
                'alias' => 'ganho',
                'parent_id' => 2,
                'model' => 'Ganho'
            ),
            2 => array(
                'alias' => 'gasto',
                'parent_id' => 2,
                'model' => 'Gasto'
            ),
            3 => array(
                'alias' => 'destino',
                'parent_id' => 2,
                'model' => 'Destino'
            ),
            4 => array(
                'alias' => 'fonte',
                'parent_id' => 2,
                'model' => 'Fonte'
            ),
            5 => array(
                'alias' => 'agendamento',
                'parent_id' => 2,
                'model' => 'Agendamento'
            ),
            6 => array(
                'alias' => 'sugestao',
                'parent_id' => 2,
                'model' => 'Sugestao'
            ),
            7 => array(
                'alias' => 'frequencia',
                'parent_id' => 3,
                'model' => 'Frequencia'
            )
        );
        
        foreach($acoSubGroups as $data)
        {
            $aco->create();
            $aco->save($data);
        }
        
        $this->redirect(array('action' => 'setPermissions'));
        $this->autoRender = false;
    }
    
    
    function setPermissions(){
        
        $this->Acl->allow('root','root');
        $this->Acl->allow('admin','admin');
        $this->Acl->allow('users','users');
        
        $this->redirect(array('action' => 'insertUsers'));
        $this->autoRender = false;
    }
    
    
    function insertUsers(){
        
        
        $this->Usuario->recursive = -1;
        $usuarios = $this->Usuario->find('all',
                                array('conditions' => array('Usuario.login !=' => 'godfather'),
                                      'order' => 'Usuario.id ASC'));
        
        foreach($usuarios as $row){
            
            $chkUser = $this->Acl->Aro->find('count',
                                array('conditions' => array('Aro.foreign_key' => $row['Usuario']['id'])));
            
            if( $chkUser >= 1 ){
                // there already
            }else{
                
                $data['Aro'] = array(
                        'alias' => null,
                        'parent_id' => 2,  # users 
                        'model' => 'Usuario',
                        'foreign_key' => $row['Usuario']['id']
                );
                
                $this->Acl->Aro->create();
                if( $this->Acl->Aro->save($data) ){
                    # Usuário migrado para a tabela aros no nível users
                }else{
                    $error = $this->validateErrors($this->Acl->Aro);
                    $this->log($error,'erro migracao de usuarios pra aros');
                }
            }
        }
        
        $this->redirect(array('action' => 'addRoot'));
        $this->autoRender = false;
    }
    
    
    function addRoot(){
        
        $root = array('Usuario' =>
                      array('nome' => 'GodFather',
                            'email' => 'godfather@mail.com',
                            'login' => 'godfather',
                            'passwd' => 'godfather',
                            'passwd_confirm' => 'godfather'));
        if($this->Usuario->save($root)){
            // yeah !
        }else{
            $errors = $this->validateErrors($this->Usuario);
            $this->log($errors,'erro inserir usuario root');
        }
        
        $aro = $this->Acl->Aro->find('all');
        $aco = $this->Acl->Aco->find('all');
        
        $this->pa($aro);
        $this->pa($aco);
        
        $this->autoRender = false; 
    }
    
}