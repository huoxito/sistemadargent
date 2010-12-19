<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    
<?php echo $this->Html->charset(); ?>
<?php echo $this->Html->meta('icon'); ?>

<title>
    Sistema Dargent 
    <?php echo $title_for_layout; ?>
</title>

<style type="text/css">
<!--
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
}
body {
	background-color: #F2F2F2;
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
    font-size:12px;
}
.box a
{
	background-color:#9BD253;
	color:#FFF;
	-moz-border-radius: 3px;
	-webkit-border-radius: 3px;
	display:block;
	padding:4px;
	width:240px;
	margin: 0 auto;
	text-align:center;
	text-decoration:none;
	border-bottom:1px solid #999;
}
.box a:hover
{
	background-color:#B0E356;
}
.box p
{
	width:400px;
	float:right;
	top:262px;
	margin: 35px 10px 0 335px;
	position:absolute;
	color:#000;
}
#content {
    border:6px solid #CBE4A3;
    background-color:#FFF;
    margin:auto;
    margin-top:25px;
    width:700px;
    height:380px;
}
#footer {
    width:700px;
    text-align:center;
    margin:auto;
    margin-top:10px;
    clear:both;
}
#imgWaper {
    padding: 30px 10px 0;
}
-->
</style>
    
</head>

<body>

    <div id="content" class="box">
        <div id="imgWaper">
            <?= $this->Html->image('404.jpg'); ?>
        </div>
        <?= $content_for_layout; ?>
        <?= $this->Html->link('VOLTAR A PÁGINA INICIAL DO SISTEMA',array('controller' => '/')); ?>
    </div>
    
    <div id="footer">
        Copyright &copy; 2010 <strong>Dargent controle financeiro</strong>. Todos os direitos reservados
    </div>

</body>
</html>