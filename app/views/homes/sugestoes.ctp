<div class="sugestoes form">
<?php   //echo $this->Session->flash(); ?>
<?php echo $form->create('Sugestoes', array('type' => 'file'));?>
	<fieldset>
 		<legend><?php __('Enviar Sugestão');?></legend>
	<?php
		echo $form->input('nome');
		echo $form->input('email');
		echo $form->input('texto');
        //echo $form->file('foto', array('div' => true, 'label' => true));
		echo $form->hidden('status', array('default' => 1));
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Listar Usuarios', true), array('action' => 'index'));?></li>
	</ul>
</div>
