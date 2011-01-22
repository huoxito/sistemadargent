<div class="sugestos view">
<h2><?php  __('Sugestao');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $sugesto['Sugestao']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Usuario'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($sugesto['Usuario']['id'], array('controller' => 'usuarios', 'action' => 'view', $sugesto['Usuario']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Titulo'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $sugesto['Sugestao']['titulo']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Texto'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $sugesto['Sugestao']['texto']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $sugesto['Sugestao']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Status'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $sugesto['Sugestao']['status']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit Sugestao', true), array('action' => 'edit', $sugesto['Sugestao']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete Sugestao', true), array('action' => 'delete', $sugesto['Sugestao']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $sugesto['Sugestao']['id'])); ?> </li>
		<li><?php echo $html->link(__('List Sugestos', true), array('action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Sugestao', true), array('action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Fontes', true), array('controller' => 'fontes', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Fonte', true), array('controller' => 'fontes', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Usuarios', true), array('controller' => 'usuarios', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Usuario', true), array('controller' => 'usuarios', 'action' => 'add')); ?> </li>
	</ul>
</div>
