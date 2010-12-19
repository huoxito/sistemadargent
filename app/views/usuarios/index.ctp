

<div class="frequencias index">
	<h2><?php __('Frequencias');?></h2>
	
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?php echo $this->Paginator->sort('id');?></th>
            <th><?php echo $this->Paginator->sort('nome');?></th>
            <th><?php echo $this->Paginator->sort('Último login','ultimologin');?></th>
            <th><?php echo $this->Paginator->sort('Cadastro','created');?></th>
            <th><?php echo $this->Paginator->sort('sts');?></th>
        </tr>
    
        <?php foreach ($usuarios as $value): ?>
        <tr>
            <td>
                <?php echo $value['Usuario']['id']; ?></td>
            <td>
                <?php echo h($value['Usuario']['nome']); ?><br />
                <?php echo h($value['Usuario']['login']); ?><br />
                <?php echo h($value['Usuario']['email']); ?>
            </td>
            <td>
                <?php echo $value['Usuario']['ultimologin']; ?>
            </td>
            <td>
                <?php echo $value['Usuario']['created']; ?>
            </td>
            <td>
                <?php echo $value['Usuario']['status']; ?>
            </td>
        </tr>
        <?php endforeach; ?>
        
	</table>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
