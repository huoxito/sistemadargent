    
    <div class="sugestos index">
        
        
        <div id="contentHeader">
            <h1>
                <?php __('Sugestões');?>
            </h1>
        </div>
        
        <div class="balancoBotoesWraper">
        <div class="balancoBotoes">
            
            <p>SUAS SUGESTÕES SÃO LISTADAS AQUI |</p>
            
            <span class="pagina">Página</span>
            <p><?php echo $this->Paginator->counter(array('format' => __('%page%',true))); ?></p>
            <span class="pagina">de</span>
            <p><?php echo $this->Paginator->counter(array('format' => __('%pages%',true))); ?></p>
            <p>|</p>
            <p><?php echo $this->Paginator->counter(array('format' => __('%count%',true))); ?></p>
            <span class="pagina">Registros</span>
            
            <div class="headeraddlinks">
                <?php echo $this->Html->link('ENVIAR UMA SUGESTÃO',
                                    array('controller' => 'sugestoes',
                                          'action' => 'add'),
                                    array('class' => 'btnadd')); ?>
            </div>
        </div>
        </div>
        
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
