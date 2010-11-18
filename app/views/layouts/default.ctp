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
        echo $this->Html->css('estilo');
        echo $this->Html->css('colorbox');
        echo $this->Html->css('jquery-ui-1.8rc3.custom');
        echo $this->Html->script('jquery-1.4.2.min');
        echo $this->Html->script('jquery.colorbox-min');
        echo $this->Html->script('jquery.ui.core');
        echo $this->Html->script('ui.datepicker');
		echo $scripts_for_layout;
	?>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-19138323-1']);
  _gaq.push(['_setDomainName', '.testsoh.com.br']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</head>
<body>
	<div id="container">

		<div id="header">
            <?php  echo $this->element('topo'); ?> 
		</div>
 
		<div id="content">
            
            <?php   echo $this->element('menu_lateral'); ?>
            
			<?php   //echo $this->Session->flash(); ?>
            <?php   echo $this->Session->flash('email'); ?>
			<?php   echo $content_for_layout; ?>

		</div>

        <div id="footer">
        
            <a href="#">Ajuda</a> / 
            <a href="#">Quem somos</a> / 
            <a href="#">Fale conosco</a>
            
            <p>Copyright © 2010 <b><a href="#">Dargent controle financeiro</a></b>. Todos os direitos reservados</p>
            
        </div>

	</div>
	<?php echo $this->element('sql_dump'); ?>
    <?php echo $js->writeBuffer(); // Write cached scripts ?>
</body>
</html>