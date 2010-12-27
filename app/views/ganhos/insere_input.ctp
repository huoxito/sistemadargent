

<div id="inputCategoria" class="input text required">
    <?= $this->Form->input('Fonte.nome',
                        array('label' => 'Fonte',
                              'div' => false)); ?>
    <a href="javascript:;" title="cadastrar fonte" class="btnadd" onclick="insereSelectFontes();">SELECIONAR UMA FONTE</a>
</div>