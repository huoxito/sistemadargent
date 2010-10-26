<?php

class Agendamento extends AppModel {
    
    var $actsAs = array(
        'Modifiable' => array(
            'fields' => array('valor','observacoes')
    ));
    
    var $validate = array(
        'frequencia_id' => array(
            'between' => array(
                               'rule' => array('between',1, 10),
                               'message' => 'Campo obrigatório'
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
            'numeric' => array(
                'rule' => 'Numeric',
                'required' => false,
                'message' => 'Selecione um destino'
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
    );
    //The Associations below have been created with all possible keys, those that are not needed can be removed

    var $belongsTo = array(
        'Frequencia' => array(
            'className' => 'Frequencia',
            'foreignKey' => 'frequencia_id',
            'conditions' => '',
            'fields' => 'id, nome',
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
    
    var $hasOne = array(
        'Valormensal' => array(
            'className'    => 'Valormensal',
            'foreignKey' => 'agendamento_id',
            'conditions'   => '',
            'dependent'    => true,
            'fields' => 'id, diadomes, numerodemeses'
        )
    );    

    
}

?>