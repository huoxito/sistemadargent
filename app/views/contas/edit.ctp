<div class="contas form">
<?php echo $this->Form->create('Conta');?>
	<fieldset>
 		<legend><?php __('Edit Conta'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('usuario_id');
		echo $this->Form->input('nome');
		echo $this->Form->input('saldo');
		echo $this->Form->input('tipo');
		echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Conta.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Conta.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Contas', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Usuarios', true), array('controller' => 'usuarios', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Usuario', true), array('controller' => 'usuarios', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Agendamentos', true), array('controller' => 'agendamentos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Agendamento', true), array('controller' => 'agendamentos', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Ganhos', true), array('controller' => 'ganhos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ganho', true), array('controller' => 'ganhos', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Gastos', true), array('controller' => 'gastos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Gasto', true), array('controller' => 'gastos', 'action' => 'add')); ?> </li>
	</ul>
</div>