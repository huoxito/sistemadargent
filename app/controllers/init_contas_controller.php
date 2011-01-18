<?php
class InitContasController extends AppController {
    
    var $name = 'InitContas';
    var $uses = array('Conta');
    var $components = array('Valor');

    function _crioContaPadrao(){
        
        $this->Conta->Usuario->recursive = 0;
        $usuarios = $this->Conta->Usuario->find('all');
        foreach($usuarios as $user){
            
            $ganhos = $this->Conta->Ganho->find('all',
                            array('conditions' =>
                                    array('Ganho.usuario_id' => $user['Usuario']['id'],
                                          'Ganho.status' => '1'),
                                  'fields' => array('SUM(Ganho.valor) AS total'),
                                  'recursive' => '-1'));
            $gastos = $this->Conta->Gasto->find('all',
                            array('conditions' =>
                                    array('Gasto.usuario_id' => $user['Usuario']['id'],
                                          'Gasto.status' => '1'),
                                  'fields' => array('SUM(Gasto.valor) AS total'),
                                  'recursive' => '-1'));
            
            $saldo = $ganhos[0][0]['total'] - $gastos[0][0]['total'];
            
            $conta = array(
                'usuario_id' => $user['Usuario']['id'],
                'nome' => 'livre',
                'saldo' => $saldo,
                'tipo' => 'cash'
            );
            
            $this->Conta->create();
            if(!$this->Conta->save($conta,false)){
                $this->log('não salvou os dados '.print_r($conta),'erro_criar_contas');
            }
            
            $result[] = array(
                'user' => $user['Usuario']['nome'],
                'saldo' => $saldo
            );
        }
        
        $this->set('result',$result);
        $this->layout = 'ajax';
    }
    
    function index(){
        
        $this->_setarContaPadrao();
        $this->layout = 'ajax';
    }
    
    function _setarContaPadrao(){
        
        $this->Conta->recursive = -1;
        $contas = $this->Conta->find('all');
        foreach($contas as $conta){

            $this->Conta->Ganho->updateAll(
                array('Ganho.conta_id' => $conta['Conta']['id']),
                array('Ganho.usuario_id' => $conta['Conta']['usuario_id'])
            );
            
            $this->Conta->Gasto->updateAll(
                array('Gasto.conta_id' => $conta['Conta']['id']),
                array('Gasto.usuario_id' => $conta['Conta']['usuario_id'])
            );
            
            $this->Conta->Agendamento->updateAll(
                array('Agendamento.conta_id' => $conta['Conta']['id']),
                array('Agendamento.usuario_id' => $conta['Conta']['usuario_id'])
            );
        }
        
    }
    
    

}