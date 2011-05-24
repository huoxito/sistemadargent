
<div class="ganhos formBox">  

    <div class="formWraper formBox">
                 
        <?= $this->Form->create('Move',
                        array('default' => false,
                              'inputDefaults' =>
                                array('error' => array('wrap' => 'span')))); ?>
                                
        <fieldset>
                           
            <div class="input required">
                <label>Tipo</label>
                <?php
                    $options = array('Faturamento'=> ' Faturamento ', 'Despesa'=>' Despesa ');
                    $attributes = array('legend'=> false,
                                        'class' => 'config',
                                        'label' => false);
                    echo $this->Form->radio('tipo',$options,$attributes);   
                ?>
            </div>
        
            <div id="selectCategoria" class="input text required">
                <?= $this->Form->input('categoria_id',
                                    array('empty' => 'Escolha uma categoria',
                                          'div' => false,
                                          'error' => false)); ?>
            </div>
             
            <?= $this->Form->input('id'); ?>
            <?= $this->Form->input('conta_id'); ?>
            <?= $this->Form->input('valor',
                                array('id' => 'valorMask'));  ?>
            <?= $this->Form->input('data', 
                                array('type' => 'text',
                                      'id' => 'data-calendario'));  ?>
            <?= $this->Form->input('obs',
                                    array('label' => 'Observações')); ?>

            <div class="submit">
                <input type="submit" value="Salvar" id="submitAjax">
                <span class="ajax_error_response"></span>
            </div>
            
        </fieldset>
            
    </div>

</div>
<script type="text/javascript">
    // <![CDATA[
    $("#submitAjax").click(function(){
        
        var id              = $('#MoveId').val();
        var tipo            = $('input:radio:checked').val();;      
        var categoria       = $('#MoveCategoriaId').val();
        var conta           = $('#MoveContaId').val();
        var valor           = $('#valorMask').val();
        var data            = $('#data-calendario').val();
        var obs             = $('#MoveObs').val();
        
        $.ajax({
            
            url: '/moves/editResponse',
            data: ({ Move: 
                        { id: id, categoria_id: categoria, valor: valor,
                            data: data, obs: obs, tipo: tipo, conta_id: conta }
            }),
            beforeSend: function(){
                $('.submit img').remove();
                $('.submit span').html('');
                $('.submit').append('<img src="/img/ajax-loader-p.gif" alt="enviando dados ..." />');
            },
            success: function(result){
                var json = $.parseJSON(result);
                $('.submit img').detach();

                if(json.result){
                    $('.ajax_error_response').html('carregando ...');
                    movimentacoes(json.mes, json.ano);
                    var t=setTimeout("parent.$.fancybox.close()",400);
                }else{
                    $('.ajax_error_response').html('Confira os dados e tente novamente');
                }
            }
        });

    });        
    // ]]>
</script>
