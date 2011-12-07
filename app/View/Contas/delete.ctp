 
    
    <div class="formBox">
    
        <p class="confirmacao">Você realmente deseja excluir essa Conta?</p>
        
        <?php echo $this->Form->create('Conta',array('default' => false));  ?>

        <div class="submit">
            
            <input type="hidden" id="id" value="<?= $registro['Conta']['id']; ?>">
            
            <input type="submit" id="submitAjax" value="Confirmar">
            <span class="ajax_error_response"></span>
        </div>
        </form>
    </div>
    
    <script type="text/javascript">
        
        $('#submitAjax').click(function(){

            var id = $('#id').val();

            $.ajax({
                url: '<?= $this->Html->url(array("controller" => "contas","action" => "delete"));?>',
                data: 'id=' + id,
                beforeSend: function(){
                    $('.submit').append('<?= $this->Html->image('ajax-loader-p.gif'); ?>');
                },
                success: function(result){
                
                    if( result == 'deleted' ){                                
                        var t=setTimeout("parent.$('#contaId" + id + "').fadeOut(); parent.jQuery.fancybox.close(); ",500);
                    }else{
                        $('.submit img').fadeOut('fast', function(){
                            $('.submit').append('Registro inválido')
                        });
                    }
                }
            });
        });
        
    </script>
    
