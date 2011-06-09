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
                                                  'Gasto.usuario_id' => $this->user_id,
                                                  'MONTH(Gasto.datadabaixa)' => date('m'),
                                                  'YEAR(Gasto.datadabaixa)' => date('Y'))
                                    ));
            $this->Conta->Ganho->recursive = -1;
            $ganhos = $this->Conta->Ganho->find('all',
                                    array('fields' => array('SUM(Ganho.valor) AS total'),
                                          'conditions' =>
                                            array('Ganho.status' => 1,
                                                  'Ganho.usuario_id' => $this->user_id,
                                                  'MONTH(Ganho.datadabaixa)' => date('m'),
                                                  'YEAR(Ganho.datadabaixa)' => date('Y'))
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
        $this->Conta->Behaviors->detach('Modifiable');
        $contas = $this->Conta->find('all',
                        array('conditions' => array('Conta.usuario_id' => $this->user_id)));
        
        $total = 0;
        foreach($contas as $key => $value){
            
            $ganho = $this->Conta->Ganho->find('count',
                       array('conditions' => array('Ganho.conta_id' => $value['Conta']['id'],
                                                   'Ganho.fonte_id IS NOT NULL'),
                             'recursive' => -1));
            $gasto = $this->Conta->Gasto->find('count',
                       array('conditions' => array('Gasto.conta_id' => $value['Conta']['id'],
                                                   'Gasto.destino_id IS NOT NULL'),
                             'recursive' => -1));

            if($ganho || $gasto){
                $contas[$key]['Conta']['delete'] = false;
            }else{
                $contas[$key]['Conta']['delete'] = true;
            }

            $total += $value['Conta']['saldo'];
        }

        
        if($total < 0){
            $class = "negativo";
        }else{
            $class = "positivo";
        }

        $this->set('class', $class);
        $this->set('total', $total);
        $this->set(compact('contas'));
    }

    function add() {
        
        if ( $this->params['isAjax'] ) {
            
            $this->data = array_merge($this->params['url']);
                
            if((float)$this->data['Conta']['saldo']){
                
                if($this->data['Conta']['saldo'] > 0){
                    $model = "Ganho";
                }else{
                    $model = "Gasto";
                }

                $this->data[$model][0] = array(
                    'usuario_id' => $this->user_id,
                    'valor' => $this->data['Conta']['saldo'],
                    'datadabaixa' => date('d-m-Y'),
                    'observacoes' => 'Saldo inicial na criação da conta'
                );
                unset($this->Conta->$model->validate['conta_id']);
                unset($this->Conta->$model->validate['valor']);
            }
            
            $this->data['Conta']['usuario_id'] = $this->user_id;
            $this->Conta->create();
            if ($this->Conta->saveAll($this->data)) {

                $this->Conta->recursive = -1;
                $this->set('conta', $this->Conta->findById($this->Conta->id));
                $this->layout = 'ajax';
                $this->render('add_response'); 
            }else{
                echo 'validacao'; exit;
            }

        }else{
            $this->layout = 'colorbox';
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
                
                if ($this->Conta->atualiza($this->data, $chk)) {
                    
                    $conta = $this->Conta->read(null,$this->Conta->id);
                    $this->set(compact('conta'));
                    
                    $this->layout = 'ajax';
                    $this->render('edit_response');
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

        if( !$id && isset($this->params['url']['id']) ){
            $id = (int)$this->params['url']['id'];
        }
        
        $itens = $this->Conta->read(null, $id);
        $this->checkPermissao($itens['Conta']['usuario_id']);
        
        if( $this->params['isAjax'] ){
        
            if( $this->Conta->delete($id) ){
                echo 'deleted';
            }   
            $this->autoRender = false;
            
        }else{
            
            $this->set('registro',$itens);    
            $this->layout = 'colorbox';
        }
    }

    function transfer(){
        
        if( $this->params['isAjax'] ){ 
            
            $data = array_merge($this->params['url']['Conta']);
            $data['usuario_id'] = $this->user_id;
           
            $result = $this->Conta->transferencia($data);
            if ($result['erro']){
                echo json_encode($result);
            }else{
                $result['origem'] = $this->Conta->field('saldo', array('id' => $data['origem']));
                $result['destino'] = $this->Conta->field('saldo', array('id' => $data['destino']));
                $result['message'] = "Tranferência realizada com sucesso";
                echo json_encode($result);
            }
            $this->autoRender = false;
                        
        }else{
            
            $conta_origem = $this->Conta->listaSaldoPositivo($this->user_id); 
            $conta_destino = $this->Conta->listar($this->user_id);
            
            $this->set(compact('conta_origem'));
            $this->set(compact('conta_destino'));

            $this->layout = 'colorbox';
        }
    }

}
?>
