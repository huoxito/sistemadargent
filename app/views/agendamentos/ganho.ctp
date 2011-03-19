    
    <?php   echo $this->Html->script('jquery.textareaCounter.plugin');  ?>
    
    <div class="agendamentos form">
        
        <div id="contentHeader">
            <?php   echo $this->element('agendamento_menu'); ?>
        </div>
        
        <div class="balancoBotoesWraper">
            <div class="balancoBotoes">
                
                <p>
                    Aqui você pode programar um Faturamento.
                    Pode ser apenas um registro ou algo com várias parcelas.
                </p>
                
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
        
        <?php   echo $this->Session->flash(); ?>
        
        <div class="formWraper formBox">
        
            <?= $this->Form->create('Agendamento',
                            array('action' => 'tipo/Ganho',
                                  'inputDefaults' =>
                                    array('error' => array('wrap' => 'span'))));?>
            <fieldset>
            
                <?= $this->Form->hidden('datadevencimento'); ?>
                <div class="datepickerWraper required">
                    <label class="labelCalendario">
                        Data de vencimento
                    </label>
                    <span class="dataAmigavel change">
                        <?= $this->Data->formata($this->data['Agendamento']['datadevencimento'], 'longadescricao'); ?>
                    </span>
                    <div id="datepicker"></div>
                </div>
                
                <div class="inputsRight">
                    
                    <?php if(!array_key_exists('Fonte',(array)$this->data)){ ?>
                    
                    <div id="selectCategoria" class="input text required">
                        <?= $this->Form->input('fonte_id',
                                            array('empty' => 'Escolha uma categoria',
                                                  'div' => false,
                                                  'error' => false)); ?>
                        <a href="#" class="btnadd" title="inserir" id="insereInputFontes">
                            INSERIR NOVA FONTE
                        </a>
                        <?php if (isset($this->validationErrors['Agendamento']['fonte_id'])){ ?>
                            <span class="error-message">
                                <?= $this->validationErrors['Agendamento']['fonte_id'] ?>
                            </span>
                        <?php } ?>
                    </div>
                    
                    <?php }else{ ?>
                    
                    <div id="inputCategoria" class="input text required">
                        <?= $this->Form->input('Fonte.nome',
                                            array('label' => 'Fonte',
                                                  'div' => false,
                                                  'error' => false)); ?>
                        <a href="#" title="selecionar" class="btnadd" id="insereSelectFontes">
                            SELECIONAR UMA FONTE
                        </a>
                        <?php if (isset($this->validationErrors['Fonte']['nome'])){ ?>
                            <span class="error-message">
                                <?= $this->validationErrors['Fonte']['nome'] ?>
                            </span>
                        <?php } ?>
                    </div>
                    
                    <?php } ?>
                    
                    <?= $this->Form->input('conta_id'); ?>
                    <?= $this->Form->input('valor',
                                        array('id' => 'valorMask'));  ?>
                    <?= $this->Form->input('observacoes',
                                                    array('type' => 'textarea',
                                                          'label' => 'Observações',
                                                          'id' => 'Observacoes')); ?>
                    <div class="input">
                    <?php
                        $options = array('0'=>' Apenas um registro ', '1'=>' Parcelar ',);
                        $attributes = array('legend'=> false,
                                            'class' => 'config',
                                            'label' => false,
                                            'onchange' => 'disableOrNotInputs(this.value);');
                        echo $this->Form->radio('config',$options,$attributes);   
                    ?>
                    </div>
                    
                    <div class="leftInput">
                        <?= $this->Form->input('frequencia_id',
                                                array('label' => 'Frequência',
                                                      'empty' => 'Frequência',
                                                      'div' => false)); ?>
                    </div>
                    
                    <div class="leftInput">    
                        <?= $this->Form->input('numdeparcelas',
                                                array('label' => 'Número de parcelas',
                                                      'div' => false)); ?>
                    </div>  
                
                </div>
                
                <div class="submit">
                    <input type="submit" value="Agendar">
                    <?php echo $this->Form->checkbox('keepon'); ?>
                    <span class="label">Continuar programando registros</span>
                </div>
                
            </fieldset>

        </div> 
        
    </div>
    
    <script type="text/javascript">
        // variáveis que serão usadas em algumas funções do arquivo form.js
        var urlInsereInput = '<?= $this->Html->url(array("controller" => "ganhos", "action" => "InsereInput"));?>';
        var urlInsereSelect = '<?= $this->Html->url(array("controller" => "ganhos", "action" => "InsereSelect"));?>';
    </script>
    <?php   echo $this->Html->script('forms');  ?>
    
    <? list($dia,$mes,$ano) = explode('-',$this->data['Agendamento']['datadevencimento']); ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#datepicker').datepicker({
                        dateFormat: 'D, d MM, yy',
                        defaultDate: new Date(<?=$ano?>,<?=$mes-1?>,<?=$dia?>),
                        minDate: 'dd-mm-yy',
                        altField: '#AgendamentoDatadevencimento',
                        altFormat: 'dd-mm-yy',
                        onSelect: function(dateText, inst){
                            $('.change').html(dateText);
                        }
            });
        });
    </script>
    
    <script type="text/javascript">  
        disableOrNotInputs($(':radio:checked').val());
    </script>
    
    
