    
    
<div class="formBox">  

    <?= $this->Form->create('Gasto',array('default' => false));?>
    
    <?= $this->Form->hidden('datadabaixa'); ?>
    <div class="datepickerWraper required">
        <label class="labelCalendario">
            Data da baixa
        </label>
        <span class="dataAmigavel change">
            <?= $this->Data->formata($this->data['Gasto']['datadabaixa'], 'longadescricao'); ?>
        </span>
        <div id="datepicker"></div>
    </div>
    
    <div class="inputsRight">
    
        <?= $this->Form->input('id'); ?>
        <div id="selectCategoria" class="input text required">
            <?= $this->Form->input('destino_id',
                                array('empty' => 'Escolha um registro',
                                      'div' => false)); ?>
            <a href="#" class="btnadd" title="inserir" id="insereInputDestinos">
                INSERIR NOVO DESTINO
            </a>
        </div>
        
        <?= $this->Form->input('conta_id'); ?>
        <?= $this->Form->input('valor', 
                            array('id' => 'valorMask')); ?>
        <?= $this->Form->input('observacoes',
                            array('type' => 'textarea',
                                  'label' => 'Observações',
                                  'id' => 'Observacoes')); ?>
    
    </div>
    
    <div class="submit">
        <input type="submit" id="submitAjax" value="Atualizar">
        <input type="submit" id="fecharColorbox" value="Cancelar" />
    </div>
    
</div>


<script type="text/javascript">
    // variáveis que serão usadas em algumas funções do arquivo form.js
    var urlInsereInput = '<?= $this->Html->url(array("action" => "InsereInput"));?>';
    var urlInsereSelect = '<?= $this->Html->url(array("action" => "InsereSelect"));?>';
</script>
<?php echo $this->Html->script('forms'); ?>

<? list($dia,$mes,$ano) = explode('-',$this->data['Gasto']['datadabaixa']); ?>
<script type="text/javascript">
    
    $('#datepicker').datepicker({
                dateFormat: 'D, d MM, yy',
                defaultDate: new Date(<?=$ano?>,<?=$mes-1?>,<?=$dia?>),
                maxDate: 'dd-mm-yy',
                altField: '#GastoDatadabaixa',
                altFormat: 'dd-mm-yy',
                onSelect: function(dateText, inst){
                    $('.change').html(dateText);
                }
    });
    
    $('#fecharColorbox').click(function(){
        parent.jQuery.fn.colorbox.close();
    });
    
    $('#submitAjax').live('click', function(){
        
        var id              = $('#GastoId').val();
        var nome            = $('#DestinoNome').val();
        var destino_id      = $('#GastoDestinoId').val();
        var conta_id        = $('#GastoContaId').val();
        var valor           = $('#valorMask').val();
        var data            = $('#GastoDatadabaixa').val();
        var obs             = $('#Observacoes').val();
        
        $.ajax({
            
            url: '<?php echo $html->url(array("action" => "editResponse"));?>', 
            data: ({ Gasto: {   id:id, destino_id: destino_id, conta_id: conta_id, valor: valor,
                                datadabaixa: data, observacoes: obs },
                     Destino: { nome:nome } }),
            beforeSend: function(){
                $('.submit span').detach();
                $('.submit').append('<?= $this->Html->image('ajax-loader-p.gif'); ?>');
            },
            success: function(result){
                
                $('.submit img').detach();
                if(result == 'error'){
                    $('.submit').append('<span class="ajax_error_response">Registro inválido</span>');
                }else if(result == 'validacao'){
                    $('.submit').append('<span class="ajax_error_response">Preencha todos os campos obrigatórios corretamente</span>');
                }else {
                    parent.$('#gasto-' + id).html(result);
                    var t=setTimeout("parent.jQuery.fn.colorbox.close()",100);
                }
            }
        });
        
    });
    
</script>
