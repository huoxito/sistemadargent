    
    
    <div class="agendamentos form">
        
    <?php   echo $this->element('agendamento_menu');    ?>
    
    <?php echo $form->create('Agendamento');?>
        
        <cake:nocache>
        <?php   echo $this->Session->flash(); ?>
        </cake:nocache>
        
        <fieldset>
            <legend><?php __('Período do agendamento');?></legend>
            
            <span style="font-size: 20px; display: block; margin: 0 0 10px;">
                <span style="color: <?php echo $itens['color']; ?>;"><?php echo $itens['Agendamento']['tipo']; ?></span>
                - <?php echo $itens['Frequencia']['nome']; ?>
                - R$ <?php echo $itens['Agendamento']['valor']; ?>
                - <?php echo $itens['Agendamento']['categoria']; ?>
            </span>
            
            <p>Agora você precisa informar o dia do mês e o número de lançamentos ( parcelas ). ( Preencha os campos apenas com números ) </p>
        <?php
                echo $form->input('Valormensal.agendamento_id',
                                        array('type' => 'hidden',
                                              'value' => $id));  
                                              
                echo $form->input('Valormensal.diadomes',
                                        array('label' => 'Dia do vencimento no mẽs',
                                              'error' => false));   ?>
        
        <?php
                echo $form->input('Valormensal.numerodemeses',
                                    array('label' => 'Número de lançamentos ( parcelas )'));  ?>
        
            <p class="">Você pode inserir no máximo 60 registros de uma vez.</p>
        
            <div class="input text required">
                <label>Selecione o mês do primeiro lançamento</label>
                <?php
                        echo $form->month(false, isset($this->data['month']) ? $this->data['month'] : date('m'),
                                                array(__('monthNames',true),
                                                        'empty' => false,
                                                        'label' => 'Selecione o mês do primeiro lançamento'));  ?>
            </div>
        
        </fieldset>
    <?php echo $form->end('Concluir Agendamento');?>
    </div>
