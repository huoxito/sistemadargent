<?php

App::import('Model', 'Usuario'); 

class UsuarioTextCase extends CakeTestCase{
    
    var $fixtures = array('app.usuario','app.ganho','app.gasto','app.fonte',
                            'app.destino','app.agendamento','app.sugesto','app.frequencia',
                           'app.conta' );

    function testFind(){

        $this->Usuario =& ClassRegistry::init('Usuario');
        $result = $this->Usuario->find('all',
                    array('fields' => array('id', 'login'),
                          'recursive' => -1));
        $expected = array(
            array('Usuario' => array('id' => '1', 'login' => 'usuario 1')),
            array('Usuario' => array('id' => '2', 'login' => 'usuario 2')),
            array('Usuario' => array('id' => '3', 'login' => 'usuario 3'))
        );
        
        $this->assertEqual($result, $expected);
    }
         
}



