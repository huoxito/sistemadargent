    
    <?php   echo $this->Html->script('jquery.textareaCounter.plugin');  ?>
    <div class="agendamentos form">
        
    <?php   echo $this->element('agendamento_menu');    ?>
    
    <?php echo $form->create('Agendamento',array('action' => 'tipo/Gasto'));?>
        <fieldset>
            <legend><?php __('Despesas');?></legend>
            
        <?php
            echo $form->input('destino_id', array('empty' => 'Escolha um registro',
                                                    'style' => 'margin-right: 10px;',
                                                    'error' => false,
                                                    'class' => 'select_categoria',
                                                    'div' => array('id' => 'select_categoria'),
                                                    'after' => '<a href="javascript:;" title="cadastrar destino" onclick="insereInput(\'data[Destino][nome]\');">Inserir nova categoria</a>'));
            
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
