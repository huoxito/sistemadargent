<?php

App::uses('Model', 'Usuario'); 
App::uses('AuthComponent', 'Controller/Component'); 

class UsuarioTextCase extends CakeTestCase{
    
    var $fixtures = array(
        'app.usuario', 'app.conta'
    );
    
    function setUp(){
        $this->Usuario = ClassRegistry::init('Usuario');
    }

    function testInsert(){
        
        $data['Usuario'] = array(
            'nome' => 'teste teste tes te',
            'email' => 'huoxito@mail.com',
            'passwd' => '126546542',
            'passwd_confirm' => '126546542',
            'numdeacessos' => 1,
            'ultimologin' => date('Y-m-d H:i:s')
        );

        $this->Usuario->save($data);
        $this->assertEqual(3, $this->Usuario->id);
    }
         
}



