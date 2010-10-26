<?php

    class Valormensal extends AppModel {
        
        var $name = 'Valormensal';
        var $useTable = 'valormensais';
        
        var $validate = array(
            'diadomes' => array(
    
                'rule' => 'mes',
                'message' => 'Digite um número entre 1 e 31',
                'allowEmpty' => false,
                'required' => true
               
            ),
            'numerodemeses' => array(
                
                'rule' => array('numerodemeses'),
                'message' => false,
                'allowEmpty' => false,
                'required' => false
            ),
            'agendamento_id' => array(
                'rule' => 'isUnique',
                'message' => 'Agendamento já concluído.'
            )
        );
        //The Associations below have been created with all possible keys, those that are not needed can be removed
        
        var $hasOne = array(
            'Agendamento' => array(
                'className' => 'Agendamento',
                'foreignKey' => 'id',
                'conditions' => '',
                'fields' => '',
                'order' => ''
            )
        );
        
        function mes(){
            
            $mes = (int) $this->data['Valormensal']['diadomes'];

            if( $mes < 1 || $mes > 31 ){
                return false;
            }else{
                return true;
            }
            
        }
        
        function numerodemeses(){
            
            $mes = (int) $this->data['Valormensal']['numerodemeses'];

            if( $mes < 1 || $mes > 60 ){
                return false;
            }else{
                return true;
            }
            
        }
        
        
    }
    
    
?>