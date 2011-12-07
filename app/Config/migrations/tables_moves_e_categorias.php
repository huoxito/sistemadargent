<?php
class M4da37d4f8bb04cd28bee12aa577d0345 extends CakeMigration {

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
				'categorias' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
					'usuario_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
					'nome' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'status' => array('type' => 'boolean', 'null' => true, 'default' => NULL),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
						'usuario_id' => array('column' => 'usuario_id', 'unique' => 0),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'moves' => array(
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
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
			),
		),
		'down' => array(
			'drop_table' => array(
				'categorias', 'moves'
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
