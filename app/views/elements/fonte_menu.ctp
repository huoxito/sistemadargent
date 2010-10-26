        <h2 class="headers">
            <?php __('Fontes');?>
        </h2>
        
        <div class="session-links">
            <ul>
                <li><?php echo $html->link(__('Inserir', true), array('controller' => 'fontes', 'action' => 'add')); ?></li>
                <li><?php echo $html->link(__('Cadastrar Faturamento', true), array('controller' => 'ganhos', 'action' => 'add')); ?></li>
            </ul>
        </div>