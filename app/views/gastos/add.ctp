        
    <?= $this->Html->script('jquery.textareaCounter.plugin');  ?>
    
    <div class="gastos form">
        
        <div id="contentHeader">
            <?= $this->element('gasto_menu'); ?>
        </div>
        
        <div class="balancoBotoesWraper">
            <div class="balancoBotoes">
                <p>
                    Insira aqui somente o que você já realmente gastou.
                    Para programar uma despesa use a seção Agendamentos
                </p>
            </div>
        </div>
        
        <?= $this->Session->flash(); ?>
        
        <div class="formWraper formBox">
            
            <?= $this->Form->create('Gasto',
                            array('inputDefaults' =>
                                    array('error' => array('wrap' => 'span')))); ?>
            <fieldset>
                
                <?= $this->Form->hidden('datadabaixa'); ?>
                <div class="datepickerWraper required">
                    <label class="labelCalendario">
                        Data da baixa
                    </label>    
                    <div id="datepicker"></div>
                    <span class="dataAmigavel change">
                        <?= $this->Data->formata($this->data['Gasto']['datadabaixa'], 'longadescricao'); ?>
                    </span>
                </div>
                
                <div class="inputsRight">
                    
                    <?php if(!array_key_exists('Destino',(array)$this->data)){ ?>
                    
                    <div id="selectCategoria" class="input text required">
                        <?= $this->Form->input('destino_id',
                                            array('empty' => 'Escolha uma categoria',
                                                  'div' => false,
                                                  'error' => false)); ?>
                        <a href="#" class="btnadd" title="inserir" id="insereInputDestinos">
                            INSERIR NOVO DESTINO
                        </a>
                        <?php if (isset($this->validationErrors['Gasto']['destino_id'])){ ?>
                            <span class="error-message">
                                <?= $this->validationErrors['Gasto']['destino_id'] ?>
                            </span>
                        <?php } ?>
                    </div>
                    
                    <?php }else{ ?>
                    
                    <div id="inputCategoria" class="input text required">
                        <?= $this->Form->input('Destino.nome',
                                            array('label' => 'Destino',
                                                  'div' => false,
                                                  'error' => false)); ?>
                        <a href="#" title="selecionar" class="btnadd" id="insereSelectDestinos">
                            SELECIONAR UM DESTINO
                        </a>
                        <?php if (isset($this->validationErrors['Destino']['nome'])){ ?>
                            <span class="error-message">
                                <?= $this->validationErrors['Destino']['nome'] ?>
                            </span>
                        <?php } ?>
                    </div>
                    
                    <?php } ?>
                    
                    <?= $this->Form->input('conta_id'); ?>
                    <?= $this->Form->input('valor'); ?>
                    <?= $this->Form->input('observacoes',
                                            array('type' => 'textarea',
                                                  'label' => 'Observações',
                                                  'id' => 'Observacoes')); ?>
                                                  
                </div>
                
                <div class="submit">
                    <input type="submit" value="Inserir">
                    <?php echo $this->Form->checkbox('keepon'); ?>
                    <span class="label">Continuar inserindo registros</span>
                </div>
                
            </fieldset>
            
        </div>
        
    </div>
    
    <script type="text/javascript">
        // variáveis que serão usadas em algumas funções do arquivo form.js
        var urlInsereInput = '<?= $this->Html->url(array("action" => "InsereInput"));?>';
        var urlInsereSelect = '<?= $this->Html->url(array("action" => "InsereSelect"));?>';
    </script>
    
    <?php   echo $this->Html->script('forms'); ?>
    
    <? list($dia,$mes,$ano) = explode('-',$this->data['Gasto']['datadabaixa']); ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#datepicker').datepicker({
                        dateFormat: 'D, d MM, yy',
                        defaultDate: new Date(<?=$ano?>,<?=$mes-1?>,<?=$dia?>),
                        maxDate: 'dd-mm-yy',
                        altField: '#GastoDatadabaixa',
                        altFormat: 'dd-mm-yy',
                        onSelect: function(dateText, inst){
                            $('.change').html(dateText);
                        }
            });
        });
    </script>
    
    
    