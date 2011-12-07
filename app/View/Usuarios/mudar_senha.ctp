
    <div class="usuarios form">
        
        <div id="contentHeader">
            <h1>
                <?php echo __('Perfil');?>
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
        
        <?php   echo $this->Session->flash(); ?>
        
        <div class="formWraper formBox">
        
            <?= $this->Form->create('Usuario',
                                array('inputDefaults' =>
                                    array('error' => array('wrap' => 'span')))); ?>
            <fieldset>
            <?php
                echo $this->Form->input('passwd_current',
                                array('type' => 'password',
                                      'label' => 'Senha Atual',
                                      'value' => ''));
                
                echo $this->Form->input('passwd',
                                array('label' => 'Nova senha',
                                      'value' => ''));
                    
                echo $this->Form->input('passwd_confirm',
                                array('type' => 'password',
                                      'value' => '',
                                      'label' => 'Confirmar nova senha'));
            ?>
            </fieldset>
            <?php echo $this->Form->end('Salvar');?>
        </div>
        
    </div>
    