<?php
/* Frequencia Fixture generated on: 2011-01-31 23:22:26 : 1296523346 */
class FrequenciaFixture extends CakeTestFixture {
	var $name = 'Frequencia';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'nome' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 120, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'status' => array('type' => 'boolean', 'null' => true, 'default' => '1'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array()
	);

	var $records = array(
		array(
			'id' => 1,
			'nome' => 'Lorem ipsum dolor sit amet',
			'created' => '2011-01-31 23:22:26',
			'modified' => '2011-01-31 23:22:26',
			'status' => 1
		),
	);
}
?>