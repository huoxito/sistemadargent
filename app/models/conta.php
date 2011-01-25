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
                'rule' => 'checkSaldo',
                'message' => 'Digite um valor válido (Ex: 220,00)',
                'allowEmpty' => true

            )
        ),
        'tipo' => array(
            'string' => array(
                'rule' => 'notEmpty',
                'message' => 'Escolha o tipo de conta adequado',
                'last' => true,
                'required' => true
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
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
		),
		'Ganho' => array(
			'className' => 'Ganho',
			'foreignKey' => 'conta_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
		),
		'Gasto' => array(
			'className' => 'Gasto',
			'foreignKey' => 'conta_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
		)
	);
    

    function checkSaldo($check){
       
        $value = array_values($check);
        $value = $value[0];
        $value = $this->Behaviors->Modifiable->monetary($this, $value);
        
        return is_numeric($value); 
    }


    function atualiza($data, $check){
        
        $antigo = $this->Behaviors->Modifiable->formata($this,$check['Conta']['saldo']);
        $atual = $this->Behaviors->Modifiable->formata($this,$data['Conta']['saldo']);
        $diferenca = round($atual-$antigo,2);

        if($diferenca){

            if($diferenca < 0){
                $tipo = 'Gasto';
                $diferenca = abs($diferenca);
            }else{
                $tipo = 'Ganho';
            }

            $data[$tipo][0] = array(
                'usuario_id' => $check['Conta']['usuario_id'],
                'valor' => $diferenca,
                'datadabaixa' => date('Y-m-d'),
                'observacoes' => 'Atualização de saldo na conta'
            );
            
            unset($this->$tipo->validate['valor']);
            unset($this->$tipo->validate['datadabaixa']);
            $this->$tipo->Behaviors->detach('Modifiable');
        }

        $this->id = $data['Conta']['id'];
        if ($this->saveAll($data)) {
            return true; 
        }else{
            return false;
        }
                      
    }


}
?>
