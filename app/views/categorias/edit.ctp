<div class="fontes formBox">  
    
    <?= $this->Form->create('Categoria',array('default' => false));?>
    <?= $this->Form->input('id'); ?>
    <?= $this->Form->input('nome'); ?>
    <div class="submit">
        <input type="submit" value="Excluir" id="submitAjax">
        <span class="ajax_error_response"></span>
    </div>
</div>

<script type="text/javascript">
    
    $("#CategoriaEditForm").submit(function(){
        
        var nome   = $('#CategoriaNome').val();
        var id   = $('#CategoriaId').val();
        
        $.ajax({
            url: '<?php echo $this->Html->url(array("controller" => "categorias","action" => "editResponse"));?>', 
            data: ({ Categoria: { id: id, nome: nome} }),
            beforeSend: function(){
                $('.submit span').html('');
                $('.submit').append('<img src="/img/ajax-loader-p.gif" alt="salvando" />');
            },
            success: function(result){
                
                $('.submit img').detach();
                var json = $.parseJSON(result);

                if(json.result){
                    parent.$('#categoriaId' + id).html(nome);
                    var t=setTimeout("parent.jQuery.fancybox.close()",500);
                }else{
                    $('.ajax_error_response').append(json.error);
                }
            }
        });
    });       

</script>
