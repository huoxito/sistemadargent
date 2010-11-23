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
            
            foreach($this->settings[$model->alias]['fields'] as $fieldName) {
                if( isset($model->data[$model->alias]['valor']) ){
                    $valor = (int)$model->data[$model->alias]['valor'];
                    if(empty($valor)){
                        return false;
                    }
                }
            }
    }
    
	function beforeSave(&$model){
		
        App::import('Sanitize');
        
		foreach($this->settings[$model->alias]['fields'] as $fieldName) {
            
            if ( $fieldName === 'nome' || $fieldName === 'observacoes' ){
                Sanitize::html(&$model->data[$model->alias][$fieldName],array('remove'=>true));
            }
            
            if( isset($model->data[$model->alias]['datadabaixa']) && $fieldName === 'datadabaixa' ){
                $model->data[$model->alias]['datadabaixa'] = $this->converteParaMySQL($model, $model->data[$model->alias]['datadabaixa']);
            }
            
            if( isset($model->data[$model->alias]['datadevencimento']) && $fieldName === 'datadevencimento' ){
                $model->data[$model->alias]['datadevencimento'] = $this->converteParaMySQL($model, $model->data[$model->alias]['datadevencimento']);
            }
            
            if( isset($model->data[$model->alias]['valor']) ){
                $model->data[$model->alias]['valor'] = $this->monetary($model, $model->data[$model->alias]['valor']);
            }
            
		}
        return true;
    }

    
    function afterFind(&$model,$results){

		foreach ($results as $key => $row) {
			
			if ( isset($results[$key][$model->alias]['valor']) ){
				$results[$key][$model->alias]['valor'] = $this->formata($model, $results[$key][$model->alias]['valor'],'humano');
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
            $valor = str_replace("+",".",$valor);
            $valor = (float) $valor;
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