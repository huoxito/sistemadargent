<div class="contas view">
<h2><?php  __('Conta');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $conta['Conta']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Usuario'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($conta['Usuario']['id'], array('controller' => 'usuarios', 'action' => 'view', $conta['Usuario']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Nome'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $conta['Conta']['nome']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Saldo'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $conta['Conta']['saldo']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Tipo'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $conta['Conta']['tipo']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $conta['Conta']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $conta['Conta']['modified']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Status'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $conta['Conta']['status']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Conta', true), array('action' => 'edit', $conta['Conta']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Conta', true), array('action' => 'delete', $conta['Conta']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $conta['Conta']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Contas', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Conta', true), array('action' => 'add')); ?> </li>
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
<div class="related">
	<h3><?php __('Related Agendamentos');?></h3>
	<?php if (!empty($conta['Agendamento'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Usuario Id'); ?></th>
		<th><?php __('Model'); ?></th>
		<th><?php __('Frequencia Id'); ?></th>
		<th><?php __('Fonte Id'); ?></th>
		<th><?php __('Destino Id'); ?></th>
		<th><?php __('Conta Id'); ?></th>
		<th><?php __('Valor'); ?></th>
		<th><?php __('Datadevencimento'); ?></th>
		<th><?php __('Numdeparcelas'); ?></th>
		<th><?php __('Observacoes'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th><?php __('Status'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($conta['Agendamento'] as $agendamento):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $agendamento['id'];?></td>
			<td><?php echo $agendamento['usuario_id'];?></td>
			<td><?php echo $agendamento['model'];?></td>
			<td><?php echo $agendamento['frequencia_id'];?></td>
			<td><?php echo $agendamento['fonte_id'];?></td>
			<td><?php echo $agendamento['destino_id'];?></td>
			<td><?php echo $agendamento['conta_id'];?></td>
			<td><?php echo $agendamento['valor'];?></td>
			<td><?php echo $agendamento['datadevencimento'];?></td>
			<td><?php echo $agendamento['numdeparcelas'];?></td>
			<td><?php echo $agendamento['observacoes'];?></td>
			<td><?php echo $agendamento['created'];?></td>
			<td><?php echo $agendamento['modified'];?></td>
			<td><?php echo $agendamento['status'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'agendamentos', 'action' => 'view', $agendamento['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'agendamentos', 'action' => 'edit', $agendamento['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'agendamentos', 'action' => 'delete', $agendamento['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $agendamento['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Agendamento', true), array('controller' => 'agendamentos', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related Ganhos');?></h3>
	<?php if (!empty($conta['Ganho'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Usuario Id'); ?></th>
		<th><?php __('Agendamento Id'); ?></th>
		<th><?php __('Fonte Id'); ?></th>
		<th><?php __('Conta Id'); ?></th>
		<th><?php __('Valor'); ?></th>
		<th><?php __('Datadabaixa'); ?></th>
		<th><?php __('Datadevencimento'); ?></th>
		<th><?php __('Observacoes'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th><?php __('Status'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($conta['Ganho'] as $ganho):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $ganho['id'];?></td>
			<td><?php echo $ganho['usuario_id'];?></td>
			<td><?php echo $ganho['agendamento_id'];?></td>
			<td><?php echo $ganho['fonte_id'];?></td>
			<td><?php echo $ganho['conta_id'];?></td>
			<td><?php echo $ganho['valor'];?></td>
			<td><?php echo $ganho['datadabaixa'];?></td>
			<td><?php echo $ganho['datadevencimento'];?></td>
			<td><?php echo $ganho['observacoes'];?></td>
			<td><?php echo $ganho['created'];?></td>
			<td><?php echo $ganho['modified'];?></td>
			<td><?php echo $ganho['status'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'ganhos', 'action' => 'view', $ganho['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'ganhos', 'action' => 'edit', $ganho['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'ganhos', 'action' => 'delete', $ganho['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $ganho['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Ganho', true), array('controller' => 'ganhos', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related Gastos');?></h3>
	<?php if (!empty($conta['Gasto'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Usuario Id'); ?></th>
		<th><?php __('Agendamento Id'); ?></th>
		<th><?php __('Destino Id'); ?></th>
		<th><?php __('Conta Id'); ?></th>
		<th><?php __('Valor'); ?></th>
		<th><?php __('Datadabaixa'); ?></th>
		<th><?php __('Datadevencimento'); ?></th>
		<th><?php __('Observacoes'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th><?php __('Status'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($conta['Gasto'] as $gasto):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $gasto['id'];?></td>
			<td><?php echo $gasto['usuario_id'];?></td>
			<td><?php echo $gasto['agendamento_id'];?></td>
			<td><?php echo $gasto['destino_id'];?></td>
			<td><?php echo $gasto['conta_id'];?></td>
			<td><?php echo $gasto['valor'];?></td>
			<td><?php echo $gasto['datadabaixa'];?></td>
			<td><?php echo $gasto['datadevencimento'];?></td>
			<td><?php echo $gasto['observacoes'];?></td>
			<td><?php echo $gasto['created'];?></td>
			<td><?php echo $gasto['modified'];?></td>
			<td><?php echo $gasto['status'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'gastos', 'action' => 'view', $gasto['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'gastos', 'action' => 'edit', $gasto['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'gastos', 'action' => 'delete', $gasto['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $gasto['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Gasto', true), array('controller' => 'gastos', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
