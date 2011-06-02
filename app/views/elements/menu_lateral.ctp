
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
            <?= $this->Html->image('moedas.jpg',
                                    array('width' => '24',
                                          'height' => '18'));   ?>
            <?= $this->Html->link(__('Movimentações', true), array('controller' => 'moves', 'action' => 'index')); ?>
        </li>
        <li class="">
            <?= $this->Html->image('moedas.jpg',
                                    array('width' => '24',
                                          'height' => '18'));   ?>
            <?= $this->Html->link(__('Categorias', true), array('controller' => 'categorias', 'action' => 'index')); ?>
        </li>
        <li>
            <?= $this->Html->image('contas.png',
                                    array('width' => '16',
                                          'height' => '16'));   ?>
            <?= $this->Html->link(__('Contas', true), array('controller' => 'contas', 'action' => 'index')); ?>
        </li>
        <li>
            <?= $this->Html->image('graficos.jpg',
                                    array('width' => '18',
                                          'height' => '16'));   ?>
            <?= $this->Html->link(__('Gráficos', true), array('controller' => 'graficos')); ?>
        </li>
        <?php } ?>
    </ul>
</div>

