<?php
class Ganho extends AppModel {

    var $actsAs = array(
        'Modifiable' => array(
			'fields' => array('datadabaixa', 'valor', 'observacoes', 'datadevencimento')
        )
    );

    var $belongsTo = array(
        'Fonte' => array(
            'className' => 'Fonte',
            'foreignKey' => 'fonte_id',
            'conditions' => '',
            'fields' => 'id, nome',
            'order' => ''
        ),
        'Conta' => array(
            'className' => 'Conta',
            'foreignKey' => 'conta_id',
            'conditions' => '',
            'fields' => 'id, nome, tipo',
            'order' => ''
        )
    );
    
    var $validate = array(
        'fonte_id' => array(
            'rule' => 'notEmpty',
            'required' => false,
            'message' => 'Selecione uma fonte',
            'allowEmpty' => false,
        ),
        'conta_id' => array(
            'rule' => 'notEmpty',
            'required' => false,
            'message' => 'Selecione uma conta',
            'allowEmpty' => false,
        ),
        'valor' => array(
            'vazio' => array(
                'rule' => 'notEmpty',
                'message' => 'Digite um valor (Ex: 220,00)',
                'last' => true
            ),
            'formato' => array(
                'rule' => array('money','left'),
                'message' => 'Digite um valor válido (Ex: 220,00)'
            )
        ),
        'datadabaixa' => array(
                'rule' => array('date', 'dmy'),
                'required' => false,
                'message' => 'Digite uma data válida',
                'allowEmpty' => false,
        ),
        'observacoes' => array(
                'rule' => array('between', 0,200),
                'message' => false,
                'required' => false,
                'allowEmpty' => true,
        )  
    );
    
    function createStatement($data)
    {
        //array_push($statement, array("{$this->name}.title" => 'LIKE %' . $data['title'] . '%'));
        $statement = array();
        
        if(isset($data['observacoes']))
        {
          array_push($statement, array("{$this->name}.observacoes LIKE " => '%'. $data['observacoes'] . '%'));
        }
        
        if(isset($data['fonte_id']))
        {
          array_push($statement, array("{$this->name}.fonte_id" => $data['fonte_id']));
        }
        
        if(isset($data['month']))
        {
          array_push($statement, array("MONTH(datadabaixa)" => $data['month']));
        }
        
        if(isset($data['year']))
        {
          array_push($statement, array("YEAR(datadabaixa)" => $data['year']));
        }
        
        //array_push($statement, array("Ganho.usuario_id" => $this->Auth->user('id')));
        //array_push($statement, array("Ganho.status" => '1'));
       
        return $statement;
    }
    
    function adicionar($input){
        
        $datasource = $this->getDataSource();
        $datasource->begin($this);
        
        $this->create();
        if ( !$this->saveAll($input, array('atomic' => false)) ) {
            $datasource->rollback($this);
            return false;
        }
        
        $valor = $this->Behaviors->Modifiable->monetary($this, $input['Ganho']['valor']);
        $conditions = array('Conta.usuario_id' => $input['Ganho']['usuario_id'],
                            'Conta.id' => $input['Ganho']['conta_id']);
        $values = array('saldo' => 'saldo+'.$valor);
        if( $this->Conta->updateAll($values, $conditions) ){
            $datasource->commit($this);
            return true;
        }else{
            $datasource->rollback($this);
            return false;
        }
    }
    
    function excluir($id, $userId, $data){
	
        $datasource = $this->getDataSource();
        $datasource->begin($this);
	
        if (!$this->delete($id)) {
            $datasource->rollback($this);
            return false;
        }
	
        $valor = $this->Behaviors->Modifiable->monetary($this, $data['Ganho']['valor']);
        $values = array('saldo' => 'saldo-'.$valor);
            $conditions = array('Conta.usuario_id' => $userId,
                    'Conta.id' => $data['Ganho']['conta_id']);
        
        if( $this->Conta->updateAll($values, $conditions) ){
            $datasource->commit($this);
            return true;
        }else{
            $datasource->rollback($this);
            return false;
        }
    }
    
    function confirmar($input){
        
        $datasource = $this->getDataSource();
        $datasource->begin($this);
        
        $data = array_shift($input);
        
        $this->id = $data['id'];
        $dados["Ganho"] = array('datadabaixa' => $data['datadevencimento'],
                                'status' => 1);
        
        if( !$this->save($dados, false, array('datadabaixa', 'status')) ){
            $datasource->rollback($this);
            return false;
        }
        
        if ( $this->updateContas($this, $data, '+') ) {
            $datasource->commit($this);
            return true; 
        }else{
            $datasource->rollback($this);
            return false;
        }
    }
    
}
?>