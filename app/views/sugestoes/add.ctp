    
    
    <?php  echo $this->Html->script('tiny_mce/tiny_mce.js');  ?>
    
    <div class="sugestos form">
    
    <cake:nocache>
    <?php   echo $this->Session->flash(); ?>
    </cake:nocache>
    
    <?php echo $form->create(null);?>
        <fieldset>
            <legend><?php __('Enviar sugestão');?></legend>
        <?php
            echo $form->input('titulo',
                              array('error' => false)); 
            echo $form->input('texto',
                              array('type' => 'textarea',
                                    'label' => 'Sugestão',
                                    'style' => 'width: 60%;',
                                    'error' => false));
        ?> 
        </fieldset>
    <?php echo $form->end('Enviar');?>
    
    </div>
    
    <script type="text/javascript">
        // <![CDATA[
        tinyMCE.init({
            mode : "textareas",
            theme : "simple"
        });
        // ]]>
    </script>