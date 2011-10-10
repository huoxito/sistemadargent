<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php __('Dargent  Controle Financeiro'); ?> - 
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');
        echo $this->Html->css('style');
        echo $this->Html->script('jquery-1.4.2.min');
		echo $scripts_for_layout;
	?>
    
    <?php   $usuarioLogado = $session->read('Auth.Usuario.nome');   ?>

</head>
<body>
    
    <div id="container">
            <div id="header">
                <div id="logo">
                    <a href="<?php echo $this->Html->url('/'); ?>" title="home">
                        <?php echo $this->Html->image('logo.gif',
                                                array('width' => '321',
                                                      'height' => '99',
                                                      'alt' => 'dargent logo')); ?>
                    </a>
                </div>
                <div id="user">
                    <h1>
                        Minha Conta
                        <?php   echo $this->Session->flash('auth'); ?>
                    </h1>
                    
                    <?php   echo $form->create('Usuario', array('controller' => '/', 'action' => 'login'));    ?>
                    <div class="login" style="margin: 0 20px 0 10px;">
                        <?php echo $form->input('login',
                                            array('class' => 'l-nome',
                                                  'div' => false,
                                                  'maxlength' => '20',
                                                  'label' => 'Login: ')); ?>
                    </div>
                    
                    <div class="login">
                        <?php echo $form->input('password',
                                            array('class' => 'l-senha',
                                                  'div' => false,
                                                  'maxlength' => '15',
                                                  'label' => 'Senha: ')); ?>
                        
                    </div>
                    <?php echo $form->end(array('label' => 'Entrar',
                                                'class' => 'botao-login',
                                                'div' => false));  ?>
                    
                    <p class="senha">
                        <?php   echo  $this->Html->link('Esqueceu sua senha?',
                                            array('controller' => '/',
                                                  'action' => 'enviarSenha'));  ?>
                    </p>
                </div>
        
            </div>
    
        <div id="content">
            <?php   echo $content_for_layout; ?> 
        </div>
        
    </div>
    
    <div id="footer">
        <div id="menu_footer">
            <ul class="m-footer">
				<li></li>
                <li><a href="#">Quem Somos</a></li>
            	<li>|</li>
    			<li><a href="#">Ajuda</a></li>
                <li>|</li>
                <li><a href="#">Fale conosco</a></li>
            </ul>
        </div>
  		<p>Copyright © 2010 Dargent controle financeiro. Todos os direitos reservados</p>
    </div>
</div>	
    
<?php //echo $this->element('sql_dump'); ?>
<?php echo $js->writeBuffer(); // Write cached scripts ?>

</body>
</html>
