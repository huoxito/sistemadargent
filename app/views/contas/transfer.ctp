

<div class="contas formBox">

    <span class="tipoAgendamentoLabel">
        TRANSFERÊNCIAS
    </span>   
    <?= $this->Form->create('Conta', array('default' => false)); ?>    
    <fieldset>

        <?= $this->Form->input('valor', 
                        array('id' => 'valorMask')); ?>
            
        <div class="input text">
            <label>Conta de origem</label>
            <?= $this->Form->select('origem', $conta_origem, null,array('escape' => false)); ?>
        </div>
        
        <div class="input text">
            <label>Conta de destino</label>
            <?= $this->Form->select('destino', $conta_destino, null,array('escape' => false)); ?>
        </div>

        <div class="submit">
            <input type="submit" id="submitAjax" value="Realizar Transferência">
            <input type="submit" id="fecharColorbox" value="Cancelar" />
            <span class="ajax_error_response"></span>
        </div>
    
    </fieldset>
    </form>    
</div>

<?php echo $this->Html->script('forms'); ?>

<script type="text/javascript">
    
    $('#fecharColorbox').click(function(){
        parent.jQuery.fn.colorbox.close();
    });
            
    $('#submitAjax').click(function(event){
        
        event.stopPropagation();
        
        var origem            = $('#ContaOrigem').val();
        var valor             = $('#ContaValor').val();
        var destino           = $('#ContaDestino').val();
        
        $.ajax({
            
            url: '/contas/transfer',
            data: ({ Conta: { origem: origem, valor: valor, destino: destino } }),
            beforeSend: function(){
                $('.submit').append('<?= $this->Html->image('ajax-loader-p.gif'); ?>');
            },
            success: function(result){
               
                $('.submit img') .detach();
                var json = $.parseJSON(result);
                
                if(json.erro){
                    $('.ajax_error_response').html(json.erro);
                }else{
                    parent.$('#contaSaldo' + origem ).html('R$ ' + json.origem);
                    parent.$('#contaSaldo' + destino ).html('R$ ' + json.destino);
                    parent.$('.flash_success').html(json.message);
                    parent.jQuery.fn.colorbox.close();
                }

            }
        });
        return false;
    });
    
</script>



