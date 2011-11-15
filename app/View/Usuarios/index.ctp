

<div class="frequencias index">
    <div id="contentHeader">
        <h1>Usuários</h1>
    </div>

    <div class="balancoBotoesWraper">
        <div class="balancoBotoes">
            <span class="pagina">Página</span>
            <p><?php echo $this->Paginator->counter(array('format' => __('%page%'))); ?></p>
            <span class="pagina">de</span>
            <p><?php echo $this->Paginator->counter(array('format' => __('%pages%'))); ?></p>
            <p>|</p>
            <p><?php echo $this->Paginator->counter(array('format' => __('%count%'))); ?></p>
            <span class="pagina">Registros</span>
        </div>
    </div>

    <div class="registrosWraper">

        <table cellpadding="0" cellspacing="0" id="whiteTable">
            <tr>
                <th><?php echo $this->Paginator->sort('id');?></th>
                <th><?php echo $this->Paginator->sort('nome');?></th>
                <th><?php echo $this->Paginator->sort('email');?></th>
                <th><?php echo $this->Paginator->sort('Último login','ultimologin');?></th>
                <th><?php echo $this->Paginator->sort('Data do cadastro','created');?></th>
                <th><?php echo $this->Paginator->sort('N° acessos','numdeacessos');?></th>
            </tr>

            <?php foreach ($usuarios as $value): ?>
            <tr>
                <td>
                    <?= $value['Usuario']['id']; ?></td>
                <td>
                    <?= h($value['Usuario']['nome']); ?><br />
                    <p class="author"><i><?= h($value['Usuario']['login']); ?></i></p>
                </td>
                <td>
                    <?= h($value['Usuario']['email']); ?>
                </td>
                <td>
                    <?= $this->Data->formata($value['Usuario']['ultimologin'],'descricaocompleta'); ?>
                </td>
                <td>
                    <?= $this->Data->formata($value['Usuario']['created']); ?>
                </td>
                <td>
                    <?= $value['Usuario']['numdeacessos']; ?>
                </td>
            </tr>
            <?php endforeach; ?>

        </table>

        <div class="paging">
            <?php echo $this->Paginator->prev('<< ' . __('previous'), array(), null, array('class'=>'disabled'));?>
            <?php echo $this->Paginator->numbers();?>
            <?php echo $this->Paginator->next(__('next') . ' >>', array(), null, array('class' => 'disabled'));?>
        </div>
    </div>

</div>

