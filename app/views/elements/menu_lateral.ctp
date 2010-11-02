
    <?php   # $ultimoMes = $this->requestAction(array('controller' => 'homes', 'action' => 'ultimomes')); ?>
    
    <div id="menuLateral">
        <img src="<?php echo $html->url('/'); ?>img/topo-left.jpg" width="190" height="8" />
        <ul>
            <li>
                <img src="<?php echo $html->url('/'); ?>img/casinha.jpg" width="18" height="17" />
                <?php echo $html->link(__('Painel', true), array('controller' => 'homes','action' => '/')); ?>
            </li>
            <li style="border-bottom:none;">
                <img src="<?php echo $html->url('/'); ?>img/casinha.jpg" width="18" height="17" />
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
                <img src="<?php echo $html->url('/'); ?>img/casinha.jpg" width="18" height="17" />
                <?php echo $html->link(__('Agendamentos', true), array('controller' => 'agendamentos', 'action' => 'index')); ?>
            </li>
            <li>
                <img src="<?php echo $html->url('/'); ?>img/casinha.jpg" width="18" height="17" />
                <?php echo $html->link(__('Gráficos', true), array('controller' => 'homes', 'action' => 'graficos')); ?>
            </li>

        </ul>
        <div class="banner-1"><img src="<?php echo $html->url('/'); ?>img/bn.jpg" width="160" height="90" /></div>
    </div>
    <!--
    <div id="menuLateral">
        
		<ul>
            <li><?php echo $html->link(__('Home', true), array('controller' => 'homes','action' => '/')); ?></li>
            <li><?php echo $html->link(__('Faturamentos', true), array('controller' => 'ganhos', 'action' => 'index')); ?></li>
            <li class="subitem"><?php echo $html->link(__('Fontes', true), array('controller' => 'fontes', 'action' => 'index')); ?></li>
            <li><?php echo $html->link(__('Despesas', true), array('controller' => 'gastos', 'action' => 'index')); ?></li>
            <li class="subitem"><?php echo $html->link(__('Destinos', true), array('controller' => 'destinos', 'action' => 'index')); ?></li>
            <li>&nbsp;</li>
            <li><?php echo $html->link(__('Agendamentos', true), array('controller' => 'agendamentos', 'action' => 'index')); ?></li>
            <li><?php echo $html->link(__('Gráficos', true), array('controller' => 'homes', 'action' => 'graficos')); ?></li>
			
        </ul>
        
	</div>
    -->
    
    