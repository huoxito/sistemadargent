    
    
    <div class="destinos formBox">  
        
        <?php echo $this->Form->create('Destino',array('default' => false));?>
        <?php echo $this->Form->input('nome'); ?>
        <?php echo $this->Form->end(array('label' => 'Salvar',
                                          'onclick' => 'editar('.$this->data['Destino']['id'].');')); ?>
        
    </div>
    
    <?= $this->Html->script('forms'); ?>
    <script type="text/javascript">
        
        function editar(id){
            
            var nome   = $('#DestinoNome').val();
            $.ajax({
                
                url: '<?php echo $this->Html->url(array("controller" => "destinos","action" => "editResponse"));?>',
                data: ({ Destino: { id: id, nome: nome} }),
                beforeSend: function(){
                    $('.submit span').detach();
                    $('.submit').append('<?= $this->Html->image('ajax-loader-p.gif'); ?>');
                },
                success: function(result){
                    
                    $('.submit img').detach();
                    if(result == 'error'){
                        $('.submit').append('<span class="ajax_error_response">Registro inválido</span>');
                    }else if(result == 'validacao'){
                        $('.submit').append('<span class="ajax_error_response">Preencha o campo corretamente</span>');
                    }else if(result == 'existe'){
                        $('.submit').append('<span class="ajax_error_response">Já há um destino cadastrado com esse nome</span>');
                    }else {
                        parent.$('#nome-' + id).html(result);
                        var t=setTimeout("parent.jQuery.fn.colorbox.close()",100);
                    }
                }
            });
        
        }
        
    </script>

