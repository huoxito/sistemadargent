   
    <?= $this->Html->script('jquery.textareaCounter.plugin');  ?>
    
    <div class="ganhos form">
        
        <div id="contentHeader">
            <?= $this->element('ganho_menu'); ?>
        </div>
        
        <div class="balancoBotoesWraper">
            <div class="balancoBotoes">
                <p>
                    Insira aqui somente o que você já realmente ganhou.
                    Para programar um faturamento use a seção Agendamentos
                </p>
            </div>
        </div>
        
        <?= $this->Session->flash(); ?>
        
        <div class="formWraper formBox">
                 
            <?= $this->Form->create('Ganho',
                            array('inputDefaults' =>
                                    array('error' => false))); ?>
                                    
            <fieldset>
                
                <?= $this->Form->hidden('datadabaixa'); ?>
                <div class="datepickerWraper required">
                    <label class="labelCalendario">
                        Data da baixa
                    </label>    
                    <div id="datepicker"></div>
                    <span class="dataAmigavel change">
                        <?= $this->Data->formata($this->data['Ganho']['datadabaixa'], 'longadescricao'); ?>
                    </span>
                </div>
                
                <div class="inputsRight">
                
                    <?php if(!array_key_exists('Fonte',(array)$this->data)){ ?>
                    
                    <div id="selectCategoria" class="input text required">
                        <?= $this->Form->input('fonte_id',
                                            array('empty' => 'Escolha uma categoria',
                                                  'div' => false)); ?>
                        <a href="#" class="btnadd" title="inserir" id="insereInputFontes">
                            INSERIR NOVA FONTE
                        </a>
                    </div>
                    
                    <?php }else{ ?>
                    
                    <div id="inputCategoria" class="input text required">
                        <?= $this->Form->input('Fonte.nome',
                                            array('label' => 'Fonte',
                                                  'div' => false)); ?>
                        <a href="#" title="selecionar" class="btnadd" id="insereSelectFontes">
                            SELECIONAR UMA FONTE
                        </a>
                    </div>
                    
                    <?php } ?>
                
                    <?= $this->Form->input('valor');  ?>
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
    
    <?php echo $this->Html->script('forms'); ?>
    
    <? list($dia,$mes,$ano) = explode('-',$this->data['Ganho']['datadabaixa']); ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#datepicker').datepicker({
                        dateFormat: 'D, d MM, yy',
                        defaultDate: new Date(<?=$ano?>,<?=$mes-1?>,<?=$dia?>),
                        maxDate: 'dd-mm-yy',
                        altField: '#GanhoDatadabaixa',
                        altFormat: 'dd-mm-yy',
                        onSelect: function(dateText, inst){
                            $('.change').html(dateText);
                        }
            });
        });
    </script>
    
    