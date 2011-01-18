

<div class="contas formBox">
    
    <?= $this->Form->create('Conta', array('default' => false)); ?>    
    <fieldset>
        <?php
            echo $this->Form->input('id');
            echo $this->Form->input('nome');
            echo $this->Form->input('saldo');
            $options = array('corrente'=>' Corrente ', 'poupança'=> ' Poupança ', 'cash' => ' Cash ');
            $attributes = array('class' => 'config',
                                'label' => 'Tipo');
            echo $this->Form->radio('tipo',$options,$attributes);   
        ?>
        <div class="submit">
            <input type="submit" id="submitAjax" value="Atualizar">
            <input type="submit" id="fecharColorbox" value="Cancelar" />
            <span class="ajax_error_response"></span>
        </div>
    </fieldset>

</div>

<script type="text/javascript">
    
    $('#fecharColorbox').click(function(){
        parent.jQuery.fn.colorbox.close();
    });
            
    $('#submitAjax').click(function(event){
        
        event.stopPropagation();
        
        var id              = $('#ContaId').val();
        var nome            = $('#ContaNome').val();
        var saldo           = $('#ContaSaldo').val();
        var tipo            = $('input:radio:checked').val();
        
        $.ajax({
            
            url: '<?= $this->Html->url(array("action" => "edit"));?>', 
            data: ({ Conta: {id:id, nome:nome, saldo:saldo, tipo: tipo} }),
            beforeSend: function(){
                $('.submit span').html('');
                $('.submit').append('<?= $this->Html->image('ajax-loader-p.gif'); ?>');
            },
            success: function(result){
                
                $('.submit img').detach();
                if(result == 'error'){
                    $('.ajax_error_response').html('Registro inválido');
                }else if(result == 'validacao'){
                    $('.ajax_error_response').html('Preencha todos os campos obrigatórios corretamente');
                }else {
                    parent.$('#contaId' + id).html(result);
                    var t=setTimeout("parent.jQuery.fn.colorbox.close()",100);
                }
            }
        });
        return false;
    });
    
</script>