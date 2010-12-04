    
    <?php $linkCategoria = '<a href="javascript:;" class="btnadd" title="inserir fonte" onclick="insereInputFontes();">INSERIR NOVA FONTE</a>'; ?>
    
    <div class="ganhos formBox">  
        
        <?php echo $this->Form->create('Ganho',array('default' => false));?>    
        
        <?php echo $this->Form->input('fonte_id',
                                array('empty' => 'Escolha um registro',
                                      'id' => 'categoria',
                                      'after' => $linkCategoria,
                                      'class' => 'select_categoria')); ?>
        
        <?php echo $this->Form->input('valor'); ?>
        
        <?php echo $this->Form->input('datadabaixa',
                                array('label' => 'Data da baixa',
                                      'type' => 'text',
                                      'class' => 'dataField',
                                      'default' => date('d-m-Y')));  ?>
        
        <?php echo $this->Form->input('observacoes',
                                array('type' => 'textarea',
                                      'label' => 'Observações',
                                      'id' => 'Observacoes')); ?>
        
        <?php echo $this->Form->end(array('label' => 'Salvar',
                                          'onclick' => 'editar('.$id.');',
                                          'after' => ' <input type="submit" onclick="parent.jQuery.fn.colorbox.close();" value="Cancelar" />')); ?>
                                    
    </div>
    
    <?php echo $this->Html->script('forms'); ?>
    
    <script type="text/javascript">
        // <![CDATA[
                
        function editar(id){
            
            var novacategoria   = $('#novacategoria').val();
            var categoria       = $('#categoria').val();
            var valor           = $('#GanhoValor').val();
            var data            = $('#GanhoDatadabaixa').val();
            var obs             = $('#Observacoes').val();
            
            $.ajax({
                
                url: '<?php echo $this->Html->url(array("controller" => "ganhos","action" => "editResponse"));?>', 
                data: ( {id : id, categoria: categoria, novacategoria: novacategoria, valor: valor, data: data, obs: obs} ),
                beforeSend: function(){
                    $('.submit span').detach();
                    $('.submit').append('<?= $this->Html->image('ajax-loader-p.gif'); ?>');
                },
                success: function(result){
                    
                    $('.submit img').detach();
                    if(result == 'error'){
                        $('.submit').append('<span class="ajax_error_response">Registro inválido</span>');
                    }else if(result == 'validacao'){
                        $('.submit').append('<span class="ajax_error_response">Preencha todos os campos obrigatórios corretamente</span>');
                    }else {
                        parent.$('#ganho-' + id).html(result);
                        var t=setTimeout("parent.jQuery.fn.colorbox.close()",100);
                    }
                }
            });
        
        }
               
        // ]]>
    </script>