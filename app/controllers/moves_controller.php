<?php


class MovesController extends AppController {


    var $name = "Moves";

    function index(){
        
        $this->helpers[] = 'Time';
        $this->set('moves', $this->paginate('Move'));
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
