<?php
/* SchemaMigration Fixture generated on: 2011-01-31 23:22:27 : 1296523347 */
class SchemaMigrationFixture extends CakeTestFixture {
	var $name = 'SchemaMigration';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'version' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'type' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array()
	);

	var $records = array(
		array(
			'id' => 1,
			'version' => 1,
			'type' => 'Lorem ipsum dolor sit amet',
			'created' => '2011-01-31 23:22:27'
		),
	);
}
?>