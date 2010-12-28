


<div id="selectCategoria" class="input text required">
    <label>Fonte</label>
    <?= $this->Form->select('Ganho.fonte_id',
                        $fontes,
                        false,
                        array('empty' => 'Escolha uma categoria',
                              'div' => false)); ?>
    <a href="#" class="btnadd" title="inserir" id="insereInputFontes">
        INSERIR NOVA FONTE
    </a>
</div>