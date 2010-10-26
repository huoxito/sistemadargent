
    
    
    <?php   echo $form->create('Usuario', array('type' => 'file')); ?>
    
        <fieldset>
            <legend><?php __('Escolha uma nova imagem para seu perfil');?></legend>
        <?php
            echo $form->input('foto',
                              array('type'=>'file',
                                    'div' => array('class' => ''),
                                    'error' => array('wrap' => 'span', 'class' => 'error'),
                                    ));
            
        ?>
            <span class="observacao">OBS: imagem no formato jpg/jpeg com no máximo 2MG</span>
        </fieldset>
    
    <?php
            echo $form->end('Salvar');

    ?>
    <?php echo $this->element('sql_dump'); ?>
    