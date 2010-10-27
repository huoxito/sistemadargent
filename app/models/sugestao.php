<?php

class Sugestao extends AppModel {
    
    var $name = 'Sugestao';
    var $useTable = 'sugestos';
    var $displayField = 'titulo';
    var $actsAs = array(
        'Purifiable' => array(
            'fields' => array('texto'),
            'overwrite' => true
        )
    );
    
    var $belongsTo = array(
            'Usuario' => array(
                'className' => 'Usuario',
                'foreignKey' => 'usuario_id',
                'conditions' => '',
                'fields' => 'id, nome, email',
                'order' => ''
            ),
    );
    
    var $validate = array(
        
        'titulo' => array(
            'rule1' => array(
                'rule' => array('notempty'),
                'message' => 'Campo obrigatório',
                'last' => true
            ),
            'rulel2' => array(
                'rule' => array('between', 3, 150),
                'message' => 'O título deve ter entre 3 e 150 caracteres'
            )
        ),
        'texto' => array(
            'notempty' => array('rule' => array('notempty'),
                                'message' => 'campo obrigatório'),
        )
    );
        
    function beforeValidate(){
        App::import('Sanitize');
        Sanitize::html(&$this->data['Sugestao']['titulo'],array('remove'=>true));
        return true;
    }

}
    
?>