<?php
    
    
class AppModel extends Model{
    
    function updateContas($object, $data, $sinal, $valorFormatado = true){
        
        if(!$valorFormatado){
            $data['valor'] = $object->Behaviors->Modifiable->monetary($this, $data['valor']);
        }
        
        $conditions = array('Conta.usuario_id' => $data['usuario_id'],
                            'Conta.id' => $data['conta_id']);
        $values = array('saldo' => 'saldo' . $sinal . $data['valor']);
        if( $object->Conta->updateAll($values, $conditions) ){
            return true;
        }else{
            return false;
        }
    }
}


?>