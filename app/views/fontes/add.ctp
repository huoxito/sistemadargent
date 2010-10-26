
    <div class="fontes form">
    
    <?php   echo $this->element('fonte_menu'); ?>
    
    <?php   echo $this->Session->flash(); ?>
    
    
    
    <?php echo $form->create('Fonte');?>
        <fieldset>
            <legend><?php __('Cadastrar Fonte');?></legend>
        <?php
            echo $form->input('nome',array('error' => false));
        ?>
        </fieldset>
    <?php echo $form->end('Salvar');?>
    </div>

