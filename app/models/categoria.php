<?php 


class Categoria extends AppModel {

    var $name = "Categorias";

    function listar($usuario_id){
        return $this->find('list',
                     array('conditions' => 
                                array('Categoria.usuario_id' => $usuario_id),
                           'order' => 'Categoria.id desc'));
    }

}
