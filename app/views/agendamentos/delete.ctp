    

    <div class="formBox">
    
        <p class="confirmacao">Você realmente deseja excluir esse agendamento?</p>
        <p class="agendamentoInfoLinha">
            <span><?php echo $itens['Agendamento']['model']; ?></span>
            - R$ <?php echo $itens['Agendamento']['valor']; ?> reais com
            <span class="agendamentoCategoria">
            <?php echo $itens['Agendamento']['categoria']; ?>
            </span>
        </p>
        
        <?php
            echo $this->Form->create('Agendamento',array('default' => false));
            echo $this->Form->end(array('label' => 'Excluir',
                                  'onclick' => 'deletar('.$itens['Agendamento']['id'].');'));
        ?>
        
    </div>
    
    <script type="text/javascript">
        // <![CDATA[
            function deletar(id){
                $.ajax({
                    url: '<?php echo $html->url(array("controller" => "agendamentos","action" => "delete"));?>',
                    data: 'id=' + id,
                    beforeSend: function(){
                        $('.submit').append('<?= $this->Html->image('ajax-loader-p.gif'); ?>');
                    },
                    success: function(result){
                        
                        if( result == 'deleted' ){
                            var t=setTimeout("parent.$('#agend" + id + "').fadeOut(); parent.jQuery.fn.colorbox.close(); ",500);
                        }else{
                            $('.submit img').fadeOut('fast', function(){
                                $('.submit').append('<span class="ajax_error_response">Registro inválido.</span>')
                            });
                        }
                    }
                });
            }
        // ]]>
    </script>
    
    