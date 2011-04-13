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
        
        $datasource = $this->getDataSource();
        $datasource->begin($this);
        
        $this->create();
        if ( !$this->saveAll($input, array('atomic' => false)) ) {
            $datasource->rollback($this);
            return false;
        }
        
        $valor = $this->Behaviors->Modifiable->monetary($this, $input['Move']['valor']);
        $conditions = array('Conta.usuario_id' => $input['Move']['usuario_id'],
                            'Conta.id' => $input['Move']['conta_id']);
        
        if($input['Move']['tipo'] == 'Faturamento'){
            $sinal = '+';
        }else{
            $sinal = '-';
        }
        
        $values = array('saldo' => 'saldo' . $sinal . $valor);
        if( $this->Conta->updateAll($values, $conditions) ){
            $datasource->commit($this);
            return true;
        }else{
            $datasource->rollback($this);
            return false;
        }
    }

    
    function afterFind($results){
        
        foreach($results as $key => $result){
        
            if(isset($result['Move'])){ 

                if($result['Move']['tipo'] == 'Faturamento'){
                     $results[$key]['Move']['tipo'] = '+';
                     $results[$key]['Move']['color'] = 'positivo';
                }else{
                     $results[$key]['Move']['tipo'] = '-';
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

}
