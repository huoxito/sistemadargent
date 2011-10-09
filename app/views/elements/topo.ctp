<?php
    # variaveis de sessão do usuário
    $usuarioLogado = $session->read('Auth.Usuario.login');
?>  

    <?= $this->Html->image('logo.png',
                        array('width' => '131',
                              'height' => '30',
                              'alt' => 'Dargent Sistema Financeiro',
                              'url' => '/')); ?>

    <div id="topo-right">
    
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
    
