
    <div class="usuarios form">
        
        <h2 class="headers">
            <?php echo $this->Html->link('Perfil',
                            array('action' => 'perfil'),
                            array('class' => '')); ?>
        </h2>
        
        <?php   echo $this->Session->flash(); ?>
        
        <?php echo $form->create('Usuario', array('id' => 'form'));?>
            <fieldset>
                <legend><?php __('Mudança de senha');?></legend>
            <?php
            
                echo $form->input('passwd_current',
                                array('type' => 'password',
                                      'label' => 'Senha Atual',
                                      'value' => '',
                                      'error' => array('wrap' => 'span', 'class' => 'error')));
                
                echo $form->input('passwd',
                                array('label' => 'Nova senha',
                                      'value' => '',
                                      'error' => array('wrap' => 'span', 'class' => 'error')));
                    
                echo $form->input('passwd_confirm',
                                array('type' => 'password',
                                      'value' => '',
                                      'label' => 'Confirmar nova senha',
                                      'error' => array('wrap' => 'span', 'class' => 'error')));  
            
            
            ?>
            </fieldset>
        <?php echo $form->end('Salvar');?>
    </div>
    