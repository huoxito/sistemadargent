    

    <div class="agendamentos index">
        
        <div id="contentHeader">    
            <?php   echo $this->element('agendamento_menu');    ?>
        </div>
        
        <div style="height: auto; overflow: hidden;padding:10px 0;width:100%;background-color:#e9ffcc;">

            <div class="balancoBotoes">
                
                <span class="pagina">Página</span>
                <p><?php echo $paginator->counter(array('format' => __('%page%',true))); ?></p>
                <span class="pagina">de</span>
                <p><?php echo $paginator->counter(array('format' => __('%pages%',true))); ?></p>
                <p>|</p>
                <p><?php echo $paginator->counter(array('format' => __('%count%',true))); ?></p>
                <span class="pagina">Registros</span>


                <div class="renda">
                    <?php echo $this->Html->image('renda.jpg',
                                            array('alt' => 'inserir categoria',
                                                  'width' => '143',
                                                  'height' => '19',
                                                  'url' => array('controller' => 'fontes',
                                                                 'action' => 'add'))); ?>
                </div>
                <div class="faturamento">
                    <?php echo $this->Html->image('faturamento.jpg',
                                            array('alt' => 'inserir faturamento',
                                                  'width' => '143',
                                                  'height' => '20',
                                                  'url' => array('controller' => 'ganhos',
                                                                 'action' => 'add'))); ?>
                </div>
            </div>
            
        </div>
        
        
        <cake:nocache>
        <?php   echo $this->Session->flash(); ?>
        </cake:nocache>
        
        <p id="paginator-info">
        <?php
        echo $paginator->counter(array(
        'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
        ));
        ?></p>
        <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?php echo $paginator->sort('tipo');?></th>
            <th style="text-align: center;"><?php echo $paginator->sort('Modificado', 'modified');?></th>
        </tr>
        <?php
        $i = 0;
        foreach ($agendamentos as $agendamento):
            $class = null;
            if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
            }
        ?>
            <tr<?php echo $class;?> id="agend-<?php echo $agendamento['Agendamento']['id']; ?>">
                
                <td>
                    <span style="display: block; margin: 10px 0 10px 10px;">
                        <span style="color: <?php echo $agendamento['Agendamento']['color']; ?>; font-weight: bold; font-family: Georgia;">
                            <?php echo $agendamento['Agendamento']['tipo']; ?>
                        </span>
                            -
                            <?php echo $agendamento['Frequencia']['nome']; ?>
                            -
                            R$ <?php echo $agendamento['Agendamento']['valor']; ?>
                            -
                            <?php echo $agendamento['Agendamento']['categoria']; ?>
                        
                    </span>
                    <div style="margin: 0 0 10px 30px;height: auto; overflow: hidden;">
                    
                        <?php if( !empty($agendamento['Valormensal']['diadomes']) ){    ?>
                        
                        <span style="display: block; font-weight: normal;">
                            <?php echo $agendamento['Agendamento']['numLancamentos']; ?> lançamentos restantes.
                            À ser confirmado no dia <?php echo $agendamento['Valormensal']['diadomes']; ?>.
                        </span>
                        
                        <span style="display: block; font-weight: normal;">
                            Próximo lançamento para <span style="color:#003D4C;"><?php echo $agendamento['Agendamento']['proximoReg']; ?></span>
                        </span>
                        
                        <?php   }else{  ?>
                        
                        <span style="display: block; font-weight: bold;">
                           Agendamento não concluído! <?php echo $html->link(__('Concluir Agendamento', true), array('action' => 'setarDatas', $agendamento['Agendamento']['id'])); ?> 
                        </span>
                        
                        <?php   }   ?>
                        
                        <?php   if( !empty($agendamento['Agendamento']['observacoes']) ){   ?>
                        <span style="float: left; font-weight: normal;">OBS: &nbsp;</span>   
                                    <?php   echo $agendamento['Agendamento']['observacoes']; ?>
                        <?php   }   ?>
                    
                    </div>
                    
                </td>
                
                <td class="actions">
                    <span style="display: block; margin: 20px 0 10px;"><?php echo $agendamento['Agendamento']['modified']; ?></span>
                    <?php if( !empty($agendamento['Valormensal']['diadomes']) ){    ?>
                    <?php echo $html->link(__('Editar', true), array('action' => 'edit', $agendamento['Agendamento']['id'],time()), array('title' => 'Editar Agendamento', 'class' => 'colorbox-edit')); ?>
                    <?php echo $html->link(__('Deletar', true), array('action' => 'delete', $agendamento['Agendamento']['id']), array('title' => 'Excluir Agendamento', 'class' => 'colorbox-delete')); ?>
                    <?php   }   ?>
                </td>
    
            </tr>
        <?php endforeach; ?>
        </table>
        
        <div class="paging">
            <?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
         | 	<?php echo $paginator->numbers();?>
            <?php echo $paginator->next(__('next', true).' >>', array(), null, array('class' => 'disabled'));?>
        </div>
    
    </div>
    
    <script type="text/javascript">
        // <![CDATA[
        $(document).ready(function () {
            $('.colorbox-delete').colorbox({width:"60%", height:"200", opacity: 0.5, iframe: true});
            $('.colorbox-edit').colorbox({width:"60%", height:"500", opacity: 0.5, iframe: true});
        });
        // ]]>
    </script>
    
    
    