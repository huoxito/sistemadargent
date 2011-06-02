<?php

/* classe temporaria para executar migração de dados na mudança 
 da arquitetura do bando de dados do sistema */ 
class MigracoesController extends AppController {

    var $uses = ''; 
    var $name = 'Migracoes';

    function newbranchmigration(){
        
        $this->loadModel('Ganho'); 
        $this->loadModel('Fonte'); 
        $this->loadModel('Gasto'); 
        $this->loadModel('Destino'); 
        $this->loadModel('Categoria'); 
        $this->loadModel('Move'); 
        
        
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

}
