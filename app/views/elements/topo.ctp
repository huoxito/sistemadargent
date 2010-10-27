    
    <h1><?php echo __('Dargent :: Sistema Simples de Gerenciamento Financeiro', true); ?></h1>
    
    <?php
        $usuarioLogado = $session->read('Auth.Usuario.nome');
        $userFoto = $session->read('Auth.Usuario.foto');
    ?>        

    <div id="userinfo">
        
        <?php //echo $html->link('Home', '/'); ?>
        <?php echo $this->Html->link(
                $this->Html->image('home.png', array('alt'=> __('página inicial', true), 'title'=> __('página inicial', true), 'border' => '0')),
					'/',
                    array('escape' => false)
				);
        ?>
        <p style="margin: 10px 0 0 10px; float: left;"><?php echo $usuarioLogado; ?></p>
    
        <?php
        
            echo $html->link('Sugestões', array('controller' => 'sugestos', 'action' => 'add'), array('style' => 'display: block; margin: 10px 0 0 15px;', 'alt'=> __('Sugestões', true), 'title'=> __('Sugestões', true)));
        
            echo $html->link('Logout', array('controller' => 'usuarios', 'action' => 'logout'), array('style' => 'display: block; margin: 10px 0 0 15px;', 'alt'=> __('sair', true), 'title'=> __('sair', true)));
        
        ?>
        
        <?php if( !empty($userFoto) ){   ?>
        <div style="margin: 5px; float: right;" id="perfil-t">
            <img src="<?php echo $this->Html->url('/'); ?>uploads/usuario/foto/thumb/topo/<?php echo $session->read('Auth.Usuario.foto'); ?>" alt="<?php echo $session->read('Auth.Usuario.nome'); ?>" />
        </div>
        <?php   }   ?>
        
    </div>

    
    