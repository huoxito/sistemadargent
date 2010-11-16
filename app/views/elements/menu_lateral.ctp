
    <?php   # $ultimoMes = $this->requestAction(array('controller' => 'homes', 'action' => 'ultimomes')); ?>
    
    <div id="menuLateral">
        <img src="<?php echo $html->url('/'); ?>img/topo-left.jpg" width="190" height="8" />
        <ul>
            <li>
                <?php   echo $this->Html->image('casinha.jpg',
                                        array('width' => '18',
                                              'height' => '17'));   ?>
                <?php echo $html->link(__('Painel', true), array('controller' => 'homes','action' => '/')); ?>
            </li>
            <li style="border-bottom:none;">
                <?php   echo $this->Html->image('moedas.jpg',
                                        array('width' => '24',
                                              'height' => '18'));   ?>
                <?php echo $html->link(__('Faturamentos', true), array('controller' => 'ganhos', 'action' => 'index')); ?>
            </li>
            <li class="subitem">
                <?php echo $html->link(__('Fontes', true), array('controller' => 'fontes', 'action' => 'index')); ?>
            </li>
            <li style="border-bottom:none;">
                <img src="<?php echo $html->url('/'); ?>img/casinha.jpg" width="18" height="17" />
                <?php echo $html->link(__('Despesas', true), array('controller' => 'gastos', 'action' => 'index')); ?>
            </li>
            <li class="subitem">
                <?php echo $html->link(__('Destinos', true), array('controller' => 'destinos', 'action' => 'index')); ?>
            </li>
            <li>
                <?php   echo $this->Html->image('calendario.jpg',
                                        array('width' => '20',
                                              'height' => '19'));   ?>
                <?php echo $html->link(__('Agendamentos', true), array('controller' => 'agendamentos', 'action' => 'index')); ?>
            </li>
            <li>
                <?php   echo $this->Html->image('graficos.jpg',
                                        array('width' => '18',
                                              'height' => '16'));   ?>
                <?php echo $html->link(__('Gráficos', true), array('controller' => 'homes', 'action' => 'graficos')); ?>
            </li>

        </ul>
        <div class="banner-1"><img src="<?php echo $html->url('/'); ?>img/bn.jpg" width="160" height="90" /></div>
    </div>