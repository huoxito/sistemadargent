


<div id="selectCategoria" class="input text required">
    <label>Destino</label>
    <?= $this->Form->select('Gasto.destino_id',
                        $destinos,
                        false,
                        array('empty' => 'Escolha uma categoria',
                              'div' => false)); ?>
    <a href="#" class="btnadd" title="inserir" id="insereInputDestinos">
        INSERIR NOVO DESTINO
    </a>
</div>