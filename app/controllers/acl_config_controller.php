<?php

class AclConfigController extends AppController {
    
    var $uses = array('Usuario');
    
    
    function beforeFilter(){
        
        if($this->Acl->check($this->Auth->user('login'), 'root')){
            continue;
        }else{
            $this->redirect(array('controller' => '/', 'action' => 'perfil'));
        }
    }
    
    
    function addRoot(){
        
        $aro = new Aro();
        $users = array(
            0 => array(
                'alias' => 'godfather',
                'parent_id' => 25,
                'model' => 'Usuario',
                'foreign_key' => 25,
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
            $aro->save($data);
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
                'parent_id' => 25
            ),
            1 => array(
                'alias' => 'admin',
                'parent_id' => 25
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
                'parent_id' => 26,
                'model' => 'Usuario'
            ),
            1 => array(
                'alias' => 'ganho',
                'parent_id' => 26,
                'model' => 'Ganho'
            ),
            2 => array(
                'alias' => 'gasto',
                'parent_id' => 26,
                'model' => 'Gasto'
            ),
            3 => array(
                'alias' => 'destino',
                'parent_id' => 26,
                'model' => 'Destino'
            ),
            4 => array(
                'alias' => 'fonte',
                'parent_id' => 26,
                'model' => 'Fonte'
            ),
            5 => array(
                'alias' => 'agendamento',
                'parent_id' => 26,
                'model' => 'Agendamento'
            ),
            6 => array(
                'alias' => 'sugestao',
                'parent_id' => 26,
                'model' => 'Sugestao'
            ),
            7 => array(
                'alias' => 'frequencia',
                'parent_id' => 27,
                'model' => 'Frequencia'
            ),
            8 => array(
                'alias' => 'valormensal',
                'parent_id' => 26,
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
        
        $this->Acl->allow('root','root');
        $this->Acl->allow('admin','admin');
        $this->Acl->allow('users','users');
        
        $this->autoRender = false;
    }
    

}