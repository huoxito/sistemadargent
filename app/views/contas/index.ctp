

<div class="contas index">
    
    <div id="contentHeader">
        <h1><?php __('Contas');?></h1>
    </div>
    
    <div class="balancoBotoesWraper">

        <div class="balancoBotoes">
            
            <span class="pagina">Página</span>
            <p><?php echo $paginator->counter(array('format' => __('%page%',true))); ?></p>
            <span class="pagina">de</span>
            <p><?php echo $paginator->counter(array('format' => __('%pages%',true))); ?></p>
            <p>|</p>
            <p><?php echo $paginator->counter(array('format' => __('%count%',true))); ?></p>
            <span class="pagina">Registros</span>
            
            <div class="headeraddlinks">
                <?php echo $this->Html->link('CRIAR UMA NOVA CONTA',
                                    array('controller' => 'contas',
                                          'action' => 'add'),
                                    array('class' => 'btnadd')); ?>
            </div>
        </div>
        
    </div>
    
    <?php echo $this->Session->flash(); ?>
    
    <div class="registrosWraper">
            
        <table cellpadding="0" cellspacing="0">
            <?php
            $i = 0;
            foreach ($contas as $conta):
                $class = null;
                if ($i++ % 2 == 0) {
                    $class = ' class="altrow"';
                }
            ?>
            <tr<?php echo $class;?>>
                <td><?php echo $conta['Conta']['id']; ?></td>
                <td><?php echo $conta['Conta']['nome']; ?></td>
                <td><?php echo $conta['Conta']['saldo']; ?></td>
                <td><?php echo $conta['Conta']['tipo']; ?></td>
                <td><?php echo $conta['Conta']['created']; ?></td>
                <td><?php echo $conta['Conta']['status']; ?></td>
                <td class="actions">
                    <?php echo $this->Html->link(__('View', true), array('action' => 'view', $conta['Conta']['id'])); ?>
                    <?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $conta['Conta']['id'])); ?>
                    <?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $conta['Conta']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $conta['Conta']['id'])); ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    
        <div class="paging">
            <?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
            <?php echo $paginator->numbers();?>
            <?php echo $paginator->next(__('next', true).' >>', array(), null, array('class' => 'disabled'));?>
        </div>
    
    </div>

</div>

