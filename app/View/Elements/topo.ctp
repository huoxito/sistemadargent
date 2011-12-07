<div id=topo>
    <div id=logo>
        <?= $this->Html->image('logo_1.png',
                    array('width' => '96', 'height' => '30',
                          'alt' => 'Dargent Sistema Financeiro', 'url' => '/')); ?>
    </div>
    
    <div id="UserInfoBox">
        <p id="userNameTopo">
            <?= AuthComponent::user('nome'); ?>
            <?= $this->Html->link('Minha conta',
                    array('controller' => '/', 'action' => 'perfil'),
                    array('class' => 'my-account'));  ?>

            <?= $this->Html->link('Sair',
                   array('controller' => 'usuarios', 'action' => 'logout'),
                   array('alt'=> __('sair'), 'title'=> __('sair'), 'class' => 'logout'));?>
        </p>
        
    </div>
</div>
