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
        )
    );
    
    var $validate = array(
        'fonte_id' => array(
            'rule' => 'notEmpty',
            'required' => false,
            'message' => 'Selecione uma fonte',
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
    
}
?>