        <h2 class="headers">
            <?php __('Destinos');?>
        </h2>
        
        <div class="session-links">
            <ul>
                
                <li><?php echo $html->link(__('Inserir', true), array('controller' => 'destinos', 'action' => 'add')); ?></li>
                <li><?php echo $html->link(__('Cadastrar despesas', true), array('controller' => 'gastos', 'action' => 'add')); ?></li>
                
            </ul>
        </div>