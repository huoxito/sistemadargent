<div class="sugestos form">
<?php echo $form->create('Sugesto');?>
	<fieldset>
 		<legend><?php __('Edit Sugesto');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('usuario_id');
		echo $form->input('titulo');
		echo $form->input('texto');
		echo $form->input('status');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action' => 'delete', $form->value('Sugesto.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Sugesto.id'))); ?></li>
		<li><?php echo $html->link(__('List Sugestos', true), array('action' => 'index'));?></li>
		<li><?php echo $html->link(__('List Fontes', true), array('controller' => 'fontes', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Fonte', true), array('controller' => 'fontes', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Usuarios', true), array('controller' => 'usuarios', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Usuario', true), array('controller' => 'usuarios', 'action' => 'add')); ?> </li>
	</ul>
</div>