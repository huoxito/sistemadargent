        

        <p>Olá <?php   echo $info['Usuario']['nome']; ?> !</p>
        
        <p>Foi gerada uma nova senha para você no <span style="color: #9BD252;">Sistema Dargent</span>, acesse a url abaixo para confirmar o recebimento desse email e dar proseguimento a criação da sua nova senha.</p>
        
        <p><?php echo $this->Html->url('/usuarios/confirmarNovaSenha/'.$hash, true); ?></p>
        
        
        <p>Sistema Dargent - Controle Fincanceiro<br />http://www.sistemadargent.com.br - http://dargent.testsoh.com.br</p>
        