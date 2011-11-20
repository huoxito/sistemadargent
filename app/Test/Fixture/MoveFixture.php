<?php
/* Move Fixture generated on: 2011-08-06 18:51:37 : 1312667497 */
class MoveFixture extends CakeTestFixture {
	var $name = 'Move';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'usuario_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'tipo' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 30, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'categoria_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'valor' => array('type' => 'float', 'null' => true, 'default' => NULL),
		'obs' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 250, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'status' => array('type' => 'boolean', 'null' => true, 'default' => NULL),
		'conta_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'data' => array('type' => 'date', 'null' => true, 'default' => NULL),
		'parent_key' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array()
	);

	var $records = array(
		array(
			'id' => 1,
			'usuario_id' => 1,
			'tipo' => 'Faturamento',
			'categoria_id' => 1,
			'valor' => 300,
			'obs' => 'Lorem ipsum dolor sit amet',
			'created' => '2011-08-06 18:51:37',
			'modified' => '2011-08-06 18:51:37',
			'status' => 1,
			'conta_id' => 1,
			'data' => '2011-08-06',
			'parent_key' => null
		),
		array(
			'id' => 2,
			'usuario_id' => 1,
			'tipo' => 'Despesa',
			'categoria_id' => 1,
			'valor' => 100,
			'obs' => 'Lorem ipsum dolor sit amet',
			'created' => '2011-08-06 18:51:37',
			'modified' => '2011-08-06 18:51:37',
			'status' => 1,
			'conta_id' => 1,
			'data' => '2011-08-06',
			'parent_key' => null
		),
	);
}
