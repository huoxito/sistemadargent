    
    
    <div class="ganhos formBox">  
        
        <?php echo $this->Form->create($_Model,array('default' => false));?>
        <span class="tipoAgendamentoLabel">
            <?= $this->data[$_Model]['label'] ?>
        </span>
        
        <input type="hidden" id="datadabaixa" value="<?= $this->data[$_Model]['datainicial'] ?>" />
        <div id="datepicker">
            <span class="labelCalendario">Selecione a data da baixa</span>    
        </div>
        <span id="altDate"></span>
        
        <?php
            if( $_Model == 'Ganho' ){
                echo $this->Form->input('fonte_id',
                                    array('empty' => 'Escolha um registro',
                                          'id' => 'categoria',
                                          'div' => array('class' => 'inputBoxWraper'))); 
            }else{
                echo $this->Form->input('destino_id',
                                    array('empty' => 'Escolha um registro',
                                          'id' => 'categoria',
                                          'div' => array('class' => 'inputBoxWraper'))); 
            }
        
            echo $this->Form->input('valor',
                                    array('error' => false,
                                          'id' => 'valor',
                                          'div' => array('class' => 'inputBoxWraper'))); 
        ?>
        
        <?php
            echo $this->Form->input('observacoes',
                                    array('type' => 'textarea',
                                          'label' => 'Observações',
                                          'id' => 'Observacoes',
                                          'div' => array('class' => 'inputBoxWraper'))); 
        ?>
        <?php echo $this->Form->end(array('label' => 'Salvar',
                                          'onclick' => 'editar('.$id.',\'editar\');',
                                          'style' => 'float: left;'));
        ?>
    </div>
    
    
    <?php   echo $this->Html->script('forms');  ?>
    
    <? list($dia,$mes,$ano) = explode('-',$this->data[$_Model]['datainicial']); ?>
    <script type="text/javascript">
        // <![CDATA[
        $(document).ready(function () {
            $('#datepicker').datepicker({
                        dateFormat: 'D, d MM, yy',
                        defaultDate: new Date(<?=$ano?>,<?=$mes-1?>,<?=$dia?>),
                        maxDate: 'dd-mm-yy',
                        altField: '#datadabaixa',
                        altFormat: 'dd-mm-yy',
                        beforeShow: function(input, inst) {
                            $('#altDate').html(maxDate);
                        },
                        onSelect: function(dateText, inst){
                            $('.change').html(dateText);
                        }
            });
        });
        
        function editar(id,action){
            
            var categoria       = $('#categoria').val();
            var valor           = $('#valor').val();
            var data            = $('#datadabaixa').val();
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