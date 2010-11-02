<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php __('Dargent  :: '); ?>
		<?php echo $title_for_layout; ?>
	</title>
	<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/3.2.0/build/cssreset/reset-min.css">
	<?php
		echo $this->Html->meta('icon');
		//echo $this->Html->css('cake.generic');
        echo $this->Html->css('estilo');
        echo $this->Html->css('colorbox');
        echo $this->Html->css('jquery-ui-1.8rc3.custom');
        echo $this->Html->script('jquery-1.4.2.min');
        echo $this->Html->script('jquery.colorbox-min');
        echo $this->Html->script('jquery.ui.core');
        echo $this->Html->script('ui.datepicker');
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
        <!--
		<div id="header">
            <?php  echo $this->element('topo'); ?> 
		</div>
        -->
        <div id="header">

            <img src="img/logo.png" width="191" height="60" style="margin-top:15px;" />
            <div class="caixa-login">
            
                <div class="box-right">
                
                    <img src="img/imagem-topo.jpg" width="64" height="64" />
                    <h1>Adriane Wald</h1>
                    <span class="minhaconta"><p>MINHA CONTA</p></span>
                    <span class="sair"><p>SAIR</p></span>
                </div>
                
                <div class="box-left">
                        <img src="img/sugestoes.jpg" width="42" height="34" />
                    <h1>Sugestões</h1>
                    <p>AJUDE-NOS A <br />DESENVOLVER O DARGENT</p>
                </div>
            </div>

        </div>
        
        
		<div id="content">
            
            <?php   echo $this->element('menu_lateral'); ?>
            
			<?php   //echo $this->Session->flash(); ?>
            <?php   echo $this->Session->flash('email'); ?>
			<?php   echo $content_for_layout; ?>

		</div>
		<div id="footer">
			<?php echo $this->Html->link(
					$this->Html->image('cake.power.gif', array('alt'=> __('CakePHP: the rapid development php framework', true), 'border' => '0')),
					'http://www.cakephp.org/',
					array('target' => '_blank', 'escape' => false)
				);
			?>
		</div>
	</div>
	<?php echo $this->element('sql_dump'); ?>
    <script type="text/javascript">
        
        // <![CDATA[
        $(document).ready(function () {
            $('.dataField').datepicker({
                        dateFormat: 'dd-mm-yy',
                        dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'],
                        monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
                        maxDate: 'd-m-y'
                    });
        });  
        // ]]>
        
    </script>
    <?php echo $js->writeBuffer(); // Write cached scripts ?>
</body>
</html>