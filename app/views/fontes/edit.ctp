    
    
    <div class="fontes box" id="box">  
    
    <?php echo $form->create('Fonte',array('default' => false));?>
        <fieldset>
            <legend><?php __('Editar Fonte');?></legend>
        <?php
            echo $form->input('nome');
        ?>
        </fieldset>
    <?php echo $form->end(array('label' => 'Salvar',
                                    'onclick' => 'editar('.$id.');',
                                    'style' => 'float: left;',
                                    'after' => ' <input type="submit" style="float: left;margin-left: 5px;" onclick="parent.jQuery.fn.colorbox.close();" value="Cancelar" />')); ?>
    </div>

    <script type="text/javascript">
        // <![CDATA[
        
        function editar(id){
            
            var nome   = $('#FonteNome').val();
            
            $.ajax({
                
                url: '<?php echo $html->url(array("controller" => "fontes","action" => "editResponse"));?>', 
                cache: false,
                type: 'GET',
                contentType: "application/x-www-form-urlencoded; charset=utf-8",
                data: ( {id : id, nome: nome} ),
                beforeSend: function(){
                    $('.submit img').remove();
                    $('.submit span').remove();
                     $('.submit').append('<img style="float: left; margin-left: 15px;" src="../../../<?php echo IMAGES_URL; ?>ajax-loader.gif" title="excluindo ... " alt="excluindo ... " />');
                },
                success: function(result){
                    
                    if(result == 'error'){
                        $('.submit img').fadeOut('fast', function(){
                                $('.submit').append('<span class="ajax_error_response">Ocorreu um erro. Recarregue a página e tente novamente</span>');
                            });
                    }else if(result == 'validacao'){
                        $('.submit img').fadeOut('fast', function(){
                                $('.submit').append('<span class="ajax_error_response">Preencha todos os campos obrigatórios corretamente</span>');
                            });
                    }else if(result == 'existe'){
                        $('.submit img').fadeOut('fast', function(){
                                $('.submit').append('<span class="ajax_error_response">Já há uma fonte cadastrada com esse nome.</span>');
                            });
                    }else {
                        parent.$('#nome-' + id).html(result);
                        var t=setTimeout("parent.jQuery.fn.colorbox.close()",500);
                    }
                }
            });
        
        }       
        // ]]>
    </script>