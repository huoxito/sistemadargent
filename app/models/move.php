<?php


class Move extends AppModel {

    var $name = "Moves"; 
    
    var $actsAs = array(
        'Modifiable' => array(
			'fields' => array('data', 'valor', 'obs')
        )
    ); 

    var $belongsTo = array(
        'Categoria' => array(
            'className' => 'Categoria',
            'foreignKey' => 'categoria_id',
            'conditions' => '',
            'fields' => 'id, nome',
            'order' => ''
        ),
        'Conta' => array(
            'className' => 'Conta',
            'foreignKey' => 'conta_id',
            'conditions' => '',
            'fields' => 'id, nome, tipo',
            'order' => ''
        )
    );
    
    var $validate = array(
        'tipo' => array(
            'rule' => array('inList', array('Faturamento', 'Despesa')),
            'message' => 'Campo obrigatório',
            'required' => true
        ),
        'categoria_id' => array(
            'rule' => 'notEmpty',
            'required' => false,
            'message' => 'Campo obrigatório',
            'allowEmpty' => false,
        ),
        'conta_id' => array(
            'rule' => 'notEmpty',
            'required' => true,
            'message' => 'Selecione uma conta',
            'allowEmpty' => false,
        ),
        'valor' => array(
            'vazio' => array(
                'rule' => 'notEmpty',
                'message' => 'Insira um valor (Ex: 220,00)',
            ),
        ),
        'data' => array(
                'rule' => array('date', 'dmy'),
                'required' => false,
                'message' => 'Insira uma data válida',
                'allowEmpty' => false,
        ),
        'obs' => array(
                'rule' => array('between', 0,200),
                'message' => false,
                'required' => false,
                'allowEmpty' => true,
        )  
    );
    

    function adicionar($input){
        
        $data_atual = date('d-m-Y');
        // false se data for maior que a atual
        $dar_baixa = $this->comparaDatas($input['Move']['data'], $data_atual);

        $datasource = $this->getDataSource();
        $datasource->begin($this);
        
        if(!$dar_baixa){
            $input['Move']['status'] = 0;
        }else{
            $input['Move']['status'] = 1;
        }

        $this->create();
        if ( !$this->saveAll($input, array('atomic' => false)) ) {
            $datasource->rollback($this);
            return false;
        }
        
        $parent_key = $this->id;
        if( isset($input['Categoria']['nome']) ){
            $input['Move']['categoria_id'] = $this->Categoria->id;
        }
         
        if($dar_baixa){
            
            $valor = $this->Behaviors->Modifiable->monetary($this, $input['Move']['valor']);
            $conditions = array('Conta.usuario_id' => $input['Move']['usuario_id'],
                                'Conta.id' => $input['Move']['conta_id']);
            
            if($input['Move']['tipo'] == 'Faturamento'){
                $sinal = '+';
            }else{
                $sinal = '-';
            }
            
            $values = array(
                'saldo' => 'saldo' . $sinal . $valor,
                'modified' => '"'.date('Y-m-d H:i:s').'"'
            );

            if( !$this->Conta->updateAll($values, $conditions) ){
                $datasource->rollback($this);
                return false;
            }        
        }

        if($input['Move']['config']){
            
            list($dia,$mes,$ano) = explode('-',$input['Move']['data']);              
            $frequencia = $input['Move']['frequencia'];
             
            for($i=0; $i < $input['Move']['numdeparcelas']; $i++){
                
                if ( $frequencia == 'mensal' ){
                    $mes = $mes + 1;
                }elseif ( $frequencia == 'bimestral' ){
                    $mes = $mes + 2;       
                }elseif ( $frequencia == 'trimestral' ){
                    $mes = $mes + 3;
                }elseif ( $frequencia == 'semestral' ){
                    $mes = $mes + 6;
                }elseif ( $frequencia == 'anual' ){
                    $mes = $mes + 12;     
                }else{
                    $datasource->rollback($this);
                    return false;
                }
                
                $ultimoDiaDoMes = date('d', mktime(0, 0, 0, $mes+1, 0, $ano)); 
                 
                if( $dia > $ultimoDiaDoMes ){
                    $dia = $ultimoDiaDoMes;  
                }else{
                    $dia = $dia;
                }
                
                $dataDeEntrada = date('d-m-Y', mktime(0,0,0,$mes,$dia,$ano));
                
                $proximos = array(
                    'status' => 0,
                    'data' => $dataDeEntrada,
                    'parent_key' => $parent_key
                );
                
                $input['Move'] = array_merge($input['Move'], $proximos);
                 
                $this->create();  
                if(!$this->save($input, true)){
                    $datasource->rollback($this);
                    return false;
                }
            }
        }
    
        $datasource->commit($this);
        return true;
    }

    
    function afterFind($results){
        
        foreach($results as $key => $result){
        
            if(isset($result['Move'])){ 

                if($result['Move']['tipo'] == 'Faturamento'){
                     $results[$key]['Move']['sinal'] = '+';
                     $results[$key]['Move']['color'] = 'positivo';
                }else{
                     $results[$key]['Move']['sinal'] = '-';
                     $results[$key]['Move']['color'] = 'negativo';
                }
            }
        } 
        return $results;
    }

    
    function despesasNoMes($mes, $ano, $user_id){
        
        $despesas = Cache::read('despesas_'.$mes.'_'.$ano.'_'.$user_id);
        if($despesas !== false){
            return $despesas;
        }
         
        $result = $this->find('all',
                        array('fields' => array('SUM(Move.valor) AS total'),
                              'conditions' =>
                                array('Move.status' => 1,
                                      'Move.usuario_id' => $user_id,
                                      'Move.tipo' => 'Despesa',
                                      'MONTH(Move.data)' => $mes,
                                      'YEAR(Move.data)' => $ano)));        
        $despesas = $result[0][0]['total'];
        Cache::write('despesas_'.$mes.'_'.$ano.'_'.$user_id, $despesas);
        return $despesas; 
    }
    
    function faturamentosNoMes($mes, $ano, $user_id){
        
        $faturamentos = Cache::read('faturamentos_'.$mes.'_'.$ano.'_'.$user_id);
        if($faturamentos  !== false){
            return $faturamentos;
        }
         
        $result = $this->find('all',
                        array('fields' => array('SUM(Move.valor) AS total'),
                              'conditions' =>
                                array('Move.status' => 1,
                                      'Move.usuario_id' => $user_id,
                                      'Move.tipo' => 'Faturamento',
                                      'MONTH(Move.data)' => $mes,
                                      'YEAR(Move.data)' => $ano)));        
        $faturamentos = $result[0][0]['total'];
        Cache::write('faturamentos_'.$mes.'_'.$ano.'_'.$user_id, $faturamentos);
        return $faturamentos; 
    }
    


    # nosso formato , retorno false se data1 for maior que data2
    function comparaDatas($data1, $data2)																
	{																									
		
        list($dia1,$mes1,$ano1) = explode('-',$data1);																	
		list($dia2,$mes2,$ano2) = explode('-',$data2);																			
		
        $timestamp1 = mktime(0,0,0,$mes1,$dia1,$ano1);					
		$timestamp2 = mktime(0,0,0,$mes2,$dia2,$ano2);									
		
        if ($timestamp1 === $timestamp2){																	
            return true;																				
        }else if($timestamp1 > $timestamp2){			
            return false;	
        }else{
            return true;	
        }
    }

}
