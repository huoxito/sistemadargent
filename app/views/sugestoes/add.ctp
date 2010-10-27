    
    
    <?php  echo $this->Html->script('tiny_mce/tiny_mce.js');  ?>
    <div class="sugestos form">
    <?php echo $form->create(null, array('action' => 'add'));?>
        <fieldset>
            <legend><?php __('Enviar sugestão');?></legend>
        <?php
            echo $form->input('titulo'); 
            echo $form->input('texto',
                              array('type' => 'textarea',
                                    'label' => 'Sugestão',
                                    'style' => 'width: 60%;'));
        ?>
        </fieldset>
    <?php echo $form->end('Submit');?>
    </div>
    
    <script type="text/javascript">
        // <![CDATA[
        tinyMCE.init({
            mode : "textareas",
            theme : "simple"
        });
        // ]]>
    </script>