<?php

App::import('Model', 'Usuario'); 

class UsuarioTextCase extends CakeTestCase{
    
    var $fixtures = array(
        'app.usuario','app.ganho','app.gasto','app.fonte',
        'app.destino','app.agendamento','app.sugesto','app.frequencia',
        'app.conta'
    );

    
    function startTest(){
        
        App::import('Security');
        $this->Usuario =& ClassRegistry::init('Usuario');
    }


    function testInsert(){
        
        $data['Usuario'] = array(
            'nome' => 'teste teste tes te',
            'login' => 'huoxito',
            'email' => 'huoxito@mail.com',
            'passwd' => '126546542',
            'numdeacessos' => 1,
            'ultimologin' => date('Y-m-d H:i:s')
        );

        $result = $this->Usuario->save($data);
        $this->assertTrue($result);
    }
         
}



