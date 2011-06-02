  
    
<div class="formBox">

    <p class="confirmacao">Você realmente deseja excluir esse registro?</p>
    <p class="agendamentoInfoLinha">
        <?php echo $this->data['Move']['valor']; ?> reais com
        <span class="agendamentoCategoria">
        <?php echo $this->data['Categoria']['nome']; ?>
        </span>
        em <?= $this->Time->format('d-m-Y', $this->data['Move']['data']); ?>
 
    </p>

    <?php echo $this->Form->create('Move',array('default' => false));  ?>
    <?php echo $this->Form->input('id'); ?>
    <div class="submit">
        <input type="submit" value="Excluir" id="submitAjax">
        <span class="ajax_error_response"></span>
    </div>
    
</div>
    
<script type="text/javascript">
        
    $("#MoveDeleteForm").submit(function(){
        
        var id = $('#MoveId').val(); 

        $.ajax({
            url: '<?php echo $this->Html->url(array("controller" => "Moves","action" => "delete"));?>',
            data: ({ id: id }),
            beforeSend: function(){
                $('.submit span').html('');
                $('.submit').append('<img src="/img/ajax-loader-p.gif" alt="carregando ..." />');
            },
            success: function(result){
                
                if(result){                                
                    var t=setTimeout("parent.$('#moveId" + id + "').fadeOut(); parent.jQuery.fancybox.close(); ",300);
                }else{
                    $('.submit img').detach();
                    $('.ajax_error_response').html('Registro não pode ser excluído ...');
                }
            }
        });

        return false;
    });
        
</script>
    
