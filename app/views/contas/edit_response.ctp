
<? //$this->element('sql_dump'); ?>

<td>
    <?= $conta['Conta']['nome']; ?>
</td>
<td>
    <?= $conta['Conta']['saldo'] ?>
</td>
<td class="tipo">
    <?= $conta['Conta']['tipo']; ?>
</td>
<td class="actions">
    <?= $this->Html->link('EDITAR',
                array('action' => 'edit', $conta['Conta']['id']),
                array('class' => 'colorbox-edit btneditar',
                      'title' => 'Editar Conta')); ?> 
</td>

<script type="text/javascript">
    $(document).ready(function () {
        $('.colorbox-delete').colorbox({width:"500", height: '180', opacity: 0.5, iframe: true});
        $('.colorbox-edit').colorbox({width:"800", height: "420", opacity: 0.5, iframe: true});
    });
</script>


