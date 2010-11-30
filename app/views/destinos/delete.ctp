    

    <div class="agendamentos formBox">
    
        <p class="confirmacao">Você realmente deseja excluir essa categoria <b><?php echo $itens['Destino']['nome']; ?></b>  ?</p>

        <?php
            echo $this->Form->create('Destino',array('default' => false));
            echo $this->Form->end(array('label' => 'Excluir',
                                  'onclick' => 'excluir('.$itens['Destino']['id'].');'));
        ?>
        
    </div>
    
    <script type="text/javascript">
        // <![CDATA[
        
            function excluir(id){
                $.ajax({
                    url: '<?php echo $this->Html->url(array("controller" => "destinos","action" => "delete"));?>',
                    data: 'id=' + id,
                    beforeSend: function(){
                        $('.submit').append('<?= $this->Html->image('ajax-loader-p.gif'); ?>');
                    },
                    success: function(result){
                    
                        if( result == 'deleted' ){                                
                            var t=setTimeout("parent.$('#destino-" + id + "').fadeOut(); parent.jQuery.fn.colorbox.close(); ",500);
                        }else{
                            $('.submit img').fadeOut('fast', function(){
                                $('.submit').append('<span class="ajax_error_response">Registro inválido</span>');
                            });
                        }
                    }
                });
            }
        
        // ]]>
    </script>
    
    