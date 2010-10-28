<div class="frequencias form">
<?php echo $this->Form->create('Frequencia');?>
	<fieldset>
 		<legend><?php __('Edit Frequencia'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('nome');
		echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Frequencia.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Frequencia.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Frequencias', true), array('action' => 'index'));?></li>
	</ul>
</div>