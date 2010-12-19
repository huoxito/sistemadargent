
<div id="menuLateral">
    
    <?= $this->Html->image('topo-left.jpg',
                            array('width' => '190',
                                  'height' => '8'));   ?>
    <ul>
        <?php if($godfather){   ?>
        <li>
            <?= $this->Html->link(__('Usuários', true), array('controller' => 'usuarios')); ?>
        </li>
        <li>
            <?= $this->Html->link(__('Sugestões', true), array('controller' => 'sugestoes')); ?>
        </li>
        <?php }else{ ?>
        <li>
            <?= $this->Html->image('casinha.jpg',
                                    array('width' => '18',
                                          'height' => '17'));   ?>
            <?= $this->Html->link(__('Painel', true), array('controller' => 'homes','action' => '/')); ?>
        </li>
        <li style="border-bottom:none;">
            <?= $this->Html->image('moedas.jpg',
                                    array('width' => '24',
                                          'height' => '18'));   ?>
            <?= $this->Html->link(__('Faturamentos', true), array('controller' => 'ganhos', 'action' => 'index')); ?>
        </li>
        <li class="subitem">
            <?= $this->Html->link(__('Fontes', true), array('controller' => 'fontes', 'action' => 'index')); ?>
        </li>
        <li style="border-bottom:none;">
            <?= $this->Html->image('casinha.jpg',
                                    array('width' => '18',
                                          'height' => '17'));   ?>
            <?= $this->Html->link(__('Despesas', true), array('controller' => 'gastos', 'action' => 'index')); ?>
        </li>
        <li class="subitem">
            <?= $this->Html->link(__('Destinos', true), array('controller' => 'destinos', 'action' => 'index')); ?>
        </li>
        <li>
            <?= $this->Html->image('calendario.jpg',
                                    array('width' => '20',
                                          'height' => '19'));   ?>
            <?= $this->Html->link(__('Agendamentos', true), array('controller' => 'agendamentos', 'action' => 'index')); ?>
        </li>
        <li>
            <?= $this->Html->image('graficos.jpg',
                                    array('width' => '18',
                                          'height' => '16'));   ?>
            <?= $this->Html->link(__('Gráficos', true), array('controller' => 'homes', 'action' => 'graficos')); ?>
        </li>
        <?php } ?>
    </ul>
</div>

