<?php
class ContasController extends AppController {

	var $name = 'Contas';
    var $components = array('Valor');
    var $helpers = array('Data');
    
    function saldo(){
        
        if (isset($this->params['requested'])) {
            
            $this->Conta->Gasto->recursive = -1;
            $gastos = $this->Conta->Gasto->find('all',
                                    array('fields' => array('SUM(Gasto.valor) AS total'),
                                          'conditions' =>
                                            array('Gasto.status' => 1,
                                                  'Gasto.usuario_id' => $this->user_id)
                                    ));
            $this->Conta->Ganho->recursive = -1;
            $ganhos = $this->Conta->Ganho->find('all',
                                    array('fields' => array('SUM(Ganho.valor) AS total'),
                                          'conditions' =>
                                            array('Ganho.status' => 1,
                                                  'Ganho.usuario_id' => $this->user_id)
                                    ));
            
            $saldo = $ganhos[0][0]['total'] - $gastos[0][0]['total'];
            $items = array(
                'ganhos' => $ganhos[0][0]['total'],
                'gastos' => $gastos[0][0]['total'],
                'diferenca' => $saldo
            );
            return $items;
        
        }else{
            $this->cakeError('error404');
        }
    }
    
	function index() {
        
		$this->Conta->recursive = 0;
		$contas = $this->Conta->find('all',
                        array('conditions' => array('Conta.usuario_id' => $this->user_id)));
        
        $this->set(compact('contas'));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid conta', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('conta', $this->Conta->read(null, $id));
	}

	function add() {
        
		if (!empty($this->data)) {
            
            if((float)$this->data['Conta']['saldo']){
                
                $this->data['Ganho'][0] = array(
                    'usuario_id' => $this->user_id,
                    'valor' => $this->data['Conta']['saldo'],
                    'datadabaixa' => date('d-m-Y'),
                    'observacoes' => 'Saldo inicial na criação da conta'
                );
                unset($this->Conta->Ganho->validate['conta_id']);
            }
            
            $this->data['Conta']['usuario_id'] = $this->user_id;
            $this->Conta->create();
            if ($this->Conta->saveAll($this->data)) {
                $this->Session->setFlash('Nova conta criada com sucesso','flash_success');
                $this->redirect(array('action' => 'index'));
            }else{
                $this->Session->setFlash('Preencha os campos corretamente','flash_error');
            }
		}
	}

	function edit($id = null) {
        
        if( $this->params['isAjax'] ){
        
            $this->data = array_merge($this->params['url']);
            
            $this->Conta->recursive = -1;
            $chk = $this->Conta->find('first',
                                array('conditions' =>
                                        array('Conta.id' => $this->data['Conta']['id'])));
            if( $this->checkPermissao($chk['Conta']['usuario_id'],true) ){
                
                $this->Conta->set($this->data);
                if($this->Conta->validates()){
                    
                    $antigo = $this->Conta->Behaviors->Modifiable->monetary($this,$chk['Conta']['saldo']);
                    $atual = $this->Conta->Behaviors->Modifiable->monetary($this,$this->data['Conta']['saldo']);
                    $diferenca = round($atual-$antigo,2);
                    if($diferenca){
                        
                        if($diferenca < 0){
                            $tipo = 'Gasto';
                            $diferenca = abs($diferenca);
                        }else{
                            $tipo = 'Ganho';
                        }
                        
                        $this->data[$tipo][0] = array(
                            'usuario_id' => $this->user_id,
                            'valor' => $diferenca,
                            'datadabaixa' => date('Y-m-d'),
                            'observacoes' => 'Diferença na alteração do saldo da conta'
                        );
                        unset($this->Conta->$tipo->validate['valor']);
                        unset($this->Conta->$tipo->validate['datadabaixa']);
                        $this->Conta->$tipo->Behaviors->detach('Modifiable');
                    }
                    
                    $this->data['Conta']['saldo'] = $atual;
                    $this->Conta->id = $this->data['Conta']['id'];
                    if ($this->Conta->saveAll($this->data)) {
                        
                        $conta = $this->Conta->read(null,$this->Conta->id);
                        $this->set(compact('conta'));
                        
                        $this->layout = 'ajax';
                        $this->render('edit_response');
                    }else{
                        echo 'validacao'; exit;
                    }
                    
                }else{
                    echo 'validacao'; exit;
                }
            }else{
                echo 'error'; exit;
            }
            
        } elseif (!$id && empty($this->data)) {
            $this->redirect(array('action' => 'index'));
        } else {
            
            if (empty($this->data)) {
                
                $this->data = $this->Conta->read(null, $id);
                $this->checkPermissao($this->data['Conta']['usuario_id']);
            }
            $this->layout = 'colorbox';
        }
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for conta', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Conta->delete($id)) {
			$this->Session->setFlash(__('Conta deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Conta was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>