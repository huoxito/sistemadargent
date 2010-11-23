    
    <?php   echo $this->Html->script('jquery.textareaCounter.plugin');  ?>
    
    <div class="agendamentos formBox">
        
        <span class="labelBoxForm">
            AGENDAMENTO DE <?= $label ?>s
        </span>
        <?php
            
            echo $this->Form->create('Agendamento',array('default' => false));
            
            if($this->data['Agendamento']['model'] == 'Gasto')
                echo $this->Form->input('destino_id',
                                    array('empty' => 'Destino',
                                          'id' => 'categoria'));
                
            if($this->data['Agendamento']['model'] == 'Ganho')
                echo $this->Form->input('fonte_id',
                                    array('empty' => 'Fonte',
                                          'id' => 'categoria'));
                
            echo $this->Form->input('valor');
            echo $this->Form->input('observacoes', array('type' => 'textarea',
                                                'label' => 'Observações',
                                                'id' => 'Observacoes'));
       
            echo $this->Form->end(array('label' => 'Salvar',
                                        'onclick' => 'editAgendamento('.$this->data['Agendamento']['id'].');',
                                        'after' => ' <input type="submit" onclick="parent.jQuery.fn.colorbox.close();" value="Cancelar" />'));
        
        ?>
            
    </div>
    
    <?php   echo $this->Html->script('forms');  ?>
    
    <script type="text/javascript">
        // <![CDATA[
        function editAgendamento(id){
            
            var categoria   = $('#categoria').val();
            var valor       = $('#AgendamentoValor').val();
            var obs         = $('#Observacoes').val();
    
            $.ajax({
                
                url: '<?php echo $html->url(array("controller" => "agendamentos","action" => "editResponse"));?>', 
                cache: false,
                type: 'GET',
                contentType: "application/x-www-form-urlencoded; charset=utf-8",
                data: ( {id : id, categoria: categoria, valor: valor, observacoes: obs} ),
                beforeSend: function(){
                    $('.submit img').remove();
                    $('.submit span').remove();
                    $('.submit').append('<?= $this->Html->image('ajax-loader-p.gif'); ?>');
                },
                success: function(result){
                    
                    if(result == 'error'){
                        $('.submit img').fadeOut('fast', function(){
                                $('.submit').append('<span class="ajax_error_response">Registro inválido</span>')
                            });
                    }else if(result == 'validacao'){
                        $('.submit img').fadeOut('fast', function(){
                                $('.submit').append('<span class="ajax_error_response">Preencha os campos corretamente.</span>');
                            });
                    }else{
                        
                        var json = $.parseJSON(result);
                        $.each(json, function(i,item) {
                            parent.$('.valorAgenda'+id).html(item.valor);
                            parent.$('.categoria'+id).html(item.categoria);
                            parent.$('.Observacoes'+id).html(item.observacoes);
                        });
                        
                        var t=setTimeout("parent.jQuery.fn.colorbox.close()",100);
                    }   
                }
                
            });
        
        }
        
        // ]]>
    </script>