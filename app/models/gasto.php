<?php


class Gasto extends AppModel {

    var $actsAs = array(
        'Modifiable' => array(
			'fields' => array('datadabaixa', 'valor','observacoes', 'datadevencimento')
        )
    );

    var $belongsTo = array(
        'Destino' => array(
            'className' => 'Destino',
            'foreignKey' => 'destino_id',
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
        'destino_id' => array(
            'rule' => 'notEmpty',
            'required' => false,
            'message' => 'Selecione um destino',
            'allowEmpty' => false,
        ),
        'conta_id' => array(
            'rule' => 'notEmpty',
            'required' => false,
            'message' => 'Selecione uma fonte',
            'allowEmpty' => false,
        ),
        'valor' => array(
            'vazio' => array(
                'rule' => 'notEmpty',
                'message' => 'Digite um valor (Ex: 220,00)',
                'last' => true,
            ),
            'formato' => array(
                'rule' => array('money','left'),
                'message' => 'Digite um valor válido (Ex: 220,00)'
            ),
        ),
        'datadabaixa' => array(
                'rule' => array('date', 'dmy'),
                'required' => false,
                'message' => 'Digite uma data válida',
                'allowEmpty' => false,
        ),
        'observacoes' => array(
                'rule' => array('between',0,200),
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
        
        if(isset($data['destino_id']))
        {
          array_push($statement, array("{$this->name}.destino_id" => $data['destino_id']));
        }
        
        if(isset($data['month']))
        {
          array_push($statement, array("MONTH(datadabaixa)" => $data['month']));
        }
        
        if(isset($data['year']))
        {
          array_push($statement, array("YEAR(datadabaixa)" => $data['year']));
        }
       
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
        
        $valor = $this->Behaviors->Modifiable->monetary($this, $input['Gasto']['valor']);
        $conditions = array('Conta.usuario_id' => $input['Gasto']['usuario_id'],
                            'Conta.id' => $input['Gasto']['conta_id']);
        $values = array('saldo' => 'saldo-'.$valor);
        if( $this->Conta->updateAll($values, $conditions) ){
            $datasource->commit($this);
            return true;
        }else{
            $datasource->rollback($this);
            return false;
        }
    }

    function editar($input, $check){
        
        $datasource = $this->getDataSource();
        $datasource->begin($this);
        
        $this->id = $input['Gasto']['id'];
        if ( !$this->saveAll($input, array('atomic' => false)) ) {
            $datasource->rollback($this);
            return false;
        }    
        
        $valorConsulta = $this->Behaviors->Modifiable->monetary($this, $check['Gasto']['valor']);
        $valorForm = $this->Behaviors->Modifiable->monetary($this, $input['Gasto']['valor']);
        
        if ( $input['Gasto']['conta_id'] != $check['Gasto']['conta_id'] ){
            
            // retiro o valor na conta que possui o registro 
            $values = array('saldo' => 'saldo-' . $valorForm);
            $conditions = array('Conta.usuario_id' => $check['Gasto']['usuario_id'],
                                'Conta.id' => $input['Gasto']['conta_id']);

            if( !$this->Conta->updateAll($values, $conditions) ){
                $datasource->rollback($this);
                return false;
            }
             
            // recoloco o valor na conta que possuia o registro 
            $values = array('saldo' => 'saldo+' . $valorConsulta);
            $conditions = array('Conta.usuario_id' => $check['Gasto']['usuario_id'],
                                'Conta.id' => $check['Gasto']['conta_id']);

            if( $this->Conta->updateAll($values, $conditions) ){
                $datasource->commit($this);
                return true;
            }else{
                $datasource->rollback($this);
                return false;
            }
             
        }else{

            $diferenca = round($valorConsulta - $valorForm, 2);
                        
            $values = array('saldo' => 'saldo+'.$diferenca);
            $conditions = array('Conta.usuario_id' => $check['Gasto']['usuario_id'],
                                'Conta.id' => $input['Gasto']['conta_id']);
            
            if( $this->Conta->updateAll($values, $conditions) ){
                $datasource->commit($this);
                return true;
            }else{
                $datasource->rollback($this);
                return false;
            }

        }
    }    
    
    
    function excluir($id, $input){
        
        $datasource = $this->getDataSource();
        $datasource->begin($this);
	
        if (!$this->delete($id)) {
            $datasource->rollback($this);
            return false;
        }
	
        $valor = $this->Behaviors->Modifiable->monetary($this, $input['Gasto']['valor']);
        $values = array('saldo' => 'saldo+'.$valor);
            $conditions = array('Conta.usuario_id' => $input['Gasto']['usuario_id'],
                    'Conta.id' => $input['Gasto']['conta_id']);
        
        if( $this->Conta->updateAll($values, $conditions) ){
            $datasource->commit($this);
            return true;
        }else{
            $datasource->rollback($this);
            return false;
        }
    }
    
    function confirmar($input, $all = false){
        
        $datasource = $this->getDataSource();
        $datasource->begin($this);
        
        $data = array_shift($input);
        $this->id = $data['id'];
        
        if($all){
            
            $data["Gasto"] = $data;
            if( !$this->save($data) ){
                $datasource->rollback($this);
                return false;
            }
            $valorFormatado = false;
        }else{
            $dados["Gasto"] = array('datadabaixa' => $data['datadevencimento'],
                                    'status' => 1);
            if( !$this->save($dados, false, array('datadabaixa', 'status')) ){
                $datasource->rollback($this);
                return false;
            }
            $valorFormatado = true;
        }
        
        if ( $this->updateContas($this, $data, '-', $valorFormatado) ) {
            $datasource->commit($this);
            return true; 
        }else{
            $datasource->rollback($this);
            return false;
        }
    }
   
    function cancelar($input){
        
        $datasource = $this->getDataSource();
        $datasource->begin($this);
        
        $data = array_shift($input);
        
        $this->id = $data["id"];  
        $dados["Gasto"] = array('datadabaixa' => null, 'status' => 0);
        if( !$this->save($dados, false, array('datadabaixa','status')) ){
            $datasource->rollback($this);    
            return false;
        }        
        
        if( $this->updateContas($this, $data, '+') ){
            $datasource->commit($this);
            return true;    
        }else{
            $datasource->rollback($this);
            return false;
        }
    }   
   
    
}
    
    
?>
