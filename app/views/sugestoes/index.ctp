<div class="sugestos index">
<h2><?php __('Sugestos');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('usuario_id');?></th>
	<th><?php echo $paginator->sort('titulo');?></th>
	<th><?php echo $paginator->sort('texto');?></th>
	<th><?php echo $paginator->sort('created');?></th>
	<th><?php echo $paginator->sort('status');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($sugestos as $sugesto):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $sugesto['Sugestao']['id']; ?>
		</td>
		<td>
			<?php echo $html->link($sugesto['Usuario']['id'], array('controller' => 'usuarios', 'action' => 'view', $sugesto['Usuario']['id'])); ?>
		</td>
		<td>
			<?php echo $sugesto['Sugestao']['titulo']; ?>
		</td>
		<td>
			<?php echo $sugesto['Sugestao']['texto']; ?>
		</td>
		<td>
			<?php echo $sugesto['Sugestao']['created']; ?>
		</td>
		<td>
			<?php echo $sugesto['Sugestao']['status']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action' => 'view', $sugesto['Sugestao']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action' => 'edit', $sugesto['Sugestao']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action' => 'delete', $sugesto['Sugestao']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $sugesto['Sugestao']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class' => 'disabled'));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('New Sugestao', true), array('action' => 'add')); ?></li>
		<li><?php echo $html->link(__('List Fontes', true), array('controller' => 'fontes', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Fonte', true), array('controller' => 'fontes', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Usuarios', true), array('controller' => 'usuarios', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Usuario', true), array('controller' => 'usuarios', 'action' => 'add')); ?> </li>
	</ul>
</div>