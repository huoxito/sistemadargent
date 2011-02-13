<?php

class Usuario extends AppModel {

    var $name = 'Usuario';
    var $actsAs = array(
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
        'Conta' => array(
			'className' => 'Conta',
			'foreignKey' => 'usuario_id',
			'dependent' => true,
			'fields' => '',
			'exclusive' => true,
		),
    );
    
    
    var $validate = array(
                
        'nome' => array(
                        'rule' => 'notEmpty',
                        'message' => 'Campo obrigatório',
                        'allowEmpty' => false
        ),
        'email' => array(
            'invalido' => array(
                         'rule' => 'email',
                         'message' => 'Insira um email válido'),
            'rule2' => array(
                         'rule' => 'notEmpty',
                         'message' => 'Campo obrigatório',
                         'last' => true,
                         'allowEmpty' => false),
            'existe' => array(       
                'rule' => 'isUnique',
                'message' => 'Email já cadastrado'
            ),
        ),
        
        'login' => array(
            'rule1' => array(
                'rule' => 'notEmpty',
                'required'  =>  false,
                'message' => 'Campo obrigatório',
                'last' => true,
                'allowEmpty' => false),
            'string' => array(
                'rule' => 'checkLogin',
                'message' => 'Apenas letras, números, hífen ou underline, sem espaços'),
            'existe' => array(       
                'rule' => 'isUnique',
                'message' => 'Login já cadastrado, digite outro por favor'),
        ),
        
        'passwd' => array(
            'numero' => array(
                        'rule' => array('between', 5, 15),
                        'message' => 'Deve conter entre 5 e 15 caracteres'),
            'rule2' => array(
                       'rule' => 'notEmpty',
                            'last' => true,
                            'message' => 'Campo obrigatório',
                            'required' => false,
                            'allowEmpty' => false),
        
        ),
        
        'passwd_current' => array(
            
            'rule1' => array(
                'rule' => 'notEmpty',
                'required' => false,
                'message' => 'Campo obrigatório',
                'last' => true,
                'allowEmpty' => false),
            'rule2' => array(
                'rule' => 'confereSenha',
                'message' => 'Senha incorreta'),
            
        ),
    
        'passwd_confirm' => array(
            
            'match' => array(     
                'rule'  =>  'validatePasswdConfirm',
                'message' => 'As senhas não conferem',
                'required' => false),
            'rule2' => array(
                'rule' => 'notEmpty',
                'last' => true,
                'message' => 'Campo obrigatório',
                'allowEmpty' => false),
        )
        
    );


    # faltando adicionar valor no array ao criar interface pra cadastrar os admin e root
    function parentNode(){
        
        if(isset($this->data['Usuario']['login']) && $this->data['Usuario']['login'] === 'godfather'){
            return 'root';
        }else if($this->id && !isset($this->data['Usuario']['created'])){
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
    
    
    function beforeValidate(){
        
        App::import('Sanitize');
        if (isset($this->data['Usuario']['nome']))  
        {  
            Sanitize::html(&$this->data['Usuario']['nome'], array('remove' => true));  
        }
        
        return true;
    }
    
    function beforeSave()  
    {
        # THANKS TO http://lecterror.com/articles/view/manually-hashing-password-and-password-validation
        if (isset($this->data['Usuario']['passwd']))  
        {  
            $this->data['Usuario']['password'] = Security::hash($this->data['Usuario']['passwd'], null, true);  
            unset($this->data['Usuario']['passwd']);  
        }

        if (isset($this->data['Usuario']['passwd_confirm']))  
        {  
            unset($this->data['Usuario']['passwd_confirm']);  
        }

        return true;  
    }
    
    function checkLogin(){
        $login = Sanitize::paranoid(&$this->data['Usuario']['login'], array('-', '_'));  
        if($login != trim($this->data['Usuario']['login'])){
            return false;
        }else{
            return true;    
        }
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
    
    function createStatement($data)
    {
        $statement = array();
        if(isset($data['email']))
        {
          array_push($statement, array("{$this->name}.email LIKE" => '%' . $data['email'] . '%'));
        }
        
        return $statement;
    }


    function excluirMovimentacoes($user_id){
       
        $datasource = $this->getDataSource(); 
        $datasource->begin($this);
        
        $result = $this->Agendamento->deleteAll(
            array('Agendamento.usuario_id' => $user_id), false
        );

        if(!$result){
            $datasource->rollback($this);
            return false;
        }
        
        $result = $this->Ganho->deleteAll(
            array('Ganho.usuario_id' => $user_id), false
        );
        
        if(!$result){
            $datasource->rollback($this);
            return false;
        }
         
        $result = $this->Gasto->deleteAll(
            array('Gasto.usuario_id' => $user_id), false
        );
        
        if(!$result){
            $datasource->rollback($this);
            return false;
        }
        
        $data = array(
            'Conta.saldo' => 0, 
            'Conta.modified' => '"'.date('Y-m-d H:i:s').'"'
        );
        $conditions = array('Conta.usuario_id' => $user_id);
        $result = $this->Conta->updateAll($data, $conditions);
        
        if(!$result){
            $datasource->rollback($this);
            return false;
        }else{
            $datasource->commit($this);
            return true;
        }
    }
    
}
    
?>
