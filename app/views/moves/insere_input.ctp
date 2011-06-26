

<div id="inputCategoria" class="input text required">
    <?= $this->Form->input('Categoria.nome',
                        array('label' => 'Categoria',
                              'div' => false)); ?>
    <a href="#" title="selecionar" class="btnadd" id="insereSelectCategorias" onclick="insereSelectCategorias(); return false;">
        SELECIONAR UMA CATEGORIA
    </a>
</div>
