<?php
class M4d40e57b27984d7fa9210b11577d0345 extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 * @access public
 */
	public $description = '';

/**
 * Actions to be performed
 *
 * @var array $migration
 * @access public
 */
	public $migration = array(
		'up' => array(
			'create_field' => array(
				'agendamentos' => array(
					'conta_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
				),
				'ganhos' => array(
					'conta_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
				),
				'gastos' => array(
					'conta_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
				),
			),
			'create_table' => array(
				'contas' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
					'usuario_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
					'nome' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'saldo' => array('type' => 'float', 'null' => true, 'default' => NULL),
					'tipo' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'status' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
						'usuario_id' => array('column' => 'usuario_id', 'unique' => 0),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
			),
			'alter_field' => array(
				'usuarios' => array(
					'tableParameters' => array('engine' => 'InnoDB'),
				),
			),
		),
		'down' => array(
			'drop_field' => array(
				'agendamentos' => array('conta_id',),
				'ganhos' => array('conta_id',),
				'gastos' => array('conta_id',),
			),
			'drop_table' => array(
				'contas'
			),
			'alter_field' => array(
				'usuarios' => array(
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM'),
				),
			),
		),
	);

/**
 * Before migration callback
 *
 * @param string $direction, up or down direction of migration process
 * @return boolean Should process continue
 * @access public
 */
	public function before($direction) {
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction, up or down direction of migration process
 * @return boolean Should process continue
 * @access public
 */
	public function after($direction) {
		return true;
	}
}
?>