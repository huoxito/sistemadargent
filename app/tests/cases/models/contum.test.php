<?php
/* Contum Test cases generated on: 2011-01-10 00:01:05 : 1294625945*/
App::import('Model', 'Contum');

class ContumTestCase extends CakeTestCase {
	function startTest() {
		$this->Contum =& ClassRegistry::init('Contum');
	}

	function endTest() {
		unset($this->Contum);
		ClassRegistry::flush();
	}

}
?>