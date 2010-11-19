    
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
                
                echo $this->Form->input('datadevencimento',
                                    array('label' => 'Data de vencimento',
                                          'type' => 'text',
                                          'error' => false,
                                          'class' => 'dateFieldAhead',
                                          'default' => date('d-m-Y')));
                
                echo $form->input('valor',
                                    array('error' => false));
                
                echo $form->input('observacoes',
                                    array('type' => 'textarea',
                                          'label' => 'Observações',
                                          'id' => 'Observacoes'));
                
                $options = array('0'=>'Apenas um resgistro', '1'=>'Parcelar',);
                $attributes = array('legend'=> false,
                                    'class' => 'config',
                                    'label' => false,
                                    'onchange' => 'disableOrNotInputs(this.value);');
                echo $this->Form->radio('config',$options,$attributes);   
                
            ?>
                
                <div id="camposParcela">
                    <?php
                        echo $this->Form->input('frequencia_id',
                                            array('label' => 'Frequência',
                                                  'empty' => 'Frequência',
                                                  'error' => false));
                        
                        echo $this->Form->input('numdeparcelas',
                                            array('label' => 'Número de parcelas'));
                        
                    ?>
                </div>  
            
            </fieldset>
            
            <?php echo $form->end('Continuar');?>
        </div>
        
    </div>
    
    <?php   echo $this->Html->script('forms');  ?>
    
    <script type="text/javascript">  
        disableOrNotInputs($(':radio:checked').val());
    </script>
