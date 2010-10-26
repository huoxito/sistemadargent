    

    <div class="agendamentos box" id="box">
    
        <p class="confirmacao">Você realmente deseja excluir essa categoria >> <b><?php echo $itens['Destino']['nome']; ?></b>  ?</p>
        <span style="font-size: 12px; display: block; margin: 0 0 20px; color:red; ">
            Ao excluir essa categoria você também removerá todos os dados no sistema relacionados a ela ( despesas e agendamentos ). Essa ação não poderá ser revertida.
        </span>

        <?php
            echo $form->create('Destino',array('default' => false));
            echo $form->end(array('label' => 'Excluir',
                                       'onclick' => 'excluir('.$itens['Destino']['id'].');',
                                        'style' => 'float: left;',
                                        'div' => array('style' => "padding: 0;"),
                                        'after' => ' <input type="submit" style="float: left;margin-left: 5px;" onclick="parent.jQuery.fn.colorbox.close();" value="Cancelar" />'));
        ?>
        
    </div>
    
    <script type="text/javascript">
        // <![CDATA[
        
            function excluir(id){
                $.ajax({
                        url: '<?php echo $html->url(array("controller" => "destinos","action" => "delete"));?>',
                        cache: false,
                        type: 'GET',
                        data: 'id=' + id,
                        beforeSend: function(){
                            $('.submit').append('<img style="float: left; margin-left: 15px;" src="../../<?php echo IMAGES_URL;?>ajax-loader.gif" title="excluindo ... " alt="excluindo ... " />');
                        },
                        success: function(result){
                        
                            if( result == 'deleted' ){                                
                                var t=setTimeout("parent.$('#destino-" + id + "').fadeOut(); parent.jQuery.fn.colorbox.close(); ",500);
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
    
    