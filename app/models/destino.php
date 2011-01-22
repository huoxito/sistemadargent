<?php
class Destino extends AppModel {

    var $displayField = 'nome';
    
	var $hasMany = array(
		'Gasto' => array(
			'className' => 'Gasto',
			'foreignKey' => 'destino_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => 'valor',
			'exclusive' => true
		),
        'Agendamento' => array(
			'className' => 'Agendamento',
			'foreignKey' => 'destino_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => 'valor',
			'exclusive' => true
		),
	);
    
    var $validate = array(
        
		'nome' => array(
            'rule1' => array(
			    'rule' => 'notEmpty',
			    'required' => true,
			    'message' => 'Digite o nome'
            ),
            'rule2' => array(
                'rule' => array('between',0,30),
                'message' => 'No máximo 30 caracteres',
                'last' => true
            ),
            'unique' => array(
                'rule' => 'checkUnique',
			    'message' => 'Destino já cadastrado'
            )
        ),
        'usuario_id' => array(
                'rule' => 'notEmpty',
                'required' => true,
        )
	);
    
    function beforeSave(){
    
        App::import('Sanitize');
        Sanitize::html(&$this->data['Destino']['nome'],array('remove'=>true));
        return true;
    }
    
    function checkUnique(){
        
        $params = array('conditions' =>
                    array('Destino.nome' => $this->data['Destino']['nome'],
                          'Destino.usuario_id' => $this->data['Destino']['usuario_id']));
        
        if(isset($this->data['Destino']['id'])){
            $params = array_merge_recursive($params,
                            array('conditions' => array('Destino.id !=' => $this->data['Destino']['id'])));
        }
        
        if($this->find('count', $params)){
            return false;
        }else{
            return true;
        }
    }

}
?>