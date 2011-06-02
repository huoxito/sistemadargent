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

    
    function editar($input, $usuario_id){
        
        $chk = $this->find('first', array(
                    'conditions' => array('Move.id' => $input['Move']['id']),
                    'fields' => array('Move.conta_id', 'Move.valor', 'tipo', 'Move.usuario_id', 'Move.status')
                )); 
        
        if($chk['Move']['usuario_id'] != $usuario_id){
            return false;
        }
        
        $input['Move']['usuario_id'] = $usuario_id;
         
        $datasource = $this->getDataSource();
        $datasource->begin($this);
        
        $this->id = $input['Move']['id'];
        if ( !$this->saveAll($input, array('atomic' => false)) ) {
            $datasource->rollback($this);
            return false;
        }
        
        if($chk['Move']['status'] == 1){
        
            $valorConsulta = $this->Behaviors->Modifiable->monetary($this, $chk['Move']['valor']);
            $valorForm = $this->Behaviors->Modifiable->monetary($this, $input['Move']['valor']); 
            
            if($input['Move']['tipo'] == 'Faturamento'){
                $sinal_tipo = '+';
                $sinal_conta_origem = '-';
            }else{
                $sinal_tipo = '-';
                $sinal_conta_origem = '+';
            }
            
            /* correcao na conta de origem */ 
            if($input['Move']['tipo'] != $chk['Move']['tipo']){
                
                $values = array(
                    'saldo' => 'saldo' . $sinal_tipo . $valorConsulta
                );
                $conditions = array(
                    'Conta.usuario_id' => $usuario_id,
                    'Conta.id' => $chk['Move']['conta_id']
                );
                if( !$this->Conta->updateAll($values, $conditions) ){
                    $datasource->rollback($this);
                    return false;
                } 
            }
            
            if ( $input['Move']['conta_id'] != $chk['Move']['conta_id'] ){
                
                if($input['Move']['tipo'] == $chk['Move']['tipo']){
                    /* correção na conta de origem */ 
                    $values = array(
                        'saldo' => 'saldo' . $sinal_conta_origem . $valorConsulta 
                    );
                    $conditions = array(
                        'Conta.usuario_id' => $usuario_id,
                        'Conta.id' => $chk['Move']['conta_id']
                    );
                    if( !$this->Conta->updateAll($values, $conditions) ){
                        $datasource->rollback($this);
                        return false;
                    }
                }  

                /* correção na conta atual */
                $values = array(
                    'saldo' => 'saldo' . $sinal_tipo . $valorForm 
                );
                $conditions = array(
                    'Conta.usuario_id' => $usuario_id,
                    'Conta.id' => $input['Move']['conta_id']
                );
                if( !$this->Conta->updateAll($values, $conditions) ){
                    $datasource->rollback($this);
                    return false;
                }
                 
            }else{ 
                
                /* correção na conta - muda de acordo com dados da operação */ 
                if($input['Move']['tipo'] != $chk['Move']['tipo']){
                    $diferenca = $valorForm;
                }else{
                    $diferenca = round($valorForm - $valorConsulta, 2);
                }
                
                $values = array(
                    'saldo' => 'saldo' . $sinal_tipo . $diferenca
                );
                $conditions = array(
                    'Conta.usuario_id' => $usuario_id,
                    'Conta.id' => $input['Move']['conta_id']
                );
                if( !$this->Conta->updateAll($values, $conditions) ){
                    $datasource->rollback($this);
                    return false;
                }
            } 
        }
        
        $datasource->commit($this);
        return true; 
    }
    
    function confirmar($id, $usuario_id){
        
        $this->Behaviors->detach('Modifiable'); 
        $chk = $this->find('first', array(
                    'conditions' => array('Move.id' => $id),
                    'fields' => array(
                            'Move.data', 'Move.usuario_id','Move.valor', 'Move.status', 'Move.tipo',
                            'Move.conta_id'
                    )
                ));

        if($chk['Move']['usuario_id'] != $usuario_id){
            return false;
        }        
        
        $input = $chk;
        $input['Move']['status'] = 1;
         
        $datasource = $this->getDataSource();
        $datasource->begin($this);
        
        $this->id = $id;
        if( !$this->save($input, false) ){
            $datasource->rollback($this);
            return false;    
        }
        
        if($chk['Move']['tipo'] == 'Faturamento'){
            $sinal_tipo = '+';
        }else{
            $sinal_tipo = '-';
        }
        
        $valor = $chk['Move']['valor'];
        $values = array(
            'saldo' => 'saldo' . $sinal_tipo . $valor,
            'modified' => '\'' . date('Y-m-d H:i:s') . '\''
        );
        $conditions = array(
            'Conta.usuario_id' => $usuario_id,
            'Conta.id' => $chk['Move']['conta_id']
        );
        if( !$this->Conta->updateAll($values, $conditions) ){
            $datasource->rollback($this);
            return false;
        }  
        
        $datasource->commit($this);
        return true;
    }

    
    function excluir($id, $usuario_id){
        
        $this->Behaviors->detach('Modifiable'); 
        $chk = $this->find('first', array(
                    'conditions' => array('Move.id' => $id),
                    'fields' => array(
                            'Move.data', 'Move.usuario_id','Move.valor', 'Move.status', 'Move.tipo',
                            'Move.conta_id'
                    )
                ));

        if($chk['Move']['usuario_id'] != $usuario_id){
            return false;
        }
        
        $datasource = $this->getDataSource();
        $datasource->begin($this);
        
        if( !$this->delete($id) ){
            $datasource->rollback($this);
            return false;    
        }
        
        if($chk['Move']['status'] == 1){

            if($chk['Move']['tipo'] == 'Faturamento'){
                $sinal_tipo = '-';
            }else{
                $sinal_tipo = '+';
            }
            
            $values = array(
                'saldo' => 'saldo' . $sinal_tipo . $chk['Move']['valor'],
                'modified' => '\'' . date('Y-m-d H:i:s') . '\''
            );
            $conditions = array(
                'Conta.usuario_id' => $usuario_id,
                'Conta.id' => $chk['Move']['conta_id']
            );
            if( !$this->Conta->updateAll($values, $conditions) ){
                $datasource->rollback($this);
                return false;
            }  
        }

        $datasource->commit($this);
        return true; 
    }

     
    function afterFind($results){
        
        foreach($results as $key => $result){

            if(isset($result['Move']['tipo']) && $result['Move']['tipo'] == 'Faturamento'){
                 $results[$key]['Move']['sinal'] = '+';
                 $results[$key]['Move']['color'] = 'positivo';
            }else{
                 $results[$key]['Move']['sinal'] = '-';
                 $results[$key]['Move']['color'] = 'negativo';
            }

            if(isset($result['Move']['status']) && $result['Move']['status'] == 0){
                 $results[$key]['Move']['class-status'] = ' pendente';
            }else{
                 $results[$key]['Move']['class-status'] = '';
            }
        } 
        return $results;
    }
    
    function afterSave($created){
        
        if((isset($this->data['Move']['status']) && $this->data['Move']['status'] == 1) || !$created){
            
            list($ano, $mes, $dia) = explode('-', $this->data['Move']['data']);
            $user_id = $this->data['Move']['usuario_id'];
            
            $this->cacheDadosNoMes('Faturamento', $mes, $ano, $user_id);    
            $this->cacheDadosNoMes('Despesa', $mes, $ano, $user_id);    
        }
    }
    
    
    function cacheDadosNoMes($tipo, $mes, $ano, $user_id){
        
        $result = $this->find('all',
                        array('fields' => array('SUM(Move.valor) AS total'),
                              'conditions' =>
                                array('Move.status' => 1,
                                      'Move.usuario_id' => $user_id,
                                      'Move.tipo' => $tipo,
                                      'MONTH(Move.data)' => $mes,
                                      'YEAR(Move.data)' => $ano)));        
        $total = $result[0][0]['total'];
        $plural_tipo = Inflector::tableize($tipo);
        Cache::write($plural_tipo.'_'.$mes.'_'.$ano.'_'.$user_id, $total);
        return $total;
    } 
     
    function despesasNoMes($mes, $ano, $user_id){
        
        $despesas = Cache::read('despesas_'.$mes.'_'.$ano.'_'.$user_id);
        if($despesas !== false){
            return $despesas;
        }
         
        return $this->cacheDadosNoMes('Despesa', $mes, $ano, $user_id);
    }
    
    function faturamentosNoMes($mes, $ano, $user_id){
        
        $faturamentos = Cache::read('faturamentos_'.$mes.'_'.$ano.'_'.$user_id);
        if($faturamentos  !== false){
            return $faturamentos;
        }
        
        return $this->cacheDadosNoMes('Faturamento', $mes, $ano, $user_id);
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
