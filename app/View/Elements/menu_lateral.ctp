
<div id="menuLateral">

    <ul>
        <?php if($godfather){   ?>
        <li>
            <?= $this->Html->link(__('Usuários'), array('controller' => 'usuarios', 'action' => 'index')); ?>
        </li>
        <?php }else{ ?>
        <li style="">
            <?= $this->Html->link(__('Movimentações'), array('controller' => 'moves', 'action' => 'index')); ?>
        </li>
        <li class="">
            <?= $this->Html->link(__('Categorias'), array('controller' => 'categorias', 'action' => 'index')); ?>
        </li>
        <li>
            <?= $this->Html->link(__('Contas'), array('controller' => 'contas', 'action' => 'index')); ?>
        </li>
        <li>
            <?= $this->Html->link(__('Gráficos'), array('controller' => 'graficos')); ?>
        </li>
        <?php } ?>
    </ul>
</div>

