
    <div class="agendamentos box" id="colorboxContent">
        
        <div id="datepicker"></div>
        
        <div class="confirmarBox">
            <span class="tipoAgendamentoLabel"><?= $label ?></span>
            <p class="agendamentoInfoLinha">
                Data de vencimento<br /> <span class="agendamentoProxLancamento"><?= $vencimentoAmigavel ?></span>
                <input type="hidden" value="" id="baixa" />
                <input type="hidden" value="<?= $idAgenda ?>" id="idAgenda" />
                <input type="hidden" value="<?= $id ?>" id="id" />
                <input type="hidden" value="<?= $config ?>" id="config" />
            </p>
            <p class="agendamentoInfoLinha">
                Data da baixa <br /> <span class="agendamentoProxLancamento change"><?= $dataBaixaAmigavel ?></span>
            </p>
            <p class="agendamentoInfoLinha">
            <?= $this->Html->link('CONFIRMAR',
                            '#javascript:;',
                            array('title' => 'CONFIRMAR',
                                  'class' => 'btnadd',
                                  'onclick' => 'confirmar()'));    ?>
            </p>
        </div>
    </div>
    
    <?php   echo $this->Html->script('forms');  ?>
    <? list($dia,$mes,$ano) = explode('-',$vencimento); ?>
    
    <script type="text/javascript">
        $(document).ready(function () {
            $('#datepicker').datepicker({
                        dateFormat: 'D, d MM, yy',
                        defaultDate: new Date(<?=$ano?>,<?=$mes-1?>,<?=$dia?>),
                        maxDate: 'dd-mm-yy',
                        altField: '#baixa',
                        altFormat: 'dd-mm-yy',
                        beforeShow: function(input, inst) {
                            $('.change').html(maxDate);
                        },
                        onSelect: function(dateText, inst){
                            $('.change').html(dateText);
                        }
            });
        });
        
        function confirmar(){
            
            var idAgenda    = $('#idAgenda').val();
            var id          = $('#id').val();
            var baixa       = $('#baixa').val();
            var config      = $('#config').val();
    
            $.ajax({
                
                url: '<?php echo $html->url(array("controller" => "agendamentos","action" => "confirmaResponse"));?>', 
                cache: false,
                type: 'GET',
                contentType: "application/x-www-form-urlencoded; charset=utf-8",
                data: ( {id : id, baixa: baixa, config: config} ),
                beforeSend: function(){
                    $('.confirmarBox img').remove();
                    $('.ajax_error_response').remove();
                    $('.confirmarBox').append('<?= $this->Html->image('ajax-loader-p.gif'); ?>');
                },
                success: function(result){
                    
                    if(result == 'error'){
                        $('.confirmarBox img').fadeOut('fast', function(){
                                $('.submit').append('<span class="ajax_error_response">Registro inválido.</span>')
                            });
                    }else if(result == 'validacao'){
                        $('.confirmarBox img').fadeOut('fast', function(){
                                $('.submit').append('<span class="ajax_error_response">A data não pode ser maior que a atual</span>');
                            });
                    }else{
                        
                        parent.$('#agend' + idAgenda).html(result);
                        var t=setTimeout("parent.jQuery.fn.colorbox.close()",100);
                    }
                }
                
            });
        }
    </script>