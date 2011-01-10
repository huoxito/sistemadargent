<?php
/* Contas Test cases generated on: 2011-01-10 00:01:10 : 1294625950*/
App::import('Controller', 'Contas');

class TestContasController extends ContasController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class ContasControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.conta', 'app.usuario', 'app.ganho', 'app.fonte', 'app.agendamento', 'app.frequencia', 'app.destino', 'app.gasto', 'app.sugestao');

	function startTest() {
		$this->Contas =& new TestContasController();
		$this->Contas->constructClasses();
	}

	function endTest() {
		unset($this->Contas);
		ClassRegistry::flush();
	}

	function testIndex() {

	}

	function testView() {

	}

	function testAdd() {

	}

	function testEdit() {

	}

	function testDelete() {

	}

}
?>