
    
    
    
    <?php   echo $form->create('Usuario', array('type' => 'file')); ?>
    
        <fieldset>
            <legend><?php __('Escolha uma nova imagem para seu perfil');?></legend>
        <?php
            echo $form->input('foto',
                              array('type'=>'file',
                                    'div' => array('class' => ''),
                                    'error' => array('wrap' => 'span', 'class' => 'error'),
                                    ));
            
        ?>
            <span class="observacao">OBS: imagem no formato jpg/jpeg com no máximo 2MG</span>
        </fieldset>
    
    <?php
            echo $form->end(array('label' => 'Salvar',
                                  'style' => 'float: left;','after' => ' <input type="submit" style="float: left;margin-left: 5px;" onclick="parent.jQuery.fn.colorbox.close();" value="Cancelar" />'));
    ?>
    
    <?php //echo $this->element('sql_dump'); ?>
    
    <?php   if( isset($runAjax) ){
            # upload feito ! agora mudo as fotos na pagina do perfil com ajax
    ?>
    
    <script type="text/javascript">
        
            $.ajax({
                url: '<?php echo $html->url(array("controller" => "usuarios","action" => "imageResponseP"));?>',
                cache: false,
                type: 'GET',
                contentType: "application/x-www-form-urlencoded; charset=utf-8",
                beforeSend: function(){
                    $('.submit').append('<?php echo $this->Html->image('ajax-loader.gif',array('alt' => 'carregando ...'));?>');
                },
                success: function(result){
                    parent.$('#perfil-p').html(result);
                } 
            });
            
            
            $.ajax({
                url: '<?php echo $html->url(array("controller" => "usuarios","action" => "imageResponseT"));?>',
                cache: false,
                type: 'GET',
                contentType: "application/x-www-form-urlencoded; charset=utf-8",
                beforeSend: function(){
                    $('.submit img').remove();
                    $('.submit').append('<?php echo $this->Html->image('ajax-loader.gif',array('alt' => 'carregando ...'));?>');
                },
                success: function(result){
                    parent.$('#perfil-t').html(result);
                } 
            });
            
            var t=setTimeout("parent.jQuery.fn.colorbox.close()",500);

    </script>
    
    <?php   }   ?>
    
    