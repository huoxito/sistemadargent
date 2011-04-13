<?php


class MovesController extends AppController {


    var $name = "Moves";
    var $components = array('Data');

    function index(){
        
        $this->helpers[] = 'Time';
        
        $mes = $this->Data->retornaNomeDoMes((int)date('m')) . '<br />' . date('Y');
        $this->set('mes', $mes); 

        $anterior = date('m-Y', mktime(0,0,0,date('m')-1,1,date('Y'))); 
        $this->set('anterior', $anterior);
        
        $proximo = date('m-Y', mktime(0,0,0,date('m')+1,1,date('Y'))); 
        $this->set('proximo', $proximo);
    }
    
    
    function dados(){
        
        $mes = $this->params['url']['mes'];
        $ano = $this->params['url']['ano'];
        
        if(!@checkdate($mes,1,$ano)){
            $mes = date('m');
            $ano = date('Y');
        }

        $moves = $this->Move->find('all', 
                        array('conditions' => 
                                array('MONTH(Move.data)' => $mes,
                                      'YEAR(Move.data)' => $ano,
                                      'Move.usuario_id' => $this->user_id),
                              'order' => 'Move.data DESC'));
        $this->set('moves', $moves);
        $this->layout = 'ajax';
    }
    
     
    function migracao(){
        
        $this->loadModel('Ganho'); 
        $this->loadModel('Fonte'); 
        $this->loadModel('Gasto'); 
        $this->loadModel('Destino'); 
        $this->loadModel('Categoria'); 
        
        
        $this->Move->Behaviors->detach('Modifiable');
         
        $this->Fonte->recursive = -1; 
        $fontes = $this->Fonte->find('all');
        foreach($fontes as $key => $fonte){
            
            array_shift($fonte['Fonte']);
            $categoria['Categoria'] = $fonte['Fonte'];
            
            $this->Categoria->create();
            if($this->Categoria->save($categoria, false)){
                
                echo 'Fonte ' . $categoria['Categoria']['nome'] . ' migrada para as categorias<hr />';
                
                $this->Ganho->Behaviors->detach('Modifiable');
                $ganhos = $this->Ganho->find('all', 
                                array('conditions' =>array('Fonte.id' => $fontes[$key]['Fonte']['id'])));
                foreach($ganhos as $ganho){
                    
                    array_shift($ganho['Ganho']);
                    $registro['Move'] = $ganho['Ganho']; 
                    $registro['Move']['categoria_id'] = $this->Categoria->id;
                    $registro['Move']['tipo'] = 'Faturamento';
                    $registro['Move']['obs'] = $ganho['Ganho']['observacoes'];

                    if(!empty($ganho['Ganho']['datadabaixa'])){
                        $registro['Move']['data'] = $ganho['Ganho']['datadabaixa'];
                    }else{
                        $registro['Move']['data'] = $ganho['Ganho']['datadevencimento'];
                    }
                    
                     
                    $this->Move->create(); 
                    if($this->Move->save($registro, false)){
                        echo 'Ganho migrado com sucesso.<hr />';        
                    }else{
                        echo 'erro na migração de ganhos';
                        exit;
                    }
                
                }
            
            }else{
                echo 'error ao salvar categoria';
                exit;    
            }        
        }
       
        $this->Destino->recursive = -1; 
        $destinos = $this->Destino->find('all');
        foreach($destinos as $key => $destino){
            
            array_shift($destino['Destino']);
            $categoria['Categoria'] = $destino['Destino'];
            
            $this->Categoria->create();
            if($this->Categoria->save($categoria, false)){
                
                echo 'Destino ' . $categoria['Categoria']['nome'] . ' migrada para as categorias<hr />';
                
                $this->Gasto->Behaviors->detach('Modifiable');
                $gastos = $this->Gasto->find('all', 
                                array('conditions' =>array('Destino.id' => $destinos[$key]['Destino']['id'])));
                foreach($gastos as $gasto){
                    
                    array_shift($gasto['Gasto']);
                    $registro['Move'] = $gasto['Gasto']; 
                    $registro['Move']['categoria_id'] = $this->Categoria->id;
                    $registro['Move']['tipo'] = 'Despesa';
                    $registro['Move']['obs'] = $gasto['Gasto']['observacoes'];

                    if(!empty($gasto['Gasto']['datadabaixa'])){
                        $registro['Move']['data'] = $gasto['Gasto']['datadabaixa'];
                    }else{
                        $registro['Move']['data'] = $gasto['Gasto']['datadevencimento'];
                    }

                    $this->Move->create(); 
                    if($this->Move->save($registro, false)){
                        echo 'Gasto migrado com sucesso.<hr />';        
                    }else{
                        echo 'erro na migração de ganhos';
                        exit;
                    }
                
                }
            
            }else{
                echo 'error ao salvar categoria';
                exit;    
            }        
        } 


        $this->autoRender = false;
    }        



    function add(){
        

        if(!empty($this->data)){

            if ( isset($this->data['Categoria']['nome']) ){
                $this->data['Categoria']['usuario_id'] = $this->user_id;
                unset($this->Move->validate['categoria_id']);
            }

            $this->data['Move']['usuario_id'] = $this->user_id;
            if ( $this->Move->adicionar($this->data) ) {
                
                $this->Session->setFlash('Registro salvo com sucesso!','flash_success');
                if(!$this->data['Move']['keepon']){
                    $this->redirect(array('action'=>'index'));  
                }else{
                    $this->data = null;
                }
                
            }else{
                $errors = $this->validateErrors($this->Move->Categoria,$this->Move);
            }    
        }
       
        $categorias = $this->Move->Categoria->listar($this->user_id);
        $this->set(compact('categorias'));
        
        $contas = $this->Move->Conta->listar($this->user_id);
        $this->set(compact('contas'));
    }
    
    function insereInput(){
        $this->layout = 'ajax';
    }
    
    function insereSelect(){
        
        $categorias = $this->Move->Categoria->listar($this->user_id);
        $this->set(compact('categorias'));
        
        $this->layout = 'ajax';
    }


}
