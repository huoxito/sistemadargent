

<div class="contas index">
    
    <div id="contentHeader">
        <h1><?php __('Contas');?></h1>
    </div>
    
    <div class="balancoBotoesWraper">

        <div class="balancoBotoes">
            
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
                <td><?= $conta['Conta']['nome']; ?></td>
                <td>
                    R$ <?= $this->Valor->formata($conta['Conta']['saldo']); ?>
                </td>
                <td><?= $conta['Conta']['tipo']; ?></td>
                <td><?= $conta['Conta']['created']; ?></td>
                <td><?= $conta['Conta']['status']; ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View', true), array('action' => 'view', $conta['Conta']['id'])); ?>
                    <?= $this->Html->link(__('Edit', true), array('action' => 'edit', $conta['Conta']['id'])); ?>
                    <?= $this->Html->link(__('Delete', true), array('action' => 'delete', $conta['Conta']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $conta['Conta']['id'])); ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        
    </div>

</div>

