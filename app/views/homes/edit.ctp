    
    <?php   echo $this->Html->script('jquery.textareaCounter.plugin');  ?>
    <?php   echo $this->Html->css('jquery-ui-1.8rc3.custom');
            echo $this->Html->script('jquery.ui.core');
            echo $this->Html->script('ui.datepicker');  ?>

    <div class="ganhos box" id="box">  
        
    <?php echo $form->create($_Model,array('default' => false));?>
        <fieldset>
            <legend><?php __('Editar Resgistro');?></legend>
        
        <?php
            if( $_Model == 'Ganho' ){
                
                
                echo $form->input('fonte_id', array('empty' => 'Escolha um registro',
                                                    'style' => 'margin-right: 10px;',
                                                    'id' => 'categoria',
                                                    'error' => false,
                                                    )); 
            }else{
                
                echo $form->input('destino_id', array('empty' => 'Escolha um registro',
                                                    'style' => 'margin-right: 10px;',
                                                    'id' => 'categoria',
                                                    'error' => false,
                                                    )); 
            }
            
            echo $form->input('valor', array('style' => 'width: 100px; height: 16px; padding: 7px;',
                                                'error' => false,
                                                'id' => 'valor',
                                                'div' => array('style' => 'float: left; clear: none;')
                                                ));
        
            echo $form->input('datadevencimento', array('label' => 'Data',
                                                    'type' => 'text',
                                                    'id' => 'datadevencimento',
                                                    'error' => false,
                                                    'class' => 'dataField',
                                                    'default' => date('d-m-Y'),
                                                    'style' => 'width: 100px; height: 16px; padding: 7px;',
                                                    'div' => array('style' => 'float: left; clear: none;')
                                                    ));  
        
            echo $form->input('observacoes', array('type' => 'textarea',
                                                    'label' => 'Observações',
                                                    'id' => 'Observacoes',
                                                    'style' => 'width: 428px; height: 80px;'));
        ?>
        </fieldset>
        <?php echo $form->end(array('label' => 'Salvar',
                                    'onclick' => 'editar('.$id.',\'editar\');',
                                    'style' => 'float: left;',
                                    'after' => ' <input type="submit" style="float: left;margin-left: 5px;" onclick="parent.jQuery.fn.colorbox.close();" value="Cancelar" />',
                                    'before' => ' <input type="submit" style="float: left;margin-right: 5px;" onclick="editar('.$id.',\'confirmar\');" value="Confirmar" />'));
        ?>
    </div>
    
    
    <?php   echo $this->Html->script('forms');  ?>
    <script type="text/javascript">
        // <![CDATA[
        
        $('.dataField').datepicker({
                        dateFormat: 'dd-mm-yy',
                        dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'],
                        monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro']
                    });
        
        function editar(id,action){
            
            var categoria       = $('#categoria').val();
            var valor           = $('#valor').val();
            var data            = $('#datadevencimento').val();
            var obs             = $('#Observacoes').val();
            var tipo            = '<?php echo $_Model;  ?>';      
            
            $.ajax({
                
                url: '<?php echo $html->url(array("controller" => "homes","action" => "editResponse"));?>', 
                cache: false,
                type: 'GET',
                contentType: "application/x-www-form-urlencoded; charset=utf-8",
                data: ( {id : id, categoria: categoria, valor: valor, data: data, obs: obs, tipo: tipo, action: action } ),
                beforeSend: function(){
                    $('.submit img').remove();
                    $('.submit span').remove();
                     $('.submit').append('<img style="float: left; margin-left: 15px;" src="<?php echo $html->url('/'); ?>img/ajax-loader.gif" title="enviando ... " alt="enviando ... " />');
                },
                success: function(result){
                    
                    if(result == 'error'){
                        $('.submit img').fadeOut('fast', function(){
                                $('.submit').append('<span class="ajax_error_response">Ocorreu um erro. Recarregue a página e tente novamente</span>');
                            });
                    }else if(result == 'validacao'){
                        $('.submit img').fadeOut('fast', function(){
                                $('.submit').append('<span class="ajax_error_response">Preencha todos os campos obrigatórios corretamente</span>');
                            });
                    }else if(result == 'data'){
                        $('.submit img').fadeOut('fast', function(){
                                $('.submit').append('<span class="ajax_error_response">Para confirmar a data deve ser menor ou igual que a de hoje</span>');
                            });
                    }else {
                        //$('#box').after(result);
                        parent.$('#registro-' + tipo + '-' + id).html(result);
                        var t=setTimeout("parent.jQuery.fn.colorbox.close()",500);
                    }
                }
            });

        }        
        // ]]>
    </script>