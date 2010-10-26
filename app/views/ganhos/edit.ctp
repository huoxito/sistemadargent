    
    <?php   echo $this->Html->script('jquery.textareaCounter.plugin');  ?>
    <?php   echo $this->Html->css('jquery-ui-1.8rc3.custom');
            echo $this->Html->script('jquery.ui.core');
            echo $this->Html->script('ui.datepicker');  ?>

    <div class="ganhos box" id="box">  
        
    <?php echo $form->create('Ganho',array('default' => false));?>
        <fieldset>
            <legend><?php __('Editar Resgistro');?></legend>
        
        <?php
            echo $form->input('fonte_id', array('empty' => 'Escolha um registro',
                                                'style' => 'margin-right: 10px;',
                                                'id' => 'categoria',
                                                'error' => false,
                                                'after' => '<a href="javascript:;" title="cadastrar fonte" onclick="insereInput(\'data[Fonte][nome]\');">Inserir nova fonte</a>')); 
        
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
                $('div.select').append('<input type="text" maxlength="30" name="'+name+'" style="float: left;margin-right: 10px;width:250px;" id="novacategoria" />');
                $('div.select').append('<a href="javascript:;" title="cadastrar fonte" onclick="insereSelect();" style="margin-top: 10px;display: block;float: left;">Selecionar uma fonte</a>');    
            });
            
        }
        
        function insereSelect(name){
            
            $('div.select input').fadeOut('fast',function(){
                $('div.select input').remove();
                $('div.select a').remove();
                $('div.select select').show();
                $('div.select').append('<a href="javascript:;" title="cadastrar fonte" onclick="insereInput();">Cadastrar nova fonte</a>');    
            });
        }
        
        function editar(id){
            
            var novacategoria   = $('#novacategoria').val();
            var categoria       = $('#categoria').val();
            var valor           = $('#GanhoValor').val();
            var data            = $('#GanhoDatadabaixa').val();
            var obs             = $('#GanhoObservacoes').val();
            
            $.ajax({
                
                url: '<?php echo $html->url(array("controller" => "ganhos","action" => "editResponse"));?>', 
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
                        parent.$('#ganho-' + id).html(result);
                        var t=setTimeout("parent.jQuery.fn.colorbox.close()",500);
                    }
                }
            });
        
        
        }
               
        // ]]>
    </script>