<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php __('Dargent  :: '); ?>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->css('cake.generic');
	?>
    
    <?php   $usuarioLogado = $session->read('Auth.Usuario.nome');   ?>
    
</head>
<body>
	<div id="container">
		<div id="header">
            
            
            <h1><?php echo __('Dargent :: Sistema Simples de Gerenciamento Financeiro', true); ?></h1>
            
            <?php   $usuarioLogado = $session->read('Auth.Usuario.nome');   ?>
            
            <?php   if( isset($usuarioLogado) ){  ?>
                    <div id="userinfo">
                        
                        <?php //echo $html->link('Home', '/'); ?>
                        <?php echo $this->Html->link(
                                $this->Html->image('home.png', array('alt'=> __('página inicial', true), 'title'=> __('página inicial', true), 'border' => '0')),
                                    '/',
                                    array('escape' => false)
                                );
                        ?>
                        <p style="margin: 10px 0 0 10px; float: left;"><?php echo $usuarioLogado; ?></p>
                        
                    </div>
            <?php  } ?>
            
		</div>
            
		<?php   echo $content_for_layout; ?>

		<div id="footer">
			<?php echo $this->Html->link(
					$this->Html->image('cake.power.gif', array('alt'=> __('CakePHP: the rapid development php framework', true), 'border' => '0')),
					'http://www.cakephp.org/',
					array('target' => '_blank', 'escape' => false)
				);
			?>
		</div>
	</div>
    
</body>
</html>