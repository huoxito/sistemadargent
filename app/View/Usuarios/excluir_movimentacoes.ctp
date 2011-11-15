   
<?php //echo $this->element('sql_dump'); ?> 
<div class="formBox">

    <p class="warning">
        Essa ação irá excluir todos os faturamentos, despesas e agendamentos 
        que você inseriu no sistema, lembre-se que essa ação <b>não poderá ser desfeita</b>.
    </p>
     
    <div class="submit">
        <input type="button" value="EXCLUIR TODAS AS MINHAS MOVIMENTAÇÕES" id="excluir" />
    </div>
            
</div>

<script type="text/javascript">
    
    $('#excluir').click(function(){
        $.ajax({
            url: "/usuarios/excluirMovimentacoes",
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
