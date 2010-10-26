    

    <div class="box" id="box">
    
        <p class="confirmacao">Você realmente deseja excluir esse registro?</p>
        <span style="font-size: 20px; display: block; margin: 0 0 20px;">
            <?php echo $_Model; ?> -  
            R$ <?php echo $itens[$_Model]['valor']; ?>
            « <?php echo $itens[$_Categoria]['nome']; ?>
        </span>

        <?php
            echo $form->create($_Model,array('default' => false));
            echo $form->end(array('label' => 'Excluir',
                                       'onclick' => 'excluir(\''.$_Model.'\','.$itens[$_Model]['id'].');',
                                        'style' => 'float: left;',
                                        'div' => array('style' => "padding: 0;"),
                                        'after' => ' <input type="submit" style="float: left;margin-left: 5px;" onclick="parent.jQuery.fn.colorbox.close();" value="Cancelar" />'));
        ?>
        
    </div>
    
    <script type="text/javascript">
        // <![CDATA[
        
            function excluir(tipo, id){
                $.ajax({
                        url: '<?php echo $html->url(array("controller" => "homes","action" => "delete"));?>',
                        cache: false,
                        type: 'GET',
                        data: ({ tipo: tipo, id: id }),
                        beforeSend: function(){
                            $('.submit').append('<img style="float: left; margin-left: 15px;" src="<?php $html->url('/');?>img/ajax-loader.gif" title="excluindo ... " alt="excluindo ... " />');
                        },
                        success: function(result){
                        
                            if( result == 'deleted' ){                                
                                var t=setTimeout("parent.$('#registro-" + tipo + "-" + id + "').fadeOut(); parent.jQuery.fn.colorbox.close(); ",500);
                            }else{
                                $('.submit img').fadeOut('fast', function(){
                                    $('.submit').append('<span class="ajax_error_response">Ocorreu um erro. Recarregue a página e tente novamente.</span>')
                                });
                            }
                        }
                });
            }
        
        // ]]>
    </script>
    
    