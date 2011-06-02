<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php __('Dargent  :: '); ?>
		<?php echo $title_for_layout; ?>
	</title>
	
    <?php echo $this->Html->meta('icon'); ?>
    
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>	
    <script>
        !window.jQuery && document.write('<script src="/js/jquery-1.4.2.min.js"><\/script>');
    </script>

    <?php echo $this->Html->css('estilo'); ?>
    
    <?php echo $this->Html->css('jquery-ui-1.8rc3.custom'); ?>
    <?php echo $this->Html->script('jquery.ui.core'); ?>
    <?php echo $this->Html->script('ui.datepicker'); ?>
    
    <?php echo $this->Html->script('fancybox/jquery.mousewheel-3.0.4.pack'); ?>
    <?php echo $this->Html->script('fancybox/jquery.fancybox-1.3.4.pack'); ?>
    <?php echo $this->Html->css('jquery.fancybox-1.3.4');?>
    
    <?php echo $this->Html->script('forms'); ?>
    <?php echo $scripts_for_layout; ?>

    <?= $this->Html->script('jquery.maskMoney'); ?>

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
                    
            <p>Copyright © <?= date('Y'); ?> <b>Dargent controle financeiro</b>. Todos os direitos reservados</p>
            
        </div>

	</div>
	<?php echo $this->element('sql_dump'); ?>
    <?php //echo $js->writeBuffer(); // Write cached scripts ?>
</body>
</html>
