    
    <div class="usuarios index">
        
        <div id="contentHeader">
            <h1>
                <?php __('Perfil');?>
            </h1>
        </div>
        
        <div id="perfilWraper">
            
            <div>
                <?php   echo $this->Session->flash(); ?>
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
                    </p>    
                    
                    <div id="excluirDados">
                         <h3>Opções para limpar os dados da sua conta ou excluí-la: </h3>
                         <?= $this->Html->link('EXCLUIR TODAS AS MOVIMENTAÇÕES',
                                                array('controller' => 'usuarios',
                                                      'action' => 'excluirMovimentacoes'),
                                                array('class' => 'btnexcluir right colorbox-excluir')); ?>
                         <?= $this->Html->link('EXCLUIR TODAS AS CATEGORIAS',
                                                array('controller' => 'usuarios',
                                                      'action' => 'excluirCategorias'),
                                                array('class' => 'btnexcluir right colorbox-excluir')); ?>
                         <?= $this->Html->link('EXCLUIR MINHA CONTA',
                                                array('controller' => 'usuarios',
                                                      'action' => 'excluirConta'),
                                                array('class' => 'btnexcluir right colorbox-excluir')); ?>
                    </div>
                     
                </div>
                
            </div>
            
        </div>
        
    </div>
        
    <script type="text/javascript">
        
        // <![CDATA[
        $(".colorbox-excluir").fancybox({
            'transitionIn'  :   'none',
            'transitionOut' :   'none',
            'width'         :   600,
            'height'        :   150,
            'speedIn'       :   600, 
            'speedOut'      :   200, 
            'overlayShow'   :   false,
            'type'          :   'iframe' 
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
