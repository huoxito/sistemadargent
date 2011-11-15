<?php
class M4e95281515b843b48db525cd577d0345 extends CakeMigration {

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
			'drop_field' => array(
				'usuarios' => array('login'),
			),
			'drop_table' => array(
				'drg_agendamentos', 'drg_destinos', 'drg_fontes', 'drg_frequencias', 'drg_ganhos', 'drg_gastos', 'drg_sugestos'
			),
		),
		'down' => array(
			'create_field' => array(
				'usuarios' => array(
					'login' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 120, 'key' => 'unique', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'indexes' => array(
						'login' => array('column' => 'login', 'unique' => 1),
					),
				),
			),
			'create_table' => array(
				'agendamentos' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
					'usuario_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
					'conta_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
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
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
						'frequencia_id' => array('column' => 'frequencia_id', 'unique' => 0),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'destinos' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
					'usuario_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
					'nome' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 30, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'status' => array('type' => 'boolean', 'null' => true, 'default' => '1'),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
						'usuario_id' => array('column' => 'usuario_id', 'unique' => 0),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'fontes' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
					'usuario_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
					'nome' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 30, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'status' => array('type' => 'boolean', 'null' => true, 'default' => '1'),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
						'usuario_id' => array('column' => 'usuario_id', 'unique' => 0),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'frequencias' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
					'nome' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 120, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'status' => array('type' => 'boolean', 'null' => true, 'default' => '1'),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM'),
				),
				'ganhos' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
					'usuario_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
					'conta_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
					'agendamento_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
					'fonte_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
					'valor' => array('type' => 'float', 'null' => true, 'default' => NULL),
					'datadabaixa' => array('type' => 'date', 'null' => true, 'default' => NULL),
					'datadevencimento' => array('type' => 'date', 'null' => true, 'default' => NULL),
					'observacoes' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 200, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'status' => array('type' => 'boolean', 'null' => true, 'default' => '1'),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
						'fonte_id' => array('column' => 'fonte_id', 'unique' => 0),
						'agendamento_id' => array('column' => 'agendamento_id', 'unique' => 0),
						'usuario_id' => array('column' => 'usuario_id', 'unique' => 0),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'gastos' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
					'usuario_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
					'conta_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
					'agendamento_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
					'destino_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
					'valor' => array('type' => 'float', 'null' => true, 'default' => NULL),
					'datadabaixa' => array('type' => 'date', 'null' => true, 'default' => NULL),
					'datadevencimento' => array('type' => 'date', 'null' => true, 'default' => NULL),
					'observacoes' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 200, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'status' => array('type' => 'boolean', 'null' => true, 'default' => '1'),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
						'destino_id' => array('column' => 'destino_id', 'unique' => 0),
						'agendamento_id' => array('column' => 'agendamento_id', 'unique' => 0),
						'usuario_id' => array('column' => 'usuario_id', 'unique' => 0),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'sugestos' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
					'usuario_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
					'titulo' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 150, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'texto' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'status' => array('type' => 'boolean', 'null' => true, 'default' => '0', 'key' => 'index'),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
						'status' => array('column' => 'status', 'unique' => 0),
					),
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
