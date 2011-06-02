<?php
    # variaveis de sessão do usuário
    $usuarioLogado = $session->read('Auth.Usuario.nome');
?>  

    <?= $this->Html->image('logo.png',
                        array('width' => '191',
                              'height' => '60',
                              'alt' => 'Dargent Sistema Financeiro',
                              'style' => 'margin-top:15px;',
                              'url' => '/')); ?>

    <div id="topo-right">
    
        <div id="UserInfoBox">
            
            <div style="float: right; padding: 0 0 0 10px;">
                
                <h1 id="userNameTopo"><?php echo $usuarioLogado; ?></h1>
                <span class="minhaconta">
                    <?php echo $this->Html->link('MINHA CONTA',
                                                array('controller' => '/',
                                                      'action' => 'perfil'));  ?>
                </span>
                
                <span class="sair">
                    <?php echo $this->Html->link('SAIR',
                                           array('controller' => 'usuarios',
                                                 'action' => 'logout'),
                                           array('alt'=> __('sair', true),
                                                 'title'=> __('sair', true)));?>
                </span> 
            
            </div>
        </div>
        
    </div>
    
