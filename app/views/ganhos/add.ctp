   
    <?php   echo $this->Html->script('jquery.textareaCounter.plugin');  ?>
    
    <div class="ganhos form">
        
        <div id="contentHeader">
            <?php   echo $this->element('ganho_menu'); ?>
        </div>
        
        <div class="balancoBotoesWraper">
            <div class="balancoBotoes">
                <p>Insira aqui somente o que você já realmente ganhou. Para programar um faturamento use a seção Agendamentos</p>
            </div>
        </div>
        
        <?php $linkCategoria = '<a href="javascript:;" class="btnadd" title="inserir fonte" onclick="insereInput();">INSERIR NOVA FONTE</a>'; ?>
        
        <cake:nocache>
        <?php   echo $this->Session->flash(); ?>
        </cake:nocache>
        
        <div class="formWraper">
                 
            <?php echo $form->create('Ganho');?>
            <fieldset>
            <?php
                echo $form->input('fonte_id', array('empty' => 'Escolha um registro',
                                                    'error' => false,
                                                    'after' => $linkCategoria));
                
                echo $form->input('valor', array('error' => false));
                
                echo $form->input('datadabaixa', array('label' => 'Data da baixa',
                                                        'type' => 'text',
                                                        'error' => false,
                                                        'class' => 'dataField',
                                                        'default' => date('d-m-Y')
                                                    ));
                
                echo $form->input('observacoes', array('type' => 'textarea',
                                                       'label' => 'Observações',
                                                       'id' => 'Observacoes'));
            ?>
            </fieldset>
            <?php echo $form->end('Inserir');?>
            
        </div>

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
        
        $('#Observacoes').textareaCount(options3, function(data){
            var result = 'Characters Input: ' + data.input + '<br />';
            result += 'Words Input: ' + data.words + '<br />';
            result += 'Left Characters: ' + data.left + '<br />';
            result += 'Characters Limitation: ' + data.max + '<br />';
            $('#textareaCallBack').html(result);
        });
        
        function insereInput(name){
            
            $('div.select select').fadeOut('fast',function(){
                    $('div.select a').remove();
                    $('div.select').append('<input type="text" maxlength="30" name="data[Fonte][nome]" />');
                    $('div.select').append('<a href="javascript:;" title="cadastrar fonte" class="btnadd" onclick="insereSelect();">SELECIONAR UMA FONTE</a>');    
            });
        }
        
        function insereSelectFontes(){
            
            $('div.select input').fadeOut('fast',function(){
                $('div.select input').remove();
                $('div.select a').remove();
                $('div.select select').show();
                $('div.select').append('<?php echo $linkCategoria; ?>');    
            });
        }
        
        // ]]>
    </script>
    