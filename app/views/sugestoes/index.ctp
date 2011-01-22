
<div class="sugestos index">


    <div id="contentHeader">
        <h1>Sugestões</h1>
    </div>

    <div class="balancoBotoesWraper">
        <div class="balancoBotoes">

            <span class="pagina">Página</span>
            <p><?php echo $this->Paginator->counter(array('format' => __('%page%',true))); ?></p>
            <span class="pagina">de</span>
            <p><?php echo $this->Paginator->counter(array('format' => __('%pages%',true))); ?></p>
            <p>|</p>
            <p><?php echo $this->Paginator->counter(array('format' => __('%count%',true))); ?></p>
            <span class="pagina">Registros</span>

        </div>
    </div>

    <div class="registrosWraper">

        <table cellpadding="0" cellspacing="0" id="whiteTable">
            <tr>
                <th>Texto</th>
                <th>Criado</th>
                <th>Sts</th>
            </tr>

            <?php
            foreach ($sugestos as $sugesto):
            ?>
            <tr>
                <td>
                    <span class="blue"><?= h($sugesto['Sugestao']['titulo']); ?></span>
                    <?= $sugesto['Sugestao']['texto']; ?>
                    <p class="author">por <i><?= $sugesto['Usuario']['nome']; ?></i></p>
                </td>
                <td>
                    <?= $this->Data->formata($sugesto['Sugestao']['created']); ?>
                </td>
                <td>
                    <?php echo $sugesto['Sugestao']['status']; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>

        <div class="paging">
            <?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
            <?php echo $paginator->numbers();?>
            <?php echo $paginator->next(__('next', true).' >>', array(), null, array('class' => 'disabled'));?>
        </div>

    </div>
</div>

