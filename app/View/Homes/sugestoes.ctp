<div class="sugestoes form">
<?php   //echo $this->Session->flash(); ?>
<?php echo $this->Form->create('Sugestoes', array('type' => 'file'));?>
	<fieldset>
 		<legend><?php echo __('Enviar Sugestão');?></legend>
	<?php
		echo $this->Form->input('nome');
		echo $this->Form->input('email');
		echo $this->Form->input('texto');
        //echo $this->Form->file('foto', array('div' => true, 'label' => true));
		echo $this->Form->hidden('status', array('default' => 1));
	?>
	</fieldset>
<?php echo $this->Form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Listar Usuarios'), array('action' => 'index'));?></li>
	</ul>
</div>
