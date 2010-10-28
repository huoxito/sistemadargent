<div class="frequencias index">
	<h2><?php __('Frequencias');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('nome');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th><?php echo $this->Paginator->sort('status');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($frequencias as $frequencia):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $frequencia['Frequencia']['id']; ?>&nbsp;</td>
		<td><?php echo $frequencia['Frequencia']['nome']; ?>&nbsp;</td>
		<td><?php echo $frequencia['Frequencia']['created']; ?>&nbsp;</td>
		<td><?php echo $frequencia['Frequencia']['modified']; ?>&nbsp;</td>
		<td><?php echo $frequencia['Frequencia']['status']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $frequencia['Frequencia']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $frequencia['Frequencia']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $frequencia['Frequencia']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $frequencia['Frequencia']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Frequencia', true), array('action' => 'add')); ?></li>
	</ul>
</div>