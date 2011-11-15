<?php

App::import('Model', 'Conta');

class MoveTest extends CakeTestCase {

    var $fixtures = array(
        'app.usuario', 'app.conta', 'app.categoria'
    );

    function startCase(){
        $this->Move =& ClassRegistry::init('Move');
    }
    
    function testInsert(){
        
        $input = array(
            'Move' => array(
                'tipo' => 'Faturamento', 'usuario_id' => 1, 'categoria_id' => 1,
                'valor' => '50.50', 'conta_id' => 1, 'data' => '05-08-2011',
                'config' => 0
            )
        );
        $result = $this->Move->adicionar($input); 
        $this->assertTrue($result);

        $this->Move->Conta->id = 1;
        $this->Move->Conta->Behaviors->disable('Modifiable');
        $saldo = $this->Move->Conta->field('saldo');

        $this->assertEqual($saldo, 150.50);

        $input = array(
            'Move' => array(
                'tipo' => 'Despesa', 'usuario_id' => 1, 'categoria_id' => 1,
                'valor' => '50.50', 'conta_id' => 2, 'data' => '05-08-2011',
                'config' => 0
            )
        );
        $result = $this->Move->adicionar($input); 
        $this->assertTrue($result);

        $this->Move->Conta->id = 2;
        $this->Move->Conta->Behaviors->disable('Modifiable');
        $saldo = $this->Move->Conta->field('saldo');

        $this->assertEqual($saldo, 149.50);
    }

}
