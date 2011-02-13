   
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
                        '<p class="respostaExcluir">Obrigado por usar o Dargent. Sua conta foi excluída e você está sendo direcionado para a página inicial do sistema.</p>'
                    );
                    //parent.window.location="/";
                    setTimeout("parent.window.location='/';parent.jQuery.fn.colorbox.close()", 2000);
                }
            }
        });
    });
    
</script>
