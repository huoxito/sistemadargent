    
    <?php   echo $this->Html->script('jquery.textareaCounter.plugin');  ?>
    <?php   echo $this->Html->css('jquery-ui-1.8rc3.custom');
            echo $this->Html->script('jquery.ui.core');
            echo $this->Html->script('ui.datepicker');  ?>
    <div class="gastos box" id="box">
    
    <?php echo $form->create('Gasto',array('default' => false));?>
        <fieldset>
            <legend><?php __('Editar Registro');?></legend>
        <?php
            echo $form->input('destino_id', array('empty' => 'Escolha um registro',
                                                'style' => 'margin-right: 10px;',
                                                'id' => 'categoria',
                                                'error' => false,
                                                'after' => '<a href="javascript:;" title="cadastrar destino" onclick="insereInput(\'data[Destino][nome]\');">Inserir novo destino</a>'));
            
            echo $form->input('valor', array('style' => 'width: 100px; height: 16px; padding: 7px;',
                                                'error' => false,
                                                'div' => array('style' => 'float: left; clear: none;')
                                                ));
            
            echo $form->input('datadabaixa', array('label' => 'Data da baixa',
                                                    'type' => 'text',
                                                    'error' => false,
                                                    'class' => 'dataField',
                                                    'default' => date('d-m-Y'),
                                                    'style' => 'width: 100px; height: 16px; padding: 7px;',
                                                    'div' => array('style' => 'float: left; clear: none;')
                                                    ));  
            
            echo $form->input('observacoes', array('type' => 'textarea',
                                                    'label' => 'Observações',
                                                    'style' => 'width: 428px; height: 80px;'));
            
        ?>
        </fieldset>
        <?php echo $form->end(array('label' => 'Salvar',
                                    'onclick' => 'editar('.$id.');',
                                    'style' => 'float: left;',
                                    'after' => ' <input type="submit" style="float: left;margin-left: 5px;" onclick="parent.jQuery.fn.colorbox.close();" value="Cancelar" />'));
        ?>
    </div>

    <script type="text/javascript">
        // <![CDATA[
        var options3 = {
						'maxCharacterSize': 200,
						'originalStyle': 'originalTextareaInfo',
						'warningStyle' : 'warningTextareaInfo',
						'warningNumber': 40,
						'displayFormat' : '#left / #max'
		};
        
        $('#GanhoObservacoes').textareaCount(options3, function(data){
            var result = 'Characters Input: ' + data.input + '<br />';
            result += 'Words Input: ' + data.words + '<br />';
            result += 'Left Characters: ' + data.left + '<br />';
            result += 'Characters Limitation: ' + data.max + '<br />';
            $('#textareaCallBack').html(result);
        });
        
        $('.dataField').datepicker({
                        dateFormat: 'dd-mm-yy',
                        dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'],
                        monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
                        maxDate: 'd-m-y'
                    });
        
        function insereInput(name){
            
            $('div.select select').fadeOut('fast',function(){
                    $('div.select a').remove();
                    $('div.select').append('<input type="text" maxlength="30" name="'+name+'" style="float: left;margin-right: 10px;width:250px;" />');
                    $('div.select').append('<a href="javascript:;" title="cadastrar fonte" onclick="insereSelect();" style="margin-top: 10px;display: block;float: left;">Selecionar um destino</a>');    
                });
            
        }
        
        function insereSelect(name){
            
            $('div.select input').fadeOut('fast',function(){
                $('div.select input').remove();
                $('div.select a').remove();
                $('div.select select').show();
                $('div.select').append('<a href="javascript:;" title="cadastrar destino" onclick="insereInput();">Cadastrar novo destino</a>');    
            });
        }
        
        function editar(id){
            
            var novacategoria   = $('#novacategoria').val();
            var categoria       = $('#categoria').val();
            var valor           = $('#GastoValor').val();
            var data            = $('#GastoDatadabaixa').val();
            var obs             = $('#GastoObservacoes').val();
            
            $.ajax({
                
                url: '<?php echo $html->url(array("controller" => "gastos","action" => "editResponse"));?>', 
                cache: false,
                type: 'GET',
                contentType: "application/x-www-form-urlencoded; charset=utf-8",
                data: ( {id : id, categoria: categoria, novacategoria: novacategoria, valor: valor, data: data, obs: obs} ),
                beforeSend: function(){
                    $('.submit img').remove();
                    $('.submit span').remove();
                     $('.submit').append('<img style="float: left; margin-left: 15px;" src="../../../<?php echo IMAGES_URL; ?>ajax-loader.gif" title="excluindo ... " alt="excluindo ... " />');
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
                    }else {
                        parent.$('#gasto-' + id).html(result);
                        var t=setTimeout("parent.jQuery.fn.colorbox.close()",500);
                    }
                }
            });
        
        
        }
        
        // ]]>
    </script>
