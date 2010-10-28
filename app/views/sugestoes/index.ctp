    
    <div class="sugestos index">
        <h2 class="headers"><?php __('Sugestões');?></h2>
        <div class="session-links">
        <ul>
            <li>
                <?php echo $this->Html->link('Enviar uma sugestão',
                                             array('controller' => 'sugestoes', 'action' => 'add'),
                                             array('class' => '')); ?>
            </li>
        </ul>
        </div>
    <p id="paginator-info">
        
    <?php
        echo $paginator->counter(
            array('format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
    ));
    ?>
    </p>
    
    <table cellpadding="0" cellspacing="0">
    <tr>
        <th colspan="2">Suas sugestões</th>
    </tr>
    <?php
    $i = 0;
    foreach ($sugestos as $sugesto):
        $class = null;
        if ($i++ % 2 == 0) {
            $class = ' class="altrow"';
        }
    ?>
        <tr<?php echo $class;?>>

            <td>
                <?php echo $sugesto['Sugestao']['titulo']; ?>
                <?php echo $sugesto['Sugestao']['texto']; ?>
            </td>
            <td>
                <?php echo $sugesto['Sugestao']['created']; ?>
            </td>

            
        </tr>
    <?php endforeach; ?>
    </table>
    </div>
    <div class="paging">
        <?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
     | 	<?php echo $paginator->numbers();?>
        <?php echo $paginator->next(__('next', true).' >>', array(), null, array('class' => 'disabled'));?>
    </div>
    <div class="actions">
        <ul>
            <li><?php echo $html->link(__('New Sugestao', true), array('action' => 'add')); ?></li>
            <li><?php echo $html->link(__('List Fontes', true), array('controller' => 'fontes', 'action' => 'index')); ?> </li>
            <li><?php echo $html->link(__('New Fonte', true), array('controller' => 'fontes', 'action' => 'add')); ?> </li>
            <li><?php echo $html->link(__('List Usuarios', true), array('controller' => 'usuarios', 'action' => 'index')); ?> </li>
            <li><?php echo $html->link(__('New Usuario', true), array('controller' => 'usuarios', 'action' => 'add')); ?> </li>
        </ul>
    </div>