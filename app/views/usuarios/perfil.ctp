    
    <?php
        $userFoto = $session->read('Auth.Usuario.foto');
    ?>
    
    <div class="usuarios index">
        
        <h2 class="headers"><?php __('Perfil');?></h2>
        <div class="session-links">
            <ul>
                <li><?php echo $this->Html->link('Mudar a senha',
                                                 array('controller' => 'usuarios', 'action' => 'mudarSenha'),
                                                 array('class' => '')); ?>
                </li>
                <li>
                    <?php
                        if( !empty($userFoto) ){   
                            
                            echo $this->Html->link('Mudar foto',
                                                 array('controller' => 'usuarios', 'action' => 'mudarImagem'),
                                                 array('class' => 'colorbox-imagem')); 
                        }else{
                            
                            echo $this->Html->link('Inserir foto de perfil',
                                                 array('controller' => 'usuarios', 'action' => 'mudarImagem'),
                                                 array('class' => 'colorbox-imagem')); 
                        }
                    ?>
                </li>
            </ul>
        </div>
        
            <div style="float: left; width: 100%;">
                
                <?php if( !empty($userFoto) ){   ?>
                <div style="float: left; postition: absolute;">
                    <img src="<?php echo $this->Html->url('/'); ?>uploads/usuario/foto/thumb/gerenciador/<?php echo $session->read('Auth.Usuario.foto'); ?>" alt="<?php echo $session->read('Auth.Usuario.nome'); ?>" />    
                </div>
                <?php   }   ?>
                
                  
                
                <div style="<?php if( !empty($userFoto) ){   ?>margin-left: 200px;<?php   }   ?>">
                
                <div class="profile" id="userName">
                    <?php   echo $session->read('Auth.Usuario.nome'); ?>
                    <?php   echo $html->link(__('Editar', true),
                                                    '#javascript:;',
                                                    array('onclick' => 'insereInput(\'Name\',\''.$session->read('Auth.Usuario.nome').'\')')
                                                    ); ?>
                </div>
                
                <div class="profile" id="userEmail">
                    <?php   echo $session->read('Auth.Usuario.email'); ?>
                    <?php   echo $html->link(__('Editar', true),
                                                '#javascript:;',
                                                array('onclick' => 'insereInput(\'Email\',\''.$session->read('Auth.Usuario.email').'\')')
                                                    ); ?>
                </div>
                
                <p class="profile">Login: <?php   echo $session->read('Auth.Usuario.login'); ?></p>
                
                <p class="profile">
                    Número de acessos: <?php echo $item['Usuario']['numdeacessos']; ?>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    Último login: <?php echo $item['Usuario']['ultimologin']; ?>
                </p>
            
                
                    
                    <h3 class="profile">Últimas interações</h3>
                    
                    <?php foreach($ultimasInteracoes as $item){ ?>     
                        <?php   if($item['Model'] === 'Faturamento' || $item['Model'] === 'Despesa'){   ?>
                    <p class="profile interacao">
                        <span class="model"><?php echo $item['Model']; ?></span>
                        R$ <?php echo $item['valor']; ?> « <?php echo $item['categoria']; ?> 
                        Baixa: <?php echo $item['datadabaixa']; ?>
                        <?php //echo $item['observacoes']; ?>
                        <span class="data"><?php echo $item['modified']; ?></span>
                    </p>
                    <?php   }else{  ?>
                    <p class="profile interacao">
                        <span class="model"><?php echo $item['Model']; ?></span>
                        R$ <?php echo $item['valor']; ?>  «
                        <?php echo $item['categoria']; ?>
                        <?php echo $item['frequencia']; ?>
                        <span class="data"><?php echo $item['modified']; ?></span>
                    </p>
                        <?php   }   ?>
                    <?php   }   ?>  
                
                </div>
                
            </div>
            
            

    </div>
        
    <script type="text/javascript">
        
        // <![CDATA[
        $(document).ready(function () {
            $('.colorbox-imagem').colorbox({width:"700", height:"300", opacity: 0.5, iframe: true});
            
            $("p.interacao").mouseover(function() {
                $(this).css("background-color",'#FFF9EF');
            }).mouseout(function(){
                $(this).css("background-color",'#FFF');
            });
        });

        function insereInput(campo,value){
            
            $.ajax({
                url: '<?php echo $html->url(array("controller" => "usuarios","action" => "insereInput"));?>',
                cache: false,
                type: 'GET',
                contentType: "application/x-www-form-urlencoded; charset=utf-8",
                data: ({ campo: campo, value: value }),
                beforeSend: function(){
                    $('#user' + campo).append('<?php echo $this->Html->image('ajax-loader-p.gif',array('alt' => 'carregando ...'));?>');
                },
                success: function(result){
                    $('#user' + campo).html(result)
                } 
            });
        }
        
        function cancela(campo,value){
            var editar = ' <a href="#javascript:;" onclick="insereInput(\''+campo+'\',\''+value+'\')"  title="editar">Editar</a> ';
            $('#user'+campo).html(value+editar);
        }
        
        function editar(campo){
                
            var value = $('#'+campo).val();
            
            $.ajax({
                url: '<?php echo $html->url(array("controller" => "usuarios","action" => "editResponse"));?>',
                cache: false,
                type: 'GET',
                contentType: "application/x-www-form-urlencoded; charset=utf-8",
                data: ({ campo: campo, value: value }),
                beforeSend: function(){
                    $('#user' + campo).append(' <?php echo $this->Html->image('ajax-loader-p.gif',array('alt' => 'carregando ...'));?>');
                },
                success: function(result){
                
                    if(result == 'validacao'){
                        $('#user' + campo + ' img').remove();
                        $('#user' + campo + ' form span').remove();
                        $('#user' + campo + ' form').append(' <span style="float: none;" class="ajax_error_response">Preencha o campo corretamente</span>')
                    }else{
                        $('#user' + campo).html(result)
                    }
                } 
            }); 
        }
        // ]]>
        
    </script>
    
    
