    
    
    <div class="ganhos formBox">  
        
        <?php echo $this->Form->create($_Model,
                            array('default' => false,
                                  'inputDefaults' =>
                                    array('div' => array('class' => 'inputBoxWraper'))));?>
        <span class="tipoAgendamentoLabel">
            <?= $this->request->data[$_Model]['label']; ?>
        </span>
        
        <input type="hidden" id="datadabaixa" value="<?= $this->request->data[$_Model]['datainicial'] ?>" />
        <div class="datepickerWraper">
            <span class="labelCalendario">
                Selecione a data da baixa
            </span>    
            <span class="dataAmigavel change">
                <?= $this->request->data[$_Model]['dataAmigavel']; ?>
            </span>

            <div id="datepicker"></div>
        </div>
        <div class="inputsRight">
            <?php
                if( $_Model == 'Ganho' ){
                    echo $this->Form->input('fonte_id',
                                        array('empty' => 'Escolha um registro',
                                              'id' => 'categoria')); 
                }else{
                    echo $this->Form->input('destino_id',
                                        array('empty' => 'Escolha um registro',
                                              'id' => 'categoria')); 
                }
            ?>
            
            <?= $this->Form->input('conta_id',
                                array('id' => 'conta')); ?> 
            <?= $this->Form->input('valor',
                                array('id' => 'valor')); ?>  
        
            <?= $this->Form->input('observacoes',
                                array('type' => 'textarea',
                                      'label' => 'Observações',
                                      'id' => 'Observacoes'));    ?>
        </div>
        <div class="submit">
            
            <input type="hidden" id="id" value="<?= $id ?>">
            <input type="hidden" id="tipo" value="<?= $_Model ?>">
            
            <input type="submit" id="submitAjax" value="Confirmar">
            <input type="submit" id="fecharColorbox" value="Cancelar" />
            
            <span class="ajax_error_response"></span>
            
        </div>
        </form>
    </div>
    
    
    <?php   echo $this->Html->script('forms');  ?>
    
    <? list($dia,$mes,$ano) = explode('-',$this->request->data[$_Model]['datainicial']); ?>
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
        
        $('#fecharColorbox').click(function(){
            parent.jQuery.fn.colorbox.close();
        });

        $("#submitAjax").click(function(){
            
            var categoria       = $('#categoria').val();
            var conta           = $('#conta').val();
            var valor           = $('#valor').val();
            var data            = $('#datadabaixa').val();
            var obs             = $('#Observacoes').val();
            var tipo            = $('#tipo').val();;      
            var id              = $('#id').val();
            
            $.ajax({
                
                url: '<?php echo $this->Html->url(array("controller" => "homes","action" => "editResponse"));?>',
                data: ({    id: id, categoria: categoria, valor: valor,
                            data: data, obs: obs, tipo: tipo, conta: conta }),
                beforeSend: function(){
                    $('.submit img').remove();
                    $('.submit span').html('');
                    $('.submit').append('<?= $this->Html->image('ajax-loader-p.gif'); ?>');
                },
                success: function(result){
                    
                    if(result == 'error'){
                        $('.submit img').fadeOut('fast', function(){
                                $('.ajax_error_response').html('Operação inválida');
                            });
                    }else if(result == 'validacao'){
                        $('.submit img').fadeOut('fast', function(){
                                $('.ajax_error_response').html('Preencha os campos corretamente');
                            });
                    }else {
                        parent.$('#registro-' + tipo + '-' + id).html(result);
                        var t=setTimeout("parent.jQuery.fn.colorbox.close()",100);
                    }
                }
            });

        });        
        // ]]>
    </script>
