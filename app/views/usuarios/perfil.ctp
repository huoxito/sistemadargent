    
    <?php
        $userFoto = $session->read('Auth.Usuario.foto');
    ?>
    
    <div class="usuarios index">
        
        <div id="contentHeader">
            <h1>
                <?php __('Perfil');?>
            </h1>
        </div>
        
        <div id="perfilWraper">
            
            <div>
            
                <div id="UserInfo">
                    
                    <span class="userInfoLabel">
                        Nome
                        <?php   echo $html->link('EDITAR',
                                            '#javascript:;',
                                            array('onclick' => 'insereInput(\'Name\',\''.addslashes($session->read('Auth.Usuario.nome')).'\')',
                                                  'class' => 'btneditar right')); ?>
                    </span>
                    
                    <div class="profile" id="userName">
                        <?php   echo $session->read('Auth.Usuario.nome'); ?>
                    </div>
                    
                    <span class="userInfoLabel">
                        Email
                        <?php   echo $this->Html->link('EDITAR',
                                            '#javascript:;',
                                            array('onclick' => 'insereInput(\'Email\',\''.$session->read('Auth.Usuario.email').'\')',
                                                  'class' => 'btneditar right')); ?>
                    </span>
                    
                    <div class="profile" id="userEmail">
                        <?php   echo $session->read('Auth.Usuario.email'); ?>
                    </div>
                                         
                    <span class="userInfoLabel">                     
                        Login
                    </span>
                    
                    <p class="profile">
                        <?php   echo $session->read('Auth.Usuario.login'); ?>
                    </p>
                    
                    <span class="userInfoLabel">                     
                        Senha
                        <?php echo $this->Html->link('MUDAR A SENHA',
                                                array('controller' => 'usuarios',
                                                      'action' => 'mudarSenha'),
                                                array('class' => 'btneditar right')); ?>
                    </span>
                    
                    <p class="profile">
                        ********
                    </p>
                    
                    <span class="userInfoLabel">
                        Logs
                    </span>
                    <p class="profile">
                        Número de acessos: <?php echo $item['Usuario']['numdeacessos']; ?>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        Último login: <?php echo $item['Usuario']['ultimologin']; ?>
                    </p>    
            
                </div>
                
            </div>
            
        </div>
        
        <div class="subheader">
            <h2>
                Últimas interações
            </h2>
        </div>
        
        <div id="ultimasInteracoesWraper">
            
            <div id="ultimasInteracoes">
                
                <?php foreach($ultimasInteracoes as $item){ ?>
                
                    <?php   if($item['Model'] === 'Faturamento' || $item['Model'] === 'Despesa'){   ?>
                    <p class="interacao">
                        <span class="model"><?php echo $item['Model']; ?></span>
                        R$ <?php echo $item['valor']; ?> « <?php echo $item['categoria']; ?> 
                        Baixa: <?php echo $item['datadabaixa']; ?>
                        <?php //echo $item['observacoes']; ?>
                        <span class="data"><?php echo $item['modified']; ?></span>
                    </p>
                    <?php   }else{  ?>
                    <p class="interacao">
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
        });

        function insereInput(campo,value){
            
            $.ajax({
                url: '<?php echo $this->Html->url(array("controller" => "usuarios","action" => "insereInput"));?>',
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
            $('#user'+campo).html(value);
        }
        
        function editar(campo){
                
            var value = $('#'+campo).val();
            
            $.ajax({
                url: '<?php echo $this->Html->url(array("controller" => "usuarios","action" => "editResponse"));?>',
                cache: false,
                type: 'GET',
                contentType: "application/x-www-form-urlencoded; charset=utf-8",
                data: ({ campo: campo, value: value }),
                beforeSend: function(){
                    $('#user' + campo).append('<?php echo $this->Html->image('ajax-loader-p.gif',array('alt' => 'carregando ...'));?>');
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