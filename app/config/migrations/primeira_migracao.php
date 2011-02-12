<?php
class M4d4770a2fb804696a9b31006577d0345 extends CakeMigration {

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
			'create_table' => array(
				'acos' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
					'parent_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10),
					'model' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'foreign_key' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10),
					'alias' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'lft' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10),
					'rght' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array(),
				),
				'agendamentos' => array(
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
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
						'frequencia_id' => array('column' => 'frequencia_id', 'unique' => 0),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'aros' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
					'parent_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10),
					'model' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'foreign_key' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10),
					'alias' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'lft' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10),
					'rght' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array(),
				),
				'aros_acos' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
					'aro_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'index'),
					'aco_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10),
					'_create' => array('type' => 'string', 'null' => false, 'default' => '0', 'length' => 2, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'_read' => array('type' => 'string', 'null' => false, 'default' => '0', 'length' => 2, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'_update' => array('type' => 'string', 'null' => false, 'default' => '0', 'length' => 2, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'_delete' => array('type' => 'string', 'null' => false, 'default' => '0', 'length' => 2, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
						'ARO_ACO_KEY' => array('column' => array('aro_id', 'aco_id'), 'unique' => 1),
					),
					'tableParameters' => array(),
				),
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
					'agendamento_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
					'fonte_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
					'valor' => array('type' => 'float', 'null' => true, 'default' => NULL),
					'datadabaixa' => array('type' => 'date', 'null' => true, 'default' => NULL),
					'datadevencimento' => array('type' => 'date', 'null' => true, 'default' => NULL),
					'observacoes' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 200, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'status' => array('type' => 'boolean', 'null' => true, 'default' => '1'),
					'conta_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
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
					'agendamento_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
					'destino_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
					'valor' => array('type' => 'float', 'null' => true, 'default' => NULL),
					'datadabaixa' => array('type' => 'date', 'null' => true, 'default' => NULL),
					'datadevencimento' => array('type' => 'date', 'null' => true, 'default' => NULL),
					'observacoes' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 200, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'status' => array('type' => 'boolean', 'null' => true, 'default' => '1'),
					'conta_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
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
				'usuarios' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
					'nome' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 120, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'email' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 80, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'login' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 120, 'key' => 'unique', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'password' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 40, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'foto' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 120, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'ultimologin' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'numdeacessos' => array('type' => 'integer', 'null' => true, 'default' => NULL),
					'hash' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 40, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'status' => array('type' => 'boolean', 'null' => true, 'default' => '1'),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
						'login' => array('column' => 'login', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
			),
		),
		'down' => array(
			'drop_table' => array(
				'acos', 'agendamentos', 'aros', 'aros_acos', 'contas', 'destinos', 'fontes', 'frequencias', 'ganhos', 'gastos', 'sugestos', 'usuarios'
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
       
       
        if($direction == 'up'){
            
            App::import('Core', 'Controller');
            App::import('Controller', 'Usuarios');
            $Usuario = new UsuariosController; 
            $Usuario->constructClasses();
            
            $aro =& $Usuario->Acl->Aro;
            $arosData = array(
                0 => array(
                    'alias' => 'root'
                ),
                1 => array(
                    'alias' => 'users'
                ),
                2 => array(
                    'alias' => 'admin'
                )
            );
        
            foreach($arosData as $data)
            {
                $aro->create();
                $aro->save($data); 
            }
            
            $aco =& $Usuario->Acl->Aco;
            $acoRoot = array(
                    'alias' => 'root'
            );
            $aco->create();
            $aco->save($acoRoot);
            
            $acoGroups = array(
                0 => array(
                    'alias' => 'users',
                    'parent_id' => 1
                ),
                1 => array(
                    'alias' => 'admin',
                    'parent_id' => 1
                )
            );
            
            foreach($acoGroups as $data)
            {
                $aco->create();
                $aco->save($data);
            }
            
            $acoSubGroups = array(
                0 => array(
                    'alias' => 'usuario',
                    'parent_id' => 2,
                    'model' => 'Usuario'
                ),
                1 => array(
                    'alias' => 'ganho',
                    'parent_id' => 2,
                    'model' => 'Ganho'
                ),
                2 => array(
                    'alias' => 'gasto',
                    'parent_id' => 2,
                    'model' => 'Gasto'
                ),
                3 => array(
                    'alias' => 'destino',
                    'parent_id' => 2,
                    'model' => 'Destino'
                ),
                4 => array(
                    'alias' => 'fonte',
                    'parent_id' => 2,
                    'model' => 'Fonte'
                ),
                5 => array(
                    'alias' => 'agendamento',
                    'parent_id' => 2,
                    'model' => 'Agendamento'
                ),
                6 => array(
                    'alias' => 'sugestao',
                    'parent_id' => 2,
                    'model' => 'Sugestao'
                ),
                7 => array(
                    'alias' => 'frequencia',
                    'parent_id' => 3,
                    'model' => 'Frequencia'
                ),
                8 => array(
                    'alias' => 'conta',
                    'parent_id' => 2,
                    'model' => 'Conta'
               )
            );

            foreach($acoSubGroups as $data)
            {
                $aco->create();
                $aco->save($data);
            }
            
            $Usuario->Acl->allow('root','root');
            $Usuario->Acl->allow('admin','admin');
            $Usuario->Acl->allow('users','users');
            
            // insiro godfather e dois fakes

            $fakes = array('Usuario' =>
                          array('nome' => 'dfgdfsgd',
                                'email' => 'mail@mail.com',
                                'login' => 'fake',
                                'passwd' => 'fakes',
                                'passwd_confirm' => 'fakes'));
            $Usuario->Usuario->create();  
            if( !$Usuario->Usuario->save($fakes) ){
                $errors = $Usuario->validateErrors($Usuario->Usuario);
                $Usuario->log($errors, 'migration usuario fake');
            }
            
            $fakes = array('Usuario' =>
                          array('nome' => 'dfgdfsgd',
                                'email' => 'fake@fake.com',
                                'login' => 'fakes',
                                'passwd' => 'fakes',
                                'passwd_confirm' => 'fakes'));
            $Usuario->Usuario->create();  
            if( !$Usuario->Usuario->save($fakes) ){
                $errors = $Usuario->validateErrors($Usuario->Usuario);
                $Usuario->log($errors,'migration usuario fake');
            }
            
            $root = array('Usuario' =>
                          array('nome' => 'GodFather',
                                'email' => 'godfather@mail.com',
                                'login' => 'godfather',
                                'numdeacessos' => 1,
                                'ultimologin' => date('Y-m-d H:i:s'),
                                'passwd' => 'godfather',
                                'passwd_confirm' => 'godfather'));
            $Usuario->Usuario->create();  
            if( !$Usuario->Usuario->save($root) ){
                $errors = $Usuario->validateErrors($Usuario->Usuario);
                $Usuario->log($errors,'migration usuario root');
            }
                
        }

		return true;
	}
}
?>
