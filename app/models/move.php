<?php


class Move extends AppModel {

    var $name = "Moves"; 
    
    var $actsAs = array(
        'Modifiable' => array(
			'fields' => array('data', 'valor', 'obs')
        )
    ); 

    var $belongsTo = array(
        'Categoria' => array(
            'className' => 'Categoria',
            'foreignKey' => 'categoria_id',
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
        'tipo' => array(
            'rule' => array('inList', array('Faturamento', 'Despesa')),
            'message' => 'Escolha o tipo',
            'required' => true
        ),
        'categoria_id' => array(
            'rule' => 'notEmpty',
            'required' => false,
            'message' => 'Selecione uma categoria',
            'allowEmpty' => false,
        ),
        'conta_id' => array(
            'rule' => 'notEmpty',
            'required' => true,
            'message' => 'Selecione uma conta',
            'allowEmpty' => false,
        ),
        'valor' => array(
            'vazio' => array(
                'rule' => 'notEmpty',
                'message' => 'Digite um valor (Ex: 220,00)',
            ),
        ),
        'data' => array(
                'rule' => array('date', 'dmy'),
                'required' => false,
                'message' => 'Digite uma data válida',
                'allowEmpty' => false,
        ),
        'obs' => array(
                'rule' => array('between', 0,200),
                'message' => false,
                'required' => false,
                'allowEmpty' => true,
        )  
    );
    

    function adicionar($input){
        
        $datasource = $this->getDataSource();
        $datasource->begin($this);
        
        $this->create();
        if ( !$this->saveAll($input, array('atomic' => false)) ) {
            $datasource->rollback($this);
            return false;
        }
        
        $valor = $this->Behaviors->Modifiable->monetary($this, $input['Move']['valor']);
        $conditions = array('Conta.usuario_id' => $input['Move']['usuario_id'],
                            'Conta.id' => $input['Move']['conta_id']);
        $values = array('saldo' => 'saldo+'.$valor);
        if( $this->Conta->updateAll($values, $conditions) ){
            $datasource->commit($this);
            return true;
        }else{
            $datasource->rollback($this);
            return false;
        }
    }


}
