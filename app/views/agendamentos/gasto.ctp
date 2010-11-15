    
    <?php   echo $this->Html->script('jquery.textareaCounter.plugin');  ?>
    
    <div class="agendamentos form">
        
            <div id="contentHeader">
                <?php   echo $this->element('agendamento_menu'); ?>
            </div>
            
            <div class="balancoBotoesWraper">
                <div class="balancoBotoes">
                    
                    <p>Despesa sd fadsfasf sadfasodf dofasdif asdfiaosdf oifasfosdafhsdbafk</p>
                    
                    <div class="headeraddlinks">
                        <?php echo $this->Html->link('AGENDAR FATURAMENTO',
                                            array('controller' => 'agendamentos',
                                                  'action' => 'tipo', 'Ganho'),
                                            array('class' => 'btnadd')); ?>
                    </div>
                    <div class="headeraddlinks">
                    <?php echo $this->Html->link('LISTAR AGENDAMENTOS',
                                            array('controller' => 'agendamentos',
                                                  'action' => 'index'),
                                            array('class' => 'btnaddcategoria')); ?>
                    </div>
    
                </div>
                
            </div>
            
            <div class="formWraper">
            
                <?php echo $form->create('Agendamento',array('action' => 'tipo/Gasto'));?>
                <fieldset>
                <?php
                    echo $form->input('destino_id',
                                        array('empty' => 'Escolha um registro',
                                              'error' => false,
                                              'class' => 'select_categoria',
                                              'div' => array('id' => 'select_categoria'),
                                              'after' => '<a href="javascript:;" title="cadastrar" class="btnadd" onclick="insereInput(\'data[Destino][nome]\');">INSERIR NOVA CATEGORIA</a>'));
                    
                    echo $form->input('frequencia_id',
                                        array('empty' => 'Frequência',
                                              'error' => false));
                    
                    echo $form->input('valor',
                                        array('error' => false));
                    
                    echo $form->input('observacoes',
                                        array('type' => 'textarea',
                                              'label' => 'Observações',
                                              'id' => 'Observacoes'));
                    
                ?>
                </fieldset>
                <?php echo $form->end('Continuar');?>
            </div>
        
    </div>
    
    <?php   echo $this->Html->script('forms');  ?>
