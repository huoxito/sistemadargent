        
    <?php   echo $this->Html->script('jquery.textareaCounter.plugin');  ?>
    <div class="gastos form">
        
    <?php   echo $this->element('gasto_menu'); ?>
    <?php   echo $this->Session->flash(); ?>
    <?php echo $form->create('Gasto');?>
        <fieldset>
            <legend><?php __('Despesas');?></legend>
        
        <?php    
            echo $form->input('destino_id', array('empty' => 'Escolha um registro',
                                                    'style' => 'margin-right: 10px;',
                                                    'error' => false,
                                                    //'div' => array('style' => 'clear: both;'),
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
    <?php echo $form->end('Salvar');?>
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
        
        $('#GastoObservacoes').textareaCount(options3, function(data){
            var result = 'Characters Input: ' + data.input + '<br />';
            result += 'Words Input: ' + data.words + '<br />';
            result += 'Left Characters: ' + data.left + '<br />';
            result += 'Characters Limitation: ' + data.max + '<br />';
            $('#textareaCallBack').html(result);
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
        // ]]>
    </script>