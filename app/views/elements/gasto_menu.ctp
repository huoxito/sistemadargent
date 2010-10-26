        <h2 class="headers">
            <?php __('Despesas');?>
        </h2>
        
        <div class="session-links">
            <ul>
                <li><?php echo $html->link(__('Inserir', true), array('action' => 'add')); ?></li>
                <li><?php echo $html->link(__('Cadastrar Destino', true), array('controller' => 'destinos', 'action' => 'add')); ?></li>
            </ul>
        </div>