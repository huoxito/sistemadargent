        

        <p>Olá <?php   echo $info['Usuario']['nome']; ?> !</p>
        
        <p>Este email refere-se a sua senha no <span style="color: #9BD252;">Sistema Dargent</span>, acesse a url abaixo para confirmar o recebimento dessa mensagem e dar proseguimento a criação da sua nova senha.</p>
        
        <p>
            <a href="<?php echo $this->Html->url('/usuarios/confirmarNovaSenha/'.$hash, true); ?>" title="confirmação do email">
                <?php echo $this->Html->url('/usuarios/confirmarNovaSenha/'.$hash, true); ?>
            </a>
        </p>
        
        
        <p>
            Sistema Dargent - Controle Fincanceiro
            <br />
            <a href="http://www.sistemadargent.com.br" title="sistema dargent">http://www.sistemadargent.com.br</a>
        </p>
        