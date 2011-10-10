
<div id="menuLateral">

    <ul>
        <?php if($godfather){   ?>
        <li>
            <?= $this->Html->link(__('Usuários', true), array('controller' => 'usuarios', 'action' => 'index')); ?>
        </li>
        <?php }else{ ?>
        <li style="">
            <?= $this->Html->link(__('Movimentações', true), array('controller' => 'moves', 'action' => 'index')); ?>
        </li>
        <li class="">
            <?= $this->Html->link(__('Categorias', true), array('controller' => 'categorias', 'action' => 'index')); ?>
        </li>
        <li>
            <?= $this->Html->link(__('Contas', true), array('controller' => 'contas', 'action' => 'index')); ?>
        </li>
        <li>
            <?= $this->Html->link(__('Gráficos', true), array('controller' => 'graficos')); ?>
        </li>
        <?php } ?>
    </ul>
</div>

