    <div class="destinos form">
        
        <?php   echo $this->element('destino_menu'); ?>            
        <?php   echo $this->Session->flash(); ?>
        <?php echo $form->create('Destino');?>
            <fieldset>
                <legend><?php __('Adicionar Destino');?></legend>
            <?php
                echo $form->input('nome');
            ?>
            </fieldset>
        <?php echo $form->end('Salvar');?>
    </div>

