
    <?php   # $ultimoMes = $this->requestAction(array('controller' => 'homes', 'action' => 'ultimomes')); ?>
    
    <div class="actions">
        
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
        
    
    