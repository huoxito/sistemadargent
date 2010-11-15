   
    <?php   echo $this->Html->script('jquery.textareaCounter.plugin');  ?>
    
    <div class="ganhos form">
        
        <div id="contentHeader">
            <?php   echo $this->element('ganho_menu'); ?>
        </div>
        
        <div class="balancoBotoesWraper">
            <div class="balancoBotoes">
                <p>Insira aqui somente o que você já realmente ganhou. Para programar um faturamento use a seção Agendamentos</p>
            </div>
        </div>
        
        <?php $linkCategoria = '<a href="javascript:;" class="btnadd" title="inserir fonte" onclick="insereInputFontes();">INSERIR NOVA FONTE</a>'; ?>
        
        <cake:nocache>
        <?php   echo $this->Session->flash(); ?>
        </cake:nocache>
        
        <div class="formWraper">
                 
            <?php echo $form->create('Ganho');?>
            <fieldset>
            <?php
                echo $form->input('fonte_id', array('empty' => 'Escolha um registro',
                                                    'error' => false,
                                                    'after' => $linkCategoria));
                
                echo $form->input('valor', array('error' => false));
                
                echo $form->input('datadabaixa', array('label' => 'Data da baixa',
                                                        'type' => 'text',
                                                        'error' => false,
                                                        'class' => 'dataField',
                                                        'default' => date('d-m-Y')
                                                    ));
                
                echo $form->input('observacoes', array('type' => 'textarea',
                                                       'label' => 'Observações',
                                                       'id' => 'Observacoes'));
            ?>
            </fieldset>
            <?php echo $form->end('Inserir');?>
            
        </div>

    </div>
    
    <?php echo $this->Html->script('forms'); ?>
    
    
    