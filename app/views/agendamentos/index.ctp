    

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


                <div class="headeraddlinks">
                    <?php echo $this->Html->link('AGENDAR DESPESA',
                                        array('controller' => 'gastos',
                                              'action' => 'add', 'Gasto'),
                                        array('class' => 'btnadd')); ?>
                </div>
                <div class="headeraddlinks">
                    <?php echo $this->Html->link('AGENDAR FATURAMENTO',
                                        array('controller' => 'agendamentos',
                                              'action' => 'tipo', 'Ganho'),
                                        array('class' => 'btnaddcategoria')); ?>
                </div>
            </div>
            
        </div>
        
        
        <cake:nocache>
        <?php   echo $this->Session->flash(); ?>
        </cake:nocache>
        
        
        <ul id="list-categorias">
            
            <?php
                foreach ($agendamentos as $agendamento):
            ?>
            
            <li class="registros" id="agend-<?php echo $agendamento['Agendamento']['id']; ?>">
                
                <span style="display: block; margin: 10px 0;">
                    <span style="color: #000; ">
                        <?php echo $agendamento['Agendamento']['tipo']; ?>
                    </span>
                        -
                        <?php echo $agendamento['Frequencia']['nome']; ?>
                        -
                        R$ <?php echo $agendamento['Agendamento']['valor']; ?>
                        -
                        <?php echo $agendamento['Agendamento']['categoria']; ?>
                    
                </span>
                
                <div style="margin: 10px 0;height: auto; overflow: hidden;">
                    
                    <?php if( !empty($agendamento['Valormensal']['diadomes']) ){    ?>
                    
                    <span style="display: block; font-weight: normal;">
                        <?php echo $agendamento['Agendamento']['numLancamentos']; ?> lançamentos restantes.
                        À ser confirmado no dia <?php echo $agendamento['Valormensal']['diadomes']; ?>.
                    </span>
                    
                    <span style="display: block; font-weight: normal;">
                        Próximo lançamento para
                            <span style="color:#000;">
                                <?php echo $agendamento['Agendamento']['proximoReg']; ?>
                            </span>
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
                
                
                <div class="categ-actions" style="margin-top: -45px;">
                    <?php
                        echo $this->Html->link('',
                                        array('action' => 'edit',
                                              $agendamento['Agendamento']['id'],time()),
                                        array('title' => 'Editar Agendamento',
                                              'class' => 'colorbox-edit editar'));
                        echo $this->Html->link('',
                                        array('action' => 'delete',
                                              $agendamento['Agendamento']['id']),
                                        array('title' => 'Excluir Agendamento',
                                              'class' => 'colorbox-delete excluir'));
                    ?>
                </div>
                
            </li>
            
            <?php endforeach; ?>
            
        </ul>
        
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
            
            $(".registros").mouseover(function() {
                $(this).css("background-color",'#F2FFE3');
            }).mouseout(function(){
                $(this).css("background-color",'#FFF');
            });
             
        });
        // ]]>
    </script>
    
    
    