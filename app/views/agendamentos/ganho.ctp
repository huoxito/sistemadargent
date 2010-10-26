    
    <?php   echo $this->Html->script('jquery.textareaCounter.plugin');  ?>
    <div class="agendamentos form">
        
    <?php   echo $this->element('agendamento_menu');    ?>
    <cake:nocache>
    <?php   echo $this->Session->flash(); ?>
    </cake:nocache>
    <?php echo $form->create('Agendamento',array('action' => 'tipo/Ganho'));?>
        <fieldset>
            <legend><?php __('Faturamento');?></legend>
        <?php
            echo $form->input('fonte_id', array('empty' => 'Escolha um registro',
                                                'style' => 'margin-right: 10px;',
                                                'error' => false,
                                                'class' => 'select_categoria',
                                                'div' => array('id' => 'select_categoria'),
                                                'after' => '<a href="javascript:;" title="cadastrar fonte" onclick="insereInput(\'data[Fonte][nome]\');">Inserir nova categoria</a>'));
            
            echo $form->input('frequencia_id', array('empty' => 'Frequência',
                                                    'error' => false,
                                                    'div' => array('style' => 'float: left; clear: none;')
                                                ));
            
            echo $form->input('valor', array('style' => 'width: 100px; height: 16px; padding: 7px;',
                                                'error' => false,
                                                'div' => array('style' => 'float: left; clear: none;')
                                                ));
            
            echo $form->input('observacoes', array('type' => 'textarea',
                                                    'label' => 'Observações',
                                                    'id' => 'Observacoes',
                                                    'style' => 'width: 428px; height: 80px;'));
        ?>
        </fieldset>
    <?php echo $form->end('Continuar');?>
    </div>
    
    <?php   echo $this->Html->script('forms');  ?>
