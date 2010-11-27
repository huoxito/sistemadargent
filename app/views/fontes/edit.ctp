    
    
    <div class="fontes box" id="box">  
    
        <?php echo $this->Form->create('Fonte',array('default' => false));?>
        <?php echo $this->Form->input('nome'); ?>
        <?php echo $this->Form->end(array('label' => 'Salvar',
                                          'onclick' => 'editar('.$this->data['Fonte']['id'].');',
                                          'after' => ' <input type="submit" onclick="parent.jQuery.fn.colorbox.close();" value="Cancelar" />')); ?>
    </div>

    <script type="text/javascript">
        // <![CDATA[
        
        function editar(id){
            
            var nome   = $('#FonteNome').val();
            
            $.ajax({
                
                url: '<?php echo $this->Html->url(array("controller" => "fontes","action" => "editResponse"));?>', 
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
                                $('.submit').append('<span class="ajax_error_response">Registro inválido</span>');
                            });
                    }else if(result == 'validacao'){
                        $('.submit img').fadeOut('fast', function(){
                                $('.submit').append('<span class="ajax_error_response">Preencha o campo corretamente</span>');
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