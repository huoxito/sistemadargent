    
    <?php $linkCancelar = '<input type="submit" onclick="parent.jQuery.fn.colorbox.close();" value="Cancelar" />'; ?>
    
    <div class="formBox">
    
        <p class="confirmacao">Você realmente deseja excluir esse registro?</p>
        <p class="agendamentoInfoLinha">
            <?php echo $_Model; ?> -  
            R$ <?php echo $itens[$_Model]['valor']; ?> reais com
            <span class="agendamentoCategoria">
            <?php echo $itens[$_Categoria]['nome']; ?>
            </span>
        </p>

        <?php echo $this->Form->create($_Model,array('default' => false));    ?>
        <?php echo $this->Form->end(array('label' => 'Excluir',
                                    'onclick' => 'excluir(\''.$_Model.'\','.$itens[$_Model]['id'].');',
                                    'after' => $linkCancelar)); ?>
        
    </div>
    
    <script type="text/javascript">
        // <![CDATA[
        
            function excluir(tipo, id){
                $.ajax({
                    url: '<?php echo $this->Html->url(array("controller" => "homes","action" => "delete"));?>',
                    data: ({ tipo: tipo, id: id }),
                    beforeSend: function(){
                        $('.submit').append('<?= $this->Html->image('ajax-loader-p.gif'); ?>');
                    },
                    success: function(result){
                    
                        if( result == 'deleted' ){                                
                            var t=setTimeout("parent.$('#registro-" + tipo + "-" + id + "').fadeOut(); parent.jQuery.fn.colorbox.close(); ",500);
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
    
    