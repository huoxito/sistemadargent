<?php
/* Conta Fixture generated on: 2011-01-31 23:22:26 : 1296523346 */
class ContaFixture extends CakeTestFixture {
	var $name = 'Conta';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'usuario_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'nome' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'saldo' => array('type' => 'float', 'null' => true, 'default' => NULL),
		'tipo' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'status' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'usuario_id' => array('column' => 'usuario_id', 'unique' => 0)),
		'tableParameters' => array()
	);

	var $records = array(
		array(
			'id' => 1,
			'usuario_id' => 1,
			'nome' => 'Lorem ipsum dolor sit amet',
			'saldo' => 1,
			'tipo' => 'Lorem ipsum dolor sit amet',
			'created' => '2011-01-31 23:22:26',
			'modified' => '2011-01-31 23:22:26',
			'status' => 1
		),
	);
}
?>