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


}
