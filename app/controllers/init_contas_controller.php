<?php
class InitContasController extends AppController {
    
    var $name = 'InitContas';
    var $uses = array('Conta');
    var $components = array('Valor');
    
    
    function beforeFilter(){
        parent::beforeFilter();
        
        $chk = $this->Acl->check(array('model' => 'Usuario', 'foreign_key' => $this->user_id), 'root');
        if(!$chk){
            $this->cakeError('error404');
        }
    }
    
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
            
            echo $saldo = $ganhos[0][0]['total'] - $gastos[0][0]['total'];
            echo ' --- Usuario '.$user['Usuario']['id'].'<hr />';
            $conta = array(
                'usuario_id' => $user['Usuario']['id'],
                'nome' => 'livre',
                'saldo' => $saldo,
                'tipo' => 'cash'
            );
             
            $this->Conta->create();
            $this->Conta->Behaviors->detach('Modifiable');
            if(!$this->Conta->save($conta,false)){
                $this->log('não salvou os dados '.print_r($conta),'erro_criar_contas');
            }
            
            $result[] = array(
                'user' => $user['Usuario']['nome'],
                'saldo' => $saldo
            );
        }
    }
    
    function index(){
        
        foreach (Cache::configured() as $name) {
			$config = Cache::config($name);
			if (Cache::clear(false, $name)) {
				echo 'Cleared ' . $name . '<hr/>';
			} else {
			    echo '! Failed clearing ' . $name . '<hr />';
			}
		}
        
        $this->_crioContaPadrao();
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
