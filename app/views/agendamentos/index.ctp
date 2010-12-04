    

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
        
        <?php echo $this->Session->flash(); ?>
        
        <div class="registrosWraper">
            
            <?php   if(count($agendamentos) === 0){  ?>
                <p class="semResgistrosMsg">
                    Nenhum agendamento registrado
                </p>
            <?php   } ?>
            
            <ul id="list-categorias">
                
                <?php foreach ($agendamentos as $agendamento): ?>
                
                <li class="registros" id="agend<?php echo $agendamento['Agendamento']['id']; ?>">
                    
                    <span class="tipoAgendamentoLabel">
                        <?php echo $agendamento['Agendamento']['label']; ?>
                    </span>
                    
                    <div class="agendamentoInfo agendamentoInfo<?= $agendamento['Agendamento']['id']; ?>">
                        
                        <p class="agendamentoInfoLinha">
                            <span class="valorAgenda<?= $agendamento['Agendamento']['id']; ?>">
                                R$ <?= $agendamento['Agendamento']['valor']; ?>
                            </span> reais 
                            com
                            <span class="agendamentoCategoria categoria<?php echo $agendamento['Agendamento']['id']; ?>">
                                <?= $agendamento['Agendamento']['categoria']; ?>
                            </span> 
                        </p>
                        
                        <?php if( !empty($agendamento['Frequencia']['nome']) ){  ?>
                        <p class="agendamentoInfoLinha">
                            Frequência das parcelas:
                            <span class="agendamentoFrequencia"><?= $agendamento['Frequencia']['nome']; ?></span>.
                            <?php   if ( $agendamento['Agendamento']['numLancamentos'] > 0 ){ ?>
                            Restando <span class="agendamentoFrequência"><?= $agendamento['Agendamento']['numLancamentos'] ?></span> lançamentos.
                            <?php   } ?>
                        </p>
                        <?php } ?>
                        
                        <?php if( $agendamento['Agendamento']['proxLancamento'] ){  ?>
                        <p class="agendamentoInfoLinha" id="regId<?= $agendamento['Agendamento']['proximoRegId'] ?>">
                            Próximo lançamento: 
                            <span class="agendamentoProxLancamento">
                                <?= $agendamento['Agendamento']['proximoReg']; ?>
                            </span>
                            
                            <?= $this->Html->link('CONFIRMAR',
                                        array('action' => 'confirmaLancamento',
                                              $agendamento['Agendamento']['proximoRegId'],
                                              $agendamento['Agendamento']['model'],
                                              time()),
                                        array('class' => 'btnacoes confirmaAgendamento',
                                              'title' => 'Confirmar lançamento')); ?>
                            
                        </p>
                        <?php }else{ ?>
                        <p class="agendamentoInfoLinha agendamentoProxLancamento">
                            Agendamento concluído
                        </p>
                        <?php } ?>
                        
                        <p class="agendamentoInfoLinha Observacoes<?php echo $agendamento['Agendamento']['id']; ?>">
                        <?php   if( !empty($agendamento['Agendamento']['observacoes']) ){   ?>
                            Observações: <?= $agendamento['Agendamento']['observacoes']; ?>
                        <?php   }   ?>
                        </p> 
                        
                    </div>
                    
                    <?php if( $agendamento['Agendamento']['proxLancamento'] ){  ?>
                    <div class="categ-actions" style="margin-top: -45px;">
                        <?php
                            echo $this->Html->link('EDITAR',
                                            array('action' => 'edit',
                                                  $agendamento['Agendamento']['id'],time()),
                                            array('title' => 'Editar Agendamento',
                                                  'class' => 'colorbox-edit btneditar',
                                                  'title' => 'Editar Agendamento'));
                            echo $this->Html->link('EXCLUIR',
                                            array('action' => 'delete',
                                                  $agendamento['Agendamento']['id']),
                                            array('title' => 'Excluir Agendamento',
                                                  'class' => 'colorbox-delete btnexcluir',
                                                  'title' => 'Excluir Agendamento'));
                        ?>
                    </div>
                    <?php   }   ?>
                    
                </li>
                
                <?php endforeach; ?>
                
            </ul>
        
            <div class="paging">
                <?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
                <?php echo $paginator->numbers();?>
                <?php echo $paginator->next(__('next', true).' >>', array(), null, array('class' => 'disabled'));?>
            </div>
        
        </div>
    </div>
    
    <script type="text/javascript">
        // <![CDATA[
        $(document).ready(function () {
            $('.colorbox-delete').colorbox({width:"500", height: '220', opacity: 0.5, iframe: true});
            $('.colorbox-edit').colorbox({width:"800", height: "420", opacity: 0.5, iframe: true});
            $('.confirmaAgendamento').colorbox({width:"600", height:"300", opacity: 0.5, iframe: true});
        });
        // ]]>
    </script>
    
    
    