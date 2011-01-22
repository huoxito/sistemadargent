<?php
class Fonte extends AppModel {

    var $displayField = 'nome';
    
	var $hasMany = array(
		'Ganho' => array(
			'className' => 'Ganho',
			'foreignKey' => 'fonte_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => 'valor',
			'exclusive' => true,
		),
        'Agendamento' => array(
			'className' => 'Agendamento',
			'foreignKey' => 'fonte_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => 'valor',
			'exclusive' => true,
		),
	);
    
    var $validate = array(
	
		'nome' => array(
            'rule1' => array(
			    'rule' => 'notEmpty',
			    'required' => true,
			    'message' => 'Insira o nome da categoria'
            ),
            'rule2' => array(
                'rule' => array('between',0,30),
                'message' => 'No máximo 30 caracteres',
                'last' => true
            ),
            'unique' => array(
                'rule' => 'checkUnique',
			    'message' => 'Fonte já cadastrada'
            )
		),
        'usuario_id' => array(
                'rule' => 'notEmpty',
                'required' => true,
        ),
	);
    
    function beforeSave(){
    
        App::import('Sanitize');
        Sanitize::html(&$this->data['Fonte']['nome'],array('remove'=>true));
        return true;
    }
    
    function checkUnique(){
        
        $params = array('conditions' =>
                    array('Fonte.nome' => $this->data['Fonte']['nome'],
                          'Fonte.usuario_id' => $this->data['Fonte']['usuario_id']));
        
        if(isset($this->data['Fonte']['id'])){
            $params = array_merge_recursive($params,
                            array('conditions' => array('Fonte.id !=' => $this->data['Fonte']['id'])));
        }
        
        if($this->find('count', $params)){
            return false;
        }else{
            return true;
        }
    }
    
}
?>