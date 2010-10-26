        
        <h2  class="headers">
            <?php __('Agendamentos');?>
        </h2>
    
        <div class="session-links">
            <ul>
                <li><?php echo $html->link(__('Agendar Despesa', true), array('action' => 'tipo','Gasto')); ?></li>
                <li><?php echo $html->link(__('Agendar Faturamento', true), array('action' => 'tipo','Ganho')); ?></li>
            </ul>
        </div>