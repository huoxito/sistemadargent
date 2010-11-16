    
    
    <?php  echo $this->Html->script('tiny_mce/tiny_mce.js');  ?>
    
    <div class="sugestos form">
    
        <div id="contentHeader">
            <h1>
                <?php __('Sugestões');?>
            </h1>
        </div>
        
        <div class="balancoBotoesWraper">
            <div class="balancoBotoes">
                <div class="headeraddlinks">
                    <?php echo $this->Html->link('VER SUGESTÕES',
                                    array('controller' => 'sugestoes',
                                          'action' => 'index'),
                                    array('class' => 'btnaddcategoria')); ?>
                </div>
            </div>
        </div>
        
        
        <cake:nocache>
        <?php   echo $this->Session->flash(); ?>
        </cake:nocache>
        
        <div class="formWraper">
        
            <?php echo $form->create(null);?>
            <fieldset>
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
        
    </div>
    
    <script type="text/javascript">
        // <![CDATA[
        tinyMCE.init({
            mode : "textareas",
            theme : "simple"
        });
        // ]]>
    </script>