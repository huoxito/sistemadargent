<?php
    //echo $this->element('sql_dump');
    $src = $this->Html->url('/').'uploads/usuario/foto/thumb/topo/'.$this->Session->read('Auth.Usuario.foto');
?>
    <img src="<?php echo $src; ?>" alt="<?php echo $this->Session->read('Auth.Usuario.nome'); ?>" />