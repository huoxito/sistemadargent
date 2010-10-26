        <h2 class="headers">
            <?php __('Faturamentos');?>
        </h2>
        
        <div class="session-links">
            <ul>
                <li><?php echo $html->link(__('Inserir', true), array('action' => 'add')); ?></li>
                <li><?php echo $html->link(__('Cadastrar Fonte', true), array('controller' => 'fontes', 'action' => 'add')); ?></li>
            </ul>
        </div>