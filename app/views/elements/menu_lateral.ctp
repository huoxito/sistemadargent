
<div id="menuLateral">

    <?= $this->Html->image('topo-left.jpg',
                            array('width' => '190',
                                  'height' => '8'));   ?>
    <ul>
        <?php if($godfather){   ?>
        <li>
            <?= $this->Html->link(__('Usuários', true), array('controller' => 'usuarios', 'action' => 'index')); ?>
        </li>
        <?php }else{ ?>
        <li style="">
            <?= $this->Html->link(__('MOVIMENTAÇÕES', true), array('controller' => 'moves', 'action' => 'index')); ?>
        </li>
        <li class="">
            <?= $this->Html->link(__('CATEGORIAS', true), array('controller' => 'categorias', 'action' => 'index')); ?>
        </li>
        <li>
            <?= $this->Html->link(__('CONTAS', true), array('controller' => 'contas', 'action' => 'index')); ?>
        </li>
        <li>
            <?= $this->Html->link(__('GRÁFICOS', true), array('controller' => 'graficos')); ?>
        </li>
        <?php } ?>
    </ul>
</div>

