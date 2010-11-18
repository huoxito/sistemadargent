<?php


class Gasto extends AppModel {

    var $actsAs = array(
        'Modifiable' => array(
			'fields' => array('datadabaixa', 'valor','observacoes', 'datadevencimento')
        )
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed
    var $belongsTo = array(
        'Destino' => array(
            'className' => 'Destino',
            'foreignKey' => 'destino_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        /*
        'Usuario' => array(
            'className' => 'Usuario',
            'foreignKey' => 'usuario_id',
            'conditions' => '',
            'fields' => 'id, login',
            'order' => ''
        ),
        */
    );
    
    
    var $validate = array(
            
        'destino_id' => array(
            'numeric' => array(
                'rule' => 'Numeric',
                'required' => false,
                'message' => 'Selecione uma fonte',
                'allowEmpty' => false,
                )
        ),
        
        'valor' => array(
            'rule2' => array(
                'rule' => 'notEmpty',
                'message' => 'Digite um valor',
                'last' => true,
                'allowEmpty' => false,
                'required' => false
                ),
            'rule1' => array(
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

}
    
    
?>