   
    <?php   echo $this->Html->script('jquery.textareaCounter.plugin');  ?>
    <div class="ganhos form">
        
    <?php   echo $this->element('ganho_menu'); ?>
    
    <cake:nocache>
    <?php   echo $this->Session->flash(); ?>
    </cake:nocache>
    
    <?php echo $form->create('Ganho');?>
        
        <fieldset>
            <legend><?php __('Faturamentos');?></legend>
        <?php
            echo $form->input('fonte_id', array('empty' => 'Escolha um registro',
                                                'style' => 'margin-right: 10px;',
                                                'error' => false,
                                                //'div' => array('style' => 'clear: both;'),
                                                'after' => '<a href="javascript:;" title="cadastrar fonte" onclick="insereInput(\'data[Fonte][nome]\');">Inserir nova fonte</a>')); 
        
            echo $form->input('valor', array('style' => 'width: 100px; height: 16px; padding: 7px;',
                                                'error' => false,
                                                'div' => array('style' => 'float: left; clear: none;')
                                                ));
            
            echo $form->input('datadabaixa', array('label' => 'Data de entrada',
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
        
        $('#GanhoObservacoes').textareaCount(options3, function(data){
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
        
        // ]]>
    </script>
    