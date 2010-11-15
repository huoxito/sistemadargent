
    <div class="usuarios form">
        
        <div id="contentHeader">
            <h1>
                <?php __('Perfil');?>
            </h1>
        </div>
        
        <div class="balancoBotoesWraper">
            
            <div class="balancoBotoes">
                
                <div class="headeraddlinks">
                    <?php echo $this->Html->link('VOLTAR AO PERFIL',
                                            array('controller' => '/',
                                                  'action' => 'perfil'),
                                            array('class' => 'btnaddcategoria')); ?>
                </div>

            </div>
            
        </div>
        
        <cake:nocache>
        <?php   echo $this->Session->flash(); ?>
        </cake:nocache>
        
        <div class="formWraper">
        
            <?php echo $form->create('Usuario', array('id' => 'form'));?>
            <fieldset>
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
        
    </div>
    