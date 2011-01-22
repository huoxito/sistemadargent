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
                
                <div id="logo" style="float: none;">
                    <a href="<?php echo $html->url('/'); ?>" title="home">
                            <img src="<?php echo $html->url('/'); ?>img/logo.gif" alt="dargent logo" width="321" height="99" />
                    </a>
                </div>
        
            </div>
    
        <div id="content">
            
            <?php   echo $content_for_layout; ?>
            
        </div>
        
    </div>
    
    <div id="footer">
    	
        <div id="menu_footer">
        
        <!--<div class="footer-redes">
        
        	<a href="#" class="icone tweet"></a>
            <a href="#" class="icone facebook"></a>
        
        </div>-->
        
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