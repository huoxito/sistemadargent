<?php

class CategoriasController extends AppController {

    var $name = 'Categorias';

    function index(){
        
        $this->Categoria->recursive = -1;    
        $categorias = $this->Categoria->find('all',
                array('conditions' => array('Categoria.usuario_id' => $this->user_id),
                      'order' => 'nome asc'));
        $this->set(compact('categorias'));
    }
    
    function edit($id = null){

        $this->data = $this->Categoria->read(null, $id);
        if($this->data['Categoria']['usuario_id'] != $this->user_id){
            $this->data = null;
        }

        $this->layout = 'colorbox';
    }

    function editResponse(){
        
        $data = array_merge($this->params['url']);
        $this->Categoria->recursive = -1;
        $chk = $this->Categoria->find('first',
                            array('conditions' => array('Categoria.id' => $data['Categoria']['id']),
                                  'fields' => 'Categoria.usuario_id'));
        
        $result = $error = false;
        if($chk['Categoria']['usuario_id'] != $this->user_id){
            $error = 'Registro invpalido';
        }else{
                
            $this->Categoria->id = $data['Categoria']['id'];
            $data['Categoria']['usuario_id'] = $this->user_id;
            $result = $this->Categoria->save($data, true, array('nome'));
            $error = $this->validateErrors($this->Categoria);
        }
        
        $this->set('result', $result);
        $this->set('error', $error['nome']);
        $this->layout = 'ajax';
    }
}
