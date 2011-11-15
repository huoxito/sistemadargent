 
<div class="ganhos index">
    
    <div id="contentHeader">
        <h1>Categorias</h1> 
    </div>
    
    <div class="balancoBotoesWraper">
    </div>
    
    <div id="table-wrapper">

        <p class="info-tabela">
            Todas suas categorias
        </p>
         
        <table cellpadding="0" cellspacing="0" class="tabelaListagem">
            <tr>
                <th align="left">Nome</th>
                <th align="center" width="80">Ações</th>
            </tr>
            <?php foreach ($categorias as $categoria): ?>
            <tr class="registros">
                <td id="categoriaId<?= $categoria['Categoria']['id'];?>" align="left">
                    <?= $categoria['Categoria']['nome']; ?>
                </td>
                <td class="actions" style="width: 150px;">
                    <?= $this->Html->link('EDITAR',
                                array('action' => 'edit', $categoria['Categoria']['id']),
                                array('class' => 'editar-categoria btneditar',
                                      'title' => 'Editar categoria')); ?> 
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?= $this->element('sql_dump'); ?>
    </div>
    
</div>
        
<script type="text/javascript">
    $(document).ready(function () {
        
        $("a.editar-categoria").fancybox({
            'transitionIn'  :   'none',
            'transitionOut' :   'none',
            'width'         :   500,
            'height'        :   150,
            'speedIn'       :   600, 
            'speedOut'      :   200, 
            'overlayShow'   :   false,
            'type'          :   'iframe' 
        });
    });
</script>
