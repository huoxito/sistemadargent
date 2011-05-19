<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?>
        <?php 'Sistema Dargent'; ?>
    </title>
    
	<?php
	
    	echo $this->Html->meta('icon');
		echo $this->Html->css('estilo');
        
        echo $this->Html->script('jquery-1.4.2.min');
        echo $this->Html->css('jquery-ui-1.8rc3.custom');
        echo $this->Html->script('jquery.ui.core');
        echo $this->Html->script('ui.datepicker');
        
        echo $this->Html->script('forms');
        
		echo $scripts_for_layout;
	?>
    <?= $this->Html->script('jquery.maskMoney'); ?>

    <style type="text/css" media="all">
    html {background-color: #FFF !important;}
    </style>
</head>
<body>

	<?php   echo $content_for_layout; ?>

	<?php //echo $this->element('sql_dump'); ?>
    <?php //echo $js->writeBuffer(); // Write cached scripts ?>
</body>
</html>
