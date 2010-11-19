    

    <div class="agendamentos index">
        
        <div id="contentHeader">    
            <?php   echo $this->element('agendamento_menu');    ?>
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
                    <?php echo $this->Html->link('AGENDAR DESPESA',
                                        array('controller' => 'agendamentos',
                                              'action' => 'tipo', 'Gasto'),
                                        array('class' => 'btnadd')); ?>
                </div>
                <div class="headeraddlinks">
                    <?php echo $this->Html->link('AGENDAR FATURAMENTO',
                                        array('controller' => 'agendamentos',
                                              'action' => 'tipo', 'Ganho'),
                                        array('class' => 'btnadd')); ?>
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
                
                <span class="tipoAgendamentoLabel">
                    <?php echo $agendamento['Agendamento']['label']; ?>
                </span>
                
                <div class="agendamentoInfo">
                    
                    <p class="agendamentoInfoLinha">
                        R$ <?= $agendamento['Agendamento']['valor']; ?> reais 
                        com
                        <span class="agendamentoCategoria">
                            <?= $agendamento['Agendamento']['categoria']; ?>
                        </span> 
                    </p>
                    
                    <?php if(!empty($agendamento['Frequencia']['nome'])){  ?>
                    <p class="agendamentoInfoLinha">
                        Frequência das parcelas:
                        <span class="agendamentoFrequencia"><?= $agendamento['Frequencia']['nome']; ?></span>.
                        Restando <span class="agendamentoFrequência"><?= $agendamento['Agendamento']['numLancamentos'] ?></span> lançamentos.
                    </p>
                    <?php } ?>
                    
                    <p class="agendamentoInfoLinha">
                        Próximo lançamento para
                        <span class="agendamentoProxLancamento">
                            <?= $agendamento['Agendamento']['proximoReg']; ?>
                        </span>
                        
                        <?= $this->Html->link('CONFIRMAR',
                                    array('action' => 'confirmaLancamento',
                                          $agendamento['Agendamento']['proxvencimento'],
                                          $agendamento['Agendamento']['model'],
                                          $agendamento['Agendamento']['id'],time()),
                                    array('onclick' => 'confirmar('.$agendamento['Agendamento']['id'].',\''.$agendamento['Agendamento']['model'].'\')',
                                          'class' => 'btnacoes confirmaAgendamento',
                                          'title' => 'Confirmar lançamento')); ?>
                        
                    </p>
                    
                    <?php   if( !empty($agendamento['Agendamento']['observacoes']) ){   ?>
                    <p class="agendamentoInfoLinha Observacoes">
                        Observações: <?= $agendamento['Agendamento']['observacoes']; ?>
                    </p> 
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
            $('.confirmaAgendamento').colorbox({width:"600", height:"300", opacity: 0.5, iframe: true});
        });
        // ]]>
    </script>
    
    
    