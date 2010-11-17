        
    <?php   echo $this->Html->script('jquery.textareaCounter.plugin');  ?>
    
    <div class="gastos form">
        
        <div id="contentHeader">
            <?php   echo $this->element('gasto_menu'); ?>
        </div>
        
        <div class="balancoBotoesWraper">
            <div class="balancoBotoes">
                <p>Insira aqui somente o que você já realmente gastou. Para programar uma despesa use a seção Agendamentos</p>
            </div>
        </div>
        
        <cake:nocache>
        <?php   echo $this->Session->flash(); ?>
        </cake:nocache>
        
        <?php $linkCategoria = '<a href="javascript:;" class="btnadd" title="inserir" onclick="insereInputDestinos();">INSERIR NOVO DESTINO</a>'; ?>
        
        <div class="formWraper">
            
            <?php echo $this->Form->create('Gasto');?>
            <fieldset>
            <?php    
                echo $this->Form->input('destino_id', array('empty' => 'Escolha um registro',
                                                      'error' => false,
                                                      'after' => $linkCategoria));
                
                echo $this->Form->input('valor', array('error' => false));
                
                echo $this->Form->input('datadabaixa', array('label' => 'Data da baixa',
                                                        'type' => 'text',
                                                        'error' => false,
                                                        'class' => 'dataField',
                                                        'default' => date('d-m-Y')
                                                ));
                
                echo $this->Form->input('observacoes', array('type' => 'textarea',
                                                        'label' => 'Observações',
                                                        'id' => 'Observacoes'));
            ?>
                <?php echo $this->Form->checkbox('keepon'); ?>
                <span>Marque se você desejar continuar inserindo registros nessa página</span>  
            </fieldset>
            <?php echo $this->Form->end('Inserir');?>
            
        </div>
        
    </div>
    
    <?php   echo $this->Html->script('forms'); ?>
    