   
<?php //echo $this->element('sql_dump'); ?> 
<div class="formBox">

    <p class="warning">
        Tem certeza que deseja excluir sua conta do sistema? 
        Essa ação não <b>não poderá ser desfeita</b> e você perderá todos os dados cadastrados.
    </p>
     
    <div class="submit">
        <input type="button" value="EXCLUIR MINHA CONTA" id="excluir" />
    </div>
            
</div>

<script type="text/javascript">
    
    $('#excluir').click(function(){
        $.ajax({
            url: "/usuarios/excluirConta",
            beforeSend: function(){
                $('.respostaExcluir').remove();
                $('.submit').append('<img src="/img/ajax-loader-p.gif" alt="excluindo" ');
            },
            success: function(result){
                
                $('.submit img').detach(); 
                
                if(result){
                    
                    $('.submit').after(
                        '<p class="respostaExcluir">Todos os registros foram excluídos com sucesso ...  </p>'
                    );
                    setTimeout("parent.jQuery.fn.colorbox.close()", 1500);
                }
            }
        });
    });
    
</script>
