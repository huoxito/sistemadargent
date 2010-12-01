    <?php //echo $this->element('sql_dump'); ?>    

    <div class="agendamentos formBox">
    
        <span class="confirmacao">Você realmente deseja excluir essa categoria <b><?php echo $itens['Fonte']['nome']; ?></b>  ?</span>
        <?php
            echo $this->Form->create('Fonte',array('default' => false));
            echo $this->Form->end(array('label' => 'Excluir',
                                       'onclick' => 'excluir('.$itens['Fonte']['id'].');',
                                        'style' => 'float: left;'));
        ?>
        
    </div>
    
    <?= $this->Html->script('forms'); ?>
    
    <script type="text/javascript">
        // <![CDATA[
        
            function excluir(id){
                $.ajax({
                        url: '<?php echo $this->Html->url(array("controller" => "fontes","action" => "delete"));?>',
                        data: 'id=' + id,
                        beforeSend: function(){
                            $('.submit').append('<?= $this->Html->image('ajax-loader-p.gif'); ?>');
                        },
                        success: function(result){
                        
                            if( result == 'deleted' ){                                
                                var t=setTimeout("parent.$('#fonte-" + id + "').fadeOut(); parent.jQuery.fn.colorbox.close(); ",500);
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
    
    