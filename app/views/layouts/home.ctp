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

</head>
<body>

    <div id="container">
        <div class=wrapper>
            <div id="header">
                <div id="logo">
                    <?php echo $this->Html->image('logo.gif',
                            array('width' => '321', 'height' => '99', 'alt' => 'dargent logo',
                                  'url' => '/')); ?>
                </div>
                <div id="user">
                    <h1> Minha Conta <?= $this->Session->flash(); ?> </h1>
                    
                    <?= $this->Form->create('Usuario', array('controller' => '/', 'action' => 'signin'));    ?>
                        <div class="login" style="margin: 0 20px 0 10px;">
                            <?= $this->Form->input('username', 
                                array('class' => 'l-nome', 'div' => false, 'error' => false, 'label' => 'Email ')); ?>
                        </div>
                        
                        <div class="login">
                            <?= $this->Form->input('password',
                                array('class' => 'l-senha', 'div' => false, 'maxlength' => '15', 'label' => 'Senha ')); ?>
                        </div>
                    <?= $this->Form->end(array('label' => 'Entrar', 'class' => 'botao-login', 'div' => false));  ?>

                    <p class="senha">
                        <?= $this->Html->link('Esqueceu sua senha?',
                                array('controller' => '/', 'action' => 'enviarSenha'));  ?>
                    </p>
                </div>
        
            </div>
        </div>
    
        <div id="content">
            <?= $content_for_layout; ?> 
        </div>
        
    </div>
    
    <div id="footer">
  		<p>
            Copyright © <?= date('Y'); ?> Dargent controle financeiro. 
            Powered by <a href="http://cakephp.org/" title="cakephp">Cakephp</a>
        </p>
    </div>
</div>	
    
<?php echo $this->element('sql_dump'); ?>
<?php echo $js->writeBuffer(); // Write cached scripts ?>

</body>
</html>
