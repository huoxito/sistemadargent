<?php

class Agendamento extends AppModel {
    
    var $actsAs = array(
        'Modifiable' => array(
            'fields' => array('valor','observacoes','datadevencimento')
    ));
    
    var $validate = array(
        'model' => array(
            'rule1' => array(
                'rule' => 'notEmpty',
                'message' => 'model não definido'
            )  
        ),
        'frequencia_id' => array(
            'rule1' => array(
                'rule' => 'Numeric',
                'message' => 'Campo obrigatório',
                'required' => false
            )  
        ),
        'fonte_id' => array(
            'numeric' => array(
                'rule' => 'Numeric',
                'required' => false,
                'message' => 'Selecione uma fonte'
            )
        ),
        'destino_id' => array(
            'rule1' => array(
                'rule' => 'Numeric',
                'message' => 'Campo obrigatório',
                'required' => false,
            )  
        ),
        'valor' => array(
            'rule2' => array(
                'rule' => 'notEmpty',
                'message' => 'Digite um valor',
                'last' => true,
                'allowEmpty' => false,
                'required' => true
            ),
            'rule1' => array(
                'rule' => array('money','left'),
                'message' => 'Digite um valor válido (Ex: 220,00)'
            ),
        ),
        'datadevencimento' => array(
                'rule' => array('date', 'dmy'),
                'required' => false,
                'message' => 'insira uma data válida',
                'allowEmpty' => false,
        ),
        'numdeparcelas' => array(
            'rule1' => array(
                'rule' => 'notEmpty',
                'required' => false,
                'message' => 'Selecione uma fonte'
            ),
            'rule2' => array(
                'rule' => 'numeroDeParcelas',
                'message' => 'número de parcelas deve estar entre 1 e 60'
            ),
        ),
    );

    var $belongsTo = array(
        'Frequencia' => array(
            'className' => 'Frequencia',
            'foreignKey' => 'frequencia_id',
            'conditions' => '',
            'fields' => 'id, nome',
            'order' => ''
        ),
        'Fonte' => array(
            'className' => 'Fonte',
            'foreignKey' => 'fonte_id',
            'conditions' => '',
            'fields' => 'id, nome',
            'order' => ''
        ),
        'Destino' => array(
            'className' => 'Destino',
            'foreignKey' => 'destino_id',
            'conditions' => '',
            'fields' => 'id, nome',
            'order' => ''
        )
    );
    
    function numeroDeParcelas(){
            
        $numero = (int) $this->data['Agendamento']['numdeparcelas'];
        if( $numero < 1 || $numero > 99 ){
            return false;
        }else{
            return true;
        }
    }
    
}

?>