
<? //$this->element('sql_dump'); ?>

<td>
    <?= $conta['Conta']['nome']; ?>
</td>
<td>
    R$ <?= $conta['Conta']['saldo'] ?>
</td>
<td>
    <?= $conta['Conta']['tipo']; ?>
</td>
<td>
    <?= $this->Data->formata($conta['Conta']['created']); ?>
</td>
<td>
    <?= $this->Data->formata($conta['Conta']['modified']); ?>
</td>
<td class="actions">
    <?= $this->Html->link('EDITAR',
                array('action' => 'edit', $conta['Conta']['id']),
                array('class' => 'colorbox-edit btneditar',
                      'title' => 'Editar Conta')); ?> 
    <?= $this->Html->link('Delete', array('action' => 'delete', $conta['Conta']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $conta['Conta']['id'])); ?>
</td>

<script type="text/javascript">
    $(document).ready(function () {
        $('.colorbox-delete').colorbox({width:"500", height: '220', opacity: 0.5, iframe: true});
        $('.colorbox-edit').colorbox({width:"800", height: "420", opacity: 0.5, iframe: true});
    });
</script>


