<?php
/* Agendamento Fixture generated on: 2011-01-31 23:22:26 : 1296523346 */
class AgendamentoFixture extends CakeTestFixture {
	var $name = 'Agendamento';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'usuario_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'model' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 10, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'frequencia_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'fonte_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'destino_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'valor' => array('type' => 'float', 'null' => true, 'default' => NULL),
		'datadevencimento' => array('type' => 'date', 'null' => true, 'default' => NULL),
		'numdeparcelas' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 2),
		'observacoes' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 250, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'status' => array('type' => 'boolean', 'null' => true, 'default' => '1'),
		'conta_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'frequencia_id' => array('column' => 'frequencia_id', 'unique' => 0)),
		'tableParameters' => array()
	);

	var $records = array(
		array(
			'id' => 1,
			'usuario_id' => 1,
			'model' => 'Lorem ip',
			'frequencia_id' => 1,
			'fonte_id' => 1,
			'destino_id' => 1,
			'valor' => 1,
			'datadevencimento' => '2011-01-31',
			'numdeparcelas' => 1,
			'observacoes' => 'Lorem ipsum dolor sit amet',
			'created' => '2011-01-31 23:22:26',
			'modified' => '2011-01-31 23:22:26',
			'status' => 1,
			'conta_id' => 1
		),
	);
}
?>