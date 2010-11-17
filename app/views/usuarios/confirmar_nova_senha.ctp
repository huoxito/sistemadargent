
        
    <div id="cadastro">

        <h1>Confirmação do recebimento do email</h1>
        
        <p>Olá <b><?php echo $info['Usuario']['nome']; ?></b>, </p>
        <p>Sua senha foi alterada em nosso banco. Use as informações indicadas abaixo para logar no sistema. <br />Após o login é extremamente recomendável redefinir sua senha.</p>
        
        <p>Login: <?php echo $info['Usuario']['login']; ?></p>
        <p>Senha: <?php echo $senha; ?></p>
       
    </div>
    
    