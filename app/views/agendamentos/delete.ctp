    

    <div class="agendamentos box" id="box">
    
        <p class="confirmacao">Você realmente deseja excluir esse agendamento?</p>
        <span style="font-size: 20px; display: block; margin: 0 0 10px;">
            <span style="color: <?php echo $itens['color']; ?>;"><?php echo $itens['Agendamento']['tipo']; ?></span>
            - <?php echo $itens['Frequencia']['nome']; ?>
            - R$ <?php echo $itens['Agendamento']['valor']; ?>
            - <?php echo $itens['Agendamento']['categoria']; ?>
        </span>
        

        <?php
            echo $form->create('Agendamento',array('default' => false));
            
            echo $form->end(array('label' => 'Excluir',
                                       'onclick' => 'deletar('.$itens['Agendamento']['id'].');',
                                        'style' => 'float: left;',
                                        'div' => array('style' => "padding: 0;"),
                                        'after' => ' <input type="submit" style="float: left;margin-left: 5px;" onclick="parent.jQuery.fn.colorbox.close();" value="Cancelar" />'));
        ?>
        
        
    </div>
    
    <script type="text/javascript">
        // <![CDATA[
            function deletar(id){
                $.ajax({
                        url: '<?php echo $html->url(array("controller" => "agendamentos","action" => "delete"));?>',
                        cache: false,
                        type: 'GET',
                        data: 'id=' + id,
                        beforeSend: function(){
                            $('.submit').append('<img style="float: left; margin-left: 15px;" src="../../<?php echo IMAGES_URL;?>ajax-loader.gif" title="excluindo ... " alt="excluindo ... " />');
                        },
                        success: function(result){
                           
                            if( result == 'deleted' ){
                                var t=setTimeout("parent.$('#agend-" + id + "').fadeOut(); parent.jQuery.fn.colorbox.close(); ",500);
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
    
    