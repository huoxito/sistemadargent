<?php
class Conta extends AppModel {
    
	var $name = 'Conta';
	var $displayField = 'nome';
    var $actsAs = array(
        'Modifiable' => array(
			'fields' => array('saldo')
        )
    );
    
    var $validate = array(
		'status' => array(
			'boolean' => array(
				'rule' => array('boolean'),
			),
		),
        'nome' => array(
            'obrigatorio' => array(
                'rule' => 'notempty',
                'message' => 'campo obrigatório'
            )
        ),
        'saldo' => array(
            'formato' => array(
                'rule' => array('money','left'),
                'message' => 'Digite um valor válido (Ex: 220,00)',
                'allowEmpty' => true
            )
        ),
        'tipo' => array(
            'string' => array(
                'rule' => 'notEmpty',
                'message' => 'Escolha o tipo de conta adequado',
                'last' => true
            ),
            'regra' => array(
                'rule' => array('inList',array('corrente','poupança','cash')),
                'message' => 'Valor inválido'
            )
        )
	);

	var $belongsTo = array(
		'Usuario' => array(
			'className' => 'Usuario',
			'foreignKey' => 'usuario_id',
			'conditions' => '',
			'fields' => 'id, nome, login',
		)
	);

	var $hasMany = array(
		'Agendamento' => array(
			'className' => 'Agendamento',
			'foreignKey' => 'conta_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
		),
		'Ganho' => array(
			'className' => 'Ganho',
			'foreignKey' => 'conta_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
		),
		'Gasto' => array(
			'className' => 'Gasto',
			'foreignKey' => 'conta_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
		)
	);

}
?>