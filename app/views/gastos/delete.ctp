    

    <div class="formBox">
    
        <p class="confirmacao">Você realmente deseja excluir esse registro?</p>
        <p class="agendamentoInfoLinha">
            R$ <?php echo $itens['Gasto']['valor']; ?> reais com 
            <span class="agendamentoCategoria">
            <?php echo $itens['Destino']['nome']; ?>
            </span>
            em <?php echo $itens['Gasto']['datadabaixa']; ?>
        </p>
        <?php
            echo $this->Form->create('Gasto',array('default' => false));
            echo $this->Form->end(array('label' => 'Excluir',
                                        'onclick' => 'excluir('.$itens['Gasto']['id'].');')); ?>
        
    </div>
    
    <script type="text/javascript">
        // <![CDATA[
        
            function excluir(id){
                $.ajax({
                    url: '<?php echo $html->url(array("controller" => "gastos","action" => "delete"));?>',
                    data: 'id=' + id,
                    beforeSend: function(){
                        $('.submit').append('<?= $this->Html->image('ajax-loader-p.gif'); ?>');
                    },
                    success: function(result){
                    
                        if( result == 'deleted' ){                                
                            var t=setTimeout("parent.$('#gasto-" + id + "').fadeOut(); parent.jQuery.fn.colorbox.close(); ",500);
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
    
    