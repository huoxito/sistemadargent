<?php

App::import('Model', 'Conta');


class ContaTestCase extends CakeTestCase {

    var $fixtures = array('app.usuario','app.conta');
    
    function startCase(){
        $this->Conta =& ClassRegistry::init('Conta');
    }
/*
 * Aprendendo a escrever testes
 */
    function testListaSaldoPositivo(){
        
        $result = $this->Conta->listaSaldoPositivo(1);
        $expected = array(1 => 'Bolso', 2 => 'Colchao', 3 => 'Banco');

        $this->assertEqual($result, $expected);
    }
/*
 * Float type is no good for money values
 * This test should not pass.
 */
    function testFloatAccuracy(){

        $this->Conta->id = 2;
        $this->Conta->Behaviors->detach('Modifiable');
        $result = $this->Conta->field('saldo');
        $expected = 19830670.00;

        $this->assertEqual($result, $expected);
    }
/*
 * Testando método para transferências.
 */    
    function testTransferencia(){
        
        $this->Conta->Behaviors->attach('Modifiable');
        $data = array('valor' => 50, 'origem' => 1, 'destino' => 2, 'usuario_id' => 1); 
        $this->Conta->transferencia($data);

        $this->Conta->Behaviors->detach('Modifiable');
        $this->Conta->id = 1;
        $saldoOrigem = $this->Conta->field('saldo'); 

        $this->Conta->id = 2;
        $saldoDestino = $this->Conta->field('saldo'); 

        $this->assertEqual(50, $saldoOrigem);
        $this->assertEqual(250, $saldoDestino);
    }
}
