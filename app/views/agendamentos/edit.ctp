    
    
    
    <?php   echo $this->Html->script('jquery.textareaCounter.plugin');  ?>
    <div class="agendamentos box" id="box">
        
        <p class="classname">As alterações feitas nesse agendamento serão válidas para os próximos <?php echo $itens['Agendamento']['numLancamentos']; ?> lançamentos.</p>
        <?php echo $form->create('Agendamento',array('default' => false));?>
            <fieldset>
                <legend>Editar Agendamento <?php echo $itens['Frequencia']['nome']; ?></legend>
            <?php

                if($itens['Agendamento']['tipo'] == 'Gasto')
                    echo $form->input('destino_id', array('empty' => 'Destino',
                                                          'id' => 'categoria',
                                                          'div' => array('style' => 'float: left;')));
                    
                if($itens['Agendamento']['tipo'] == 'Ganho')
                    echo $form->input('fonte_id', array('empty' => 'Fonte',
                                                        'id' => 'categoria',
                                                        'div' => array('style' => 'float: left; clear: none;')));
                    
                echo $form->input('valor', array(
                                                 'style' => 'width: 100px; height: 16px; padding: 7px;',
                                                 'div' => array('style' => 'float: left; clear: none;')));
                
                echo $form->input('Valormensal.diadomes', array('label' => 'Dia do vencimento',
                                                                'style' => 'width: 100px; height: 16px; padding: 7px;',
                                                                'div' => array('style' => 'float: left; clear: none;')));
            
                echo $form->input('observacoes', array('type' => 'textarea',
                                                    'label' => 'Observações',
                                                    'id' => 'Observacoes',
                                                    'style' => 'width: 428px; height: 80px;'));
           
                echo $form->end(array('label' => 'Salvar',
                                       'onclick' => 'editAgendamento('.$itens['Agendamento']['id'].');',
                                        'style' => 'float: left;',
                                        'after' => ' <input type="submit" style="float: left;margin-left: 5px;" onclick="parent.jQuery.fn.colorbox.close();" value="Cancelar" />'));
            ?>
            
    </div>
    
    <?php   echo $this->Html->script('forms');  ?>
    <script type="text/javascript">
        // <![CDATA[
        function editAgendamento(id){
            
            var categoria    = $('#categoria').val();
            var valor       = $('#AgendamentoValor').val();
            var vencimento  = $('#ValormensalDiadomes').val();
            var obs         = $('#Observacoes').val();
    
            $.ajax({
                
                url: '<?php echo $html->url(array("controller" => "agendamentos","action" => "editResponse"));?>?RandomNumber=' + Math.random(), 
                cache: false,
                type: 'GET',
                contentType: "application/x-www-form-urlencoded; charset=utf-8",
                data: ( {id : id, categoria: categoria, valor: valor, vencimento: vencimento, observacoes: obs} ),
                beforeSend: function(){
                    $('.submit img').remove();
                    $('.submit span').remove();
                    $('.submit').append('<img style="float: left; margin-left: 15px;" src="../../../<?php echo IMAGES_URL;?>ajax-loader.gif" title="excluindo ... " alt="excluindo ... " />');
                },
                success: function(result){
                    
                    if(result == 'error'){
                        $('.submit img').fadeOut('fast', function(){
                                $('.submit').append('<span class="ajax_error_response">Ocorreu um erro. Recarregue a página e tente novamente.</span>')
                            });
                    }else if(result == 'validacao'){
                        $('.submit img').fadeOut('fast', function(){
                                $('.submit').append('<span class="ajax_error_response">Preencha todos os campos corretamente.</span>');
                            });
                    }else{
                        
                        parent.$('#agend-' + id).html(result);
                        //var te=setTimeout("parent.$('#agend-'" + id +").html("+ result +");",5000);
                        var t=setTimeout("parent.jQuery.fn.colorbox.close()",100);
                    }
                        
                }
                
            });
        
        }
        
        // ]]>
    </script>