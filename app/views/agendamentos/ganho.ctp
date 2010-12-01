    
    <?php   echo $this->Html->script('jquery.textareaCounter.plugin');  ?>
    
    <div class="agendamentos form">
        
        <div id="contentHeader">
            <?php   echo $this->element('agendamento_menu'); ?>
        </div>
        
        <div class="balancoBotoesWraper">
            <div class="balancoBotoes">
                
                <p>Aqui você pode programar um Faturamento. Pode ser apenas um registro ou algo com várias parcelas.</p>
                
                <div class="headeraddlinks">
                    <?php echo $this->Html->link('AGENDAR DESPESA',
                                        array('controller' => 'agendamentos',
                                              'action' => 'tipo', 'Gasto'),
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
        
        <cake:nocache>
        <?php   echo $this->Session->flash(); ?>
        </cake:nocache>
        
        <div class="formWraper">
        
            <?php echo $this->Form->create('Agendamento',array('action' => 'tipo/Ganho'));?>
            <fieldset>
            <?php
                echo $this->Form->input('fonte_id',
                                    array('empty' => 'Escolha um registro',
                                          'error' => false,
                                          'class' => 'select_categoria',
                                          'div' => array('id' => 'select_categoria'),
                                          'after' => '<a href="javascript:;" title="cadastrar" class="btnadd" onclick="insereInput(\'data[Fonte][nome]\');">INSERIR NOVA CATEGORIA</a>'));
                
                echo $this->Form->input('valor',
                                    array('error' => false));
                
                echo $this->Form->input('observacoes',
                                    array('type' => 'textarea',
                                          'label' => 'Observações',
                                          'id' => 'Observacoes'));
                
                echo $this->Form->input('datadevencimento',
                                    array('label' => 'Data de vencimento',
                                          'type' => 'text',
                                          'error' => false,
                                          'class' => 'dateFieldAhead',
                                          'default' => date('d-m-Y')));
                
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
            
            <?php echo $this->Form->end('Agendar');?>
        
        </div> 
        
    </div>
    
    <?php   echo $this->Html->script('forms');  ?>
    
    <script type="text/javascript">  
        disableOrNotInputs($(':radio:checked').val());
    </script>
    
    
