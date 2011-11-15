


<div id="selectCategoria" class="input text required">
    <label>Categoria</label>
    <?= $this->Form->select('Move.categoria_id',
                        $categorias,
                        false,
                        array('empty' => 'Escolha uma categoria',
                              'div' => false)); ?>
    <a href="#" class="btnadd" title="inserir" id="insereInputCategorias" onclick="insereInputCategorias(); return false;">
        INSERIR NOVA CATEGORIA
    </a>
</div>
