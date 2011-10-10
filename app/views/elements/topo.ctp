<?php
    # variaveis de sessão do usuário
    $usuarioLogado = $session->read('Auth.Usuario.email');
?>  

<div id=topo>
    <div id=logo>
        <?= $this->Html->image('logo_1.png',
                            array('width' => '96',
                                  'height' => '30',
                                  'alt' => 'Dargent Sistema Financeiro',
                                  'url' => '/')); ?>
    </div>
    
    <div id="UserInfoBox">
            
        <p id="userNameTopo">
            <?php echo $usuarioLogado; ?>
            <?php echo $this->Html->link('Minha conta',
                                        array('controller' => '/',
                                              'action' => 'perfil'),
                                        array('class' => 'my-account'));  ?>
        
            <?php echo $this->Html->link('Sair',
                                   array('controller' => 'usuarios',
                                         'action' => 'logout'),
                                   array('alt'=> __('sair', true),
                                         'title'=> __('sair', true),
                                         'class' => 'logout'));?>
        </p>
        
    </div>
</div>
