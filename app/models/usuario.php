<?php

class Usuario extends AppModel {

    var $name = 'Usuario';
    var $actsAs = array(
        'MeioUpload.MeioUpload' =>
            array('foto' =>
                    array('allowedMime' => array('image/jpeg'),
                          'allowedExt' => array('.jpg', '.jpeg'),
                          'thumbnails' => true,
                          'thumbsizes' =>
                                array(  'topo' =>
                                                array('width' => 70,
                                                      'height' => 70,
                                                      'maxDimension' => 'h'),
                                        'gerenciador' =>
                                                array('width' => 150,
                                                      'height' => 120,
                                                      'maxDimension' => 'w')
                                    ),
                            'length' =>
                                array(  'minWidth' => 150, // 0 for not validates
                                        'maxWidth' => 0,
                                        'minHeight' => 120,
                                        'maxHeight' => 0),
                        )
            ),
        'Acl' => array('type' => 'requester')
    );
    
    
    var $hasMany = array(
        'Ganho' => array(
			'className' => 'Ganho',
			'foreignKey' => 'usuario_id',
			'dependent' => true,
			'fields' => '',
			'exclusive' => true,
		),
        'Fonte' => array(
			'className' => 'Fonte',
			'foreignKey' => 'usuario_id',
			'dependent' => true,
			'fields' => '',
			'exclusive' => true,
		),
        'Gasto' => array(
			'className' => 'Gasto',
			'foreignKey' => 'usuario_id',
			'dependent' => true,
			'fields' => '',
			'exclusive' => true,
		),
        'Destino' => array(
			'className' => 'Destino',
			'foreignKey' => 'usuario_id',
			'dependent' => true,
			'fields' => '',
			'exclusive' => true,
		),
        'Agendamento' => array(
			'className' => 'Agendamento',
			'foreignKey' => 'usuario_id',
			'dependent' => true,
			'fields' => '',
			'exclusive' => true, 
		),
        'Sugestao' => array(
			'className' => 'Sugestao',
			'foreignKey' => 'usuario_id',
			'dependent' => true,
			'fields' => '',
			'exclusive' => true, 
		),
    );
    
    # THANKS TO http://lecterror.com/articles/view/manually-hashing-password-and-password-validation
    function __construct(){
        parent::__construct();
        
        $this->validate = array(
        
            'foto'  => array(

                'rule1' => array(
                        'rule'  => array('isUploadedFile'),
                        'last'  => true,
                        'message' => false,
                        'allowEmpty' => true,
                ),
                'formato' => array(
                        'rule' => array('extension', array('jpg')),
                        'message' => 'Foto deve estar no formato .jpg'
                ),
                'tamanho' => array(
                        'rule' => array('maxSize'),
                        'message' => 'Foto deve conter no máximo 1 MG'
                ),
            ),
            
            
            'nome' => array(
                            'rule' => 'notEmpty',
                            'message' => 'Campo obrigatório',
                            'allowEmpty' => false,
                            ),
            
            'email' => array(
                'invalido' => array(
                             'rule' => 'email',
                             'message' => 'Insira um email válido'
                             ),
                'rule2' => array(
                             'rule' => 'notEmpty',
                             'message' => 'Campo obrigatório',
                             'last' => true,
                             'allowEmpty' => false,
                             ),
            ),
            
            'login' => array(
                'rule1' => array(
                    'rule' => 'notEmpty',
                    'required'  =>  false,
                    'message' => 'Campo obrigatório',
                    'last' => true,
                    'allowEmpty' => false,
                ),
                'existe' => array(       
                    'rule' => 'isUnique',
                    'message' => 'Login já cadastrado, digite outro por favor'
                ),
            ),
            
            'passwd' => array(
                'numero' => array(
                            'rule' => array('between', 5, 10),
                            'message' => 'Deve conter entre 5 e 15 caracteres'
                ),
                'rule2' => array(
                           'rule' => 'notEmpty',
                                'last' => true,
                                'message' => 'Campo obrigatório',
                                'required' => false,
                                'allowEmpty' => false,
                ),
            
            ),
            
            'passwd_current' => array(
                
                'rule1' => array(
                    'rule' => 'notEmpty',
                    'required' => false,
                    'message' => 'Campo obrigatório',
                    'last' => true,
                    'allowEmpty' => false
                )  
                ,'rule2' => array(
                    'rule' => 'confereSenha',
                    'message' => 'Senha incorreta'
                ),
                
            ),
        
            'passwd_confirm' => array(
                
                'match' => array(     
                    'rule'  =>  'validatePasswdConfirm',
                    'message' => 'As senhas não conferem',
                    'required' => false
                ),
                'rule2' => array(
                    'rule' => 'notEmpty',
                    'last' => true,
                    'message' => 'Campo obrigatório',
                    'allowEmpty' => false,
                ),
            )
            
        );
        
    }
    
    # faltando adicionar valor no array ao criar interface pra cadastrar os admin e root
    function parentNode(){
        
        if($this->id && $this->data['Usuario']['numdeacessos'] > 1){
            $node = $this->node();
            return $node[1]['Aro']['alias'];
        }else{
            return 'users';
        }        
    }
    
    function validatePasswdConfirm(){
        
        if($this->data['Usuario']['passwd'] !== $this->data['Usuario']['passwd_confirm']){
            return false;
        }
        return true;
    }
    
    function beforeSave()  
    {

        if (isset($this->data['Usuario']['passwd']))  
        {  
            $this->data['Usuario']['password'] = Security::hash($this->data['Usuario']['passwd'], null, true);  
            unset($this->data['Usuario']['passwd']);  
        }

        if (isset($this->data['Usuario']['passwd_confirm']))  
        {  
            unset($this->data['Usuario']['passwd_confirm']);  
        }
        
        App::import('Sanitize');
        if (isset($this->data['Usuario']['nome']))  
        {  
            $this->data['Usuario']['nome'] = Sanitize::clean(&$this->data['Usuario']['nome'],
                                                                array('remove_html' => true,
                                                                      'encode' => false));  
        }
        
        if (isset($this->data['Usuario']['login']))  
        {  
            $this->data['Usuario']['login'] = Sanitize::clean(&$this->data['Usuario']['login'],
                                                                array('remove_html' => true,
                                                                      'encode' => false));  
        }
        
        /*
        if (isset($this->data['Usuario']['foto']))  
        {  
            App::import('Component', 'FileUpload');
            $fileUpload = new FileUploadComponent();
            $nomeArquivo = $fileUpload->criaNome($this->data['Usuario']['foto']['name'], 'usuarios');
            $fileUpload->moveArquivo($this->data['Usuario']['foto']['tmp_name'], $nomeArquivo, 'usuarios/');
            $this->data['Usuario']['foto'] = $nomeArquivo;
        }
        */
        return true;  
    }
    
    function confereSenha(){
        
        $oldPass = Security::hash($this->data['Usuario']['passwd_current'], null, true);
        $this->recursive = -1;
        # o método read sobscreve o array $this->data, usar sempre field nesse caso
        $password = $this->field('password', array('id' => $this->data['Usuario']['id']));           
        if($password === $oldPass) {
            return true;
        }else{
            return false;
        }
    }
    
    // Based on comment 8 from: http://bakery.cakephp.org/articles/view/improved-advance-validation-with-parameters
    function isUploadedFile($params){
        
        $val = array_shift($params);
        if ((isset($val['error']) && $val['error'] == 0) || (!empty( $val['tmp_name']) && $val['tmp_name'] != 'none')) {
            return is_uploaded_file($val['tmp_name']);
        }else{
            //return false;
        }
        
    }
    
    function maxSize($params){
        $val = array_shift($params);
        if($val['size'] > 2097152){
            return false;
        }else{
            return true;
        }
    }
    
    function createStatement($data)
    {
        
        $statement = array();
        if(isset($data['email']))
        {
          array_push($statement, array("{$this->name}.email LIKE" => '%' . $data['email'] . '%'));
        }
   
        return $statement;
    }
    
}
    
?>