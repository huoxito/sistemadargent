<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?>
        <?php 'Sistema Dargent'; ?>
    </title>
    
    <?php echo $this->Html->meta('icon'); ?>

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>	
    <script>
        !window.jQuery && document.write('<script src="/js/jquery-1.4.2.min.js"><\/script>');
    </script>

	<?php echo $this->Html->css('hehehe'); ?>
    
    <?php echo $this->Html->css('jquery-ui-1.8rc3.custom'); ?>
    <?php echo $this->Html->script('jquery.ui.core'); ?>
    <?php echo $this->Html->script('ui.datepicker'); ?>

    <?php echo $this->Html->script('forms'); ?>

    <?= $this->Html->script('jquery.maskMoney'); ?>

    <style type="text/css" media="all">
        html {background-color: #FFF !important;}
    </style>

</head>
<body>

	<?php   echo $content_for_layout; ?>

	<?php //echo $this->element('sql_dump'); ?>
    <?php //echo $this->Js->writeBuffer(); // Write cached scripts ?>
</body>
</html>
