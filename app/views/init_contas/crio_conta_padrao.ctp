<?= $this->Html->css('estilo'); ?>

<table>
    <thead>
        <tr>
            <th>Usuario</th>
            <th>Saldo</th>
        </tr>
    </thead>
    <?php foreach($result as $value){ ?>
    <tr>
        <td><?= $value['user'] ?></td>
        <td><?= $value['saldo'] ?></td>
    <tr>
    <?php } ;?>
</table>

<?= $this->element('sql_dump'); ?>

