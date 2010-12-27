   
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
        
        <div class="formWraper">
                 
            <?= $this->Form->create('Ganho');?>
            <fieldset>
                
                <?php if(!array_key_exists('Fonte',(array)$this->data)){ ?>
                
                <div id="selectCategoria" class="input text required">
                    <?= $this->Form->input('fonte_id',
                                        array('empty' => 'Escolha uma categoria',
                                              'div' => false)); ?>
                    <a href="javascript:;" class="btnadd" title="inserir fonte" onclick="insereInputFontes();">
                        INSERIR NOVA FONTE
                    </a>
                </div>
                
                <?php }else{ ?>
                
                <div id="inputCategoria" class="input text required">
                    <?= $this->Form->input('Fonte.nome',
                                        array('label' => 'Fonte',
                                              'div' => false)); ?>
                    <a href="javascript:;" title="cadastrar fonte" class="btnadd" onclick="insereSelectFontes();">
                        SELECIONAR UMA FONTE
                    </a>
                </div>
                
                <?php } ?>
                
            <?php   
                echo $this->Form->input('valor');
                echo $this->Form->input('datadabaixa',
                                    array('label' => 'Data da baixa',
                                          'type' => 'text',
                                          'class' => 'dataField',
                                          'default' => date('d-m-Y')));
                
                echo $this->Form->input('observacoes',
                                    array('type' => 'textarea',
                                          'label' => 'Observações',
                                          'id' => 'Observacoes'));
            ?>
            <div>
                
                <?php echo $this->Form->checkbox('keepon'); ?>
                <span class="label">Continuar inserindo registros</span>  
            </div>
            </fieldset>
            <?php echo $this->Form->end('Inserir');?>
            
        </div>

    </div>
    
    <?php echo $this->Html->script('forms'); ?>
    
    
    