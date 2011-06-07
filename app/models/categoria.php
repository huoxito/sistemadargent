<?php 


class Categoria extends AppModel {

    var $name = "Categorias";
    var $displayField = 'nome';
    
        
    var $hasMany = array(
		'Move' => array(
			'className' => 'Move',
			'foreignKey' => 'categoria_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => 'valor',
			'exclusive' => true,
		)
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
			    'message' => 'Categoria já cadastrada'
            )
		),
        'usuario_id' => array(
                'rule' => 'notEmpty',
                'required' => true,
        ),
	);
    
    function checkUnique(){
        
        $params = array('conditions' =>
                    array('Categoria.nome' => $this->data['Categoria']['nome'],
                          'Categoria.usuario_id' => $this->data['Categoria']['usuario_id']));
        
        if(isset($this->data['Categoria']['id'])){
            $params = array_merge_recursive($params,
                            array('conditions' => array('Categoria.id !=' => $this->data['Categoria']['id'])));
        }
        
        if($this->find('count', $params)){
            return false;
        }else{
            return true;
        }
    }

    function listar($usuario_id){
        return $this->find('list',
                     array('conditions' => 
                                array('Categoria.usuario_id' => $usuario_id),
                           'order' => 'Categoria.nome asc'));
    }

}
