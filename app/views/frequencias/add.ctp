<div class="frequencias form">
<?php echo $this->Form->create('Frequencia');?>
	<fieldset>
 		<legend><?php __('Add Frequencia'); ?></legend>
	<?php
		echo $this->Form->input('nome');
		echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Frequencias', true), array('action' => 'index'));?></li>
	</ul>
</div>