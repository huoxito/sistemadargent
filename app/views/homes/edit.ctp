    
    
    <div class="ganhos formBox">  
        
        <?php echo $this->Form->create($_Model,array('default' => false));?>
        <span class="tipoAgendamentoLabel">
            <?= $this->data[$_Model]['label'] ?>
        </span>
        
        <input type="hidden" id="datadabaixa" value="<?= $this->data[$_Model]['datainicial'] ?>" />
        <div class="datepickerWraper">
            <span class="labelCalendario">
                Selecione a data da baixa
            </span>    
            <div id="datepicker"></div>
            <span class="dataAmigavel change">
                <?= $this->data[$_Model]['dataAmigavel']; ?>
            </span>
        </div>
        <div class="inputsRight">
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
            ?>
            <?= $this->Form->input('valor',
                                array('error' => false,
                                      'id' => 'valor',
                                      'div' => array('class' => 'inputBoxWraper'))); 
            ?>  
        
            <?= $this->Form->input('observacoes',
                                array('type' => 'textarea',
                                      'label' => 'Observações',
                                      'id' => 'Observacoes',
                                      'div' => array('class' => 'inputBoxWraper')));    ?>
        </div>
        <?php echo $this->Form->end(array('label' => 'Confirmar',
                                          'onclick' => 'editar('.$id.',\'editar\');',
                                          'style' => 'float: left;'));  ?>
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
                
                url: '<?php echo $this->Html->url(array("controller" => "homes","action" => "editResponse"));?>', 
                cache: false,
                type: 'GET',
                contentType: "application/x-www-form-urlencoded; charset=utf-8",
                data: ( {id : id, categoria: categoria, valor: valor, data: data, obs: obs, tipo: tipo, action: action } ),
                beforeSend: function(){
                    $('.submit img').remove();
                    $('.submit span').remove();
                    $('.submit').append('<?= $this->Html->image('ajax-loader-p.gif'); ?>');
                },
                success: function(result){
                    
                    if(result == 'error'){
                        $('.submit img').fadeOut('fast', function(){
                                $('.submit').append('<span class="ajax_error_response">Operação inválida</span>');
                            });
                    }else if(result == 'validacao'){
                        $('.submit img').fadeOut('fast', function(){
                                $('.submit').append('<span class="ajax_error_response">Preencha os campos corretamente</span>');
                            });
                    }else {
                        parent.$('#registro-' + tipo + '-' + id).html(result);
                        var t=setTimeout("parent.jQuery.fn.colorbox.close()",100);
                    }
                }
            });

        }        
        // ]]>
    </script>