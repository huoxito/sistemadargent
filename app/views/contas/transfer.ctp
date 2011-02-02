<div class="contas formBox">
    
    <?= $this->Form->create('Conta', array('default' => false)); ?>    
    <fieldset>

        <?= $this->Form->input('saldo'); ?>
            
        <div class="input text">
            <label>Conta de origem</label>
            <?= $this->Form->select('origem', $conta_origem, null,array('escape' => false)); ?>
        </div>
        
        <div class="input text">
            <label>Conta de origem</label>
            <?= $this->Form->select('destino', $conta_destino, null,array('escape' => false)); ?>
        </div>

        <div class="submit">
            <input type="submit" id="submitAjax" value="Realizar Transferência">
            <input type="submit" id="fecharColorbox" value="Cancelar" />
            <span class="ajax_error_response"></span>
        </div>
    
    </fieldset>
        
</div>

<?php echo $this->Html->script('forms'); ?>

<script type="text/javascript">
    
    $('#fecharColorbox').click(function(){
        parent.jQuery.fn.colorbox.close();
    });
            
    $('#submitAjax').click(function(event){
        
        event.stopPropagation();
        
        var origem            = $('#ContaOrigem').val();
        var saldo             = $('#ContaSaldo').val();
        var destino           = $('#ContaDestino').val();
        
        $.ajax({
            
            url: 'contas/transfer',
            data: ({ Conta: { origem: origem, saldo:saldo, destino: destino } }),
            beforeSend: function(){
                $('.submit span').html('');
                $('.submit').append('<?= $this->Html->image('ajax-loader-p.gif'); ?>');
            },
            success: function(result){
                
                $('.submit img').detach();
                if(result == 'error'){
                    $('.ajax_error_response').html('Registro inválido');
                }else if(result == 'validacao'){
                    $('.ajax_error_response').html('Nome e Tipo são campos obrigatórios ...');
                }else {
                    parent.$('.tabelaListagem tbody').prepend(result);
                    var t=setTimeout("parent.jQuery.fn.colorbox.close()",100);
                }
            }
        });
        return false;
    });
    
</script>



