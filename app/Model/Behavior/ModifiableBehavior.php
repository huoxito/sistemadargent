<?php

class ModifiableBehavior extends ModelBehavior {
	
	var $_settings = array(
		'fields' => array(),
	);
	
	# $config é o array passado dentro do model
    function setup(&$model, $config = array()) {
		    $this->settings[$model->alias] = array_merge($this->_settings, $config);
    }
    
    
    function beforeValidate(&$model){
        
        if( isset($model->data[$model->alias]['saldo']) ){
            
            $saldo = $model->data[$model->alias]['saldo'];
            $saldo = substr($saldo, 2, strlen($saldo));
            
            $model->data[$model->alias]['saldo'] = $this->formata($model, $saldo);
        }
         
        if( isset($model->data[$model->alias]['valor']) ){
            
            $valor = $model->data[$model->alias]['valor'];
            $valor = substr($valor, 2, strlen($valor));
            
            if(empty($valor) || $valor == ' 0,00'){
                $model->data[$model->alias]['valor'] = null;
            }else{
                $model->data[$model->alias]['valor'] = $this->formata($model, $valor);
            }
        } 
        
        return true;
    }
    
    function beforeSave(&$model){
		
        App::import('Sanitize');
        
        foreach($this->settings[$model->alias]['fields'] as $fieldName) {
            
              if ( $fieldName === 'nome' || $fieldName === 'obs' ){
                  Sanitize::html(&$model->data[$model->alias][$fieldName],array('remove'=>true));
              }
              
              if( isset($model->data[$model->alias]['data']) && $fieldName === 'data' ){
                  $model->data[$model->alias]['data'] = $this->converteParaMySQL($model, $model->data[$model->alias]['data']);
              }
        }
        
        return true;
    }

    
    function afterFind(&$model,$results){
        
        foreach ($results as $key => $row) {
          
            if ( isset($results[$key][$model->alias]['valor']) ){
                $results[$key][$model->alias]['valor'] = 'R$ ' . $this->formata($model, $results[$key][$model->alias]['valor'],'humano');
            } elseif ( isset($results[$key][$model->alias]['saldo']) ) {
                $results[$key][$model->alias]['saldo'] = 'R$ ' . $this->formata($model, $results[$key][$model->alias]['saldo'],'humano');
            }
        }
        return $results;
    }
    
    function monetary(&$model,$str) {
        $str = preg_split('#(?:\.|,)(\d{2})$#', $str, -1, PREG_SPLIT_DELIM_CAPTURE);
        return preg_replace('#[^0-9]#', '', $str[0]) . (!empty($str[1]) ? '.' . $str[1] : '');
    }
	
    function formata(&$model,$valor, $tipo = 'banco'){
            
        if($tipo === 'banco'){
            
            $valor = trim($valor);
            $valor = str_replace(",","+",$valor);
            $valor = str_replace(".","",$valor);
            $valor = (float)str_replace("+",".",$valor);
            
            return $valor;
        }else{
            $valor = number_format($valor,2,",",".");	
            return $valor;
        }
    }
    
    function converteParaMySQL(&$model,$data){
    
        list ($dia,$mes,$ano) = explode ('-', $data);
        $data = $ano.'-'.$mes.'-'.$dia;
        return $data;
    }
	
}
?>
