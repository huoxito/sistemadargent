<div class="frequencias view">
<h2><?php  __('Frequencia');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $frequencia['Frequencia']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Nome'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $frequencia['Frequencia']['nome']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $frequencia['Frequencia']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $frequencia['Frequencia']['modified']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Status'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $frequencia['Frequencia']['status']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Frequencia', true), array('action' => 'edit', $frequencia['Frequencia']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Frequencia', true), array('action' => 'delete', $frequencia['Frequencia']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $frequencia['Frequencia']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Frequencias', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Frequencia', true), array('action' => 'add')); ?> </li>
	</ul>
</div>
