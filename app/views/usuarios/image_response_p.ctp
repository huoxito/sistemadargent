<?php
    //echo $this->element('sql_dump');
    $src = $this->Html->url('/').'uploads/usuario/foto/thumb/gerenciador/'.$session->read('Auth.Usuario.foto');
?>
    <img src="<?php echo $src; ?>" alt="<?php echo $session->read('Auth.Usuario.nome'); ?>" />