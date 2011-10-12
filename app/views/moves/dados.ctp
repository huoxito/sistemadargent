
<p class="info-tabela">
    Despesas <span class="negativo">R$ <?= $despesas ?></span>
    Faturamentos <span class="positivo">R$ <?= $faturamentos ?></span> 
    Saldo <span class="<?= $classSaldo ?>">R$ <?= $saldo ?></span>
</p>
 
<table cellpadding="0" cellspacing="0" class="tabelaListagem">
    <tr>
        <th align="center">Data</th>
        <th align="left">Tipo</th>
        <th align="left">Valor</th>
        <th align="left">Conta</th>
        <th align="left">Categoria</th>
        <th align="left">Obs.</th>
        <th align="center">Ações</th>
    </tr>
    <?php foreach ($moves as $move): ?>
    <tr id="moveId<?= $move['Move']['id'];?>" class="registros<?= $move['Move']['class-status']; ?>">
        <td align="center" width="80">
            <?= $this->Time->format('d-m-Y', $move['Move']['data']); ?>
        </td>
        <td align="center" width="20" class="<?= $move['Move']['color']; ?>">
            <b><?= $move['Move']['sinal']; ?></b>
        </td>
        <td class="<?= $move['Move']['color']; ?>" width="100">
            <?= $move['Move']['valor']; ?>
        </td>
        <td class="" width="100">
            <?= $move['Conta']['nome']; ?>
        </td>
        <td width="150">
            <?= $move['Categoria']['nome']; ?>
        </td>
        <td>
            <?= $move['Move']['obs']; ?>
        </td>
        <td class="actions">
            <?= $this->Html->link('EXCLUIR', 
                            array('action' => 'delete', $move['Move']['id']),
                            array('class' => 'excluir-move btnexcluir',
                                  'title' => 'Excluir movimentação')); ?>
            <?= $this->Html->link('EDITAR',
                        array('action' => 'edit', $move['Move']['id']),
                        array('class' => 'editar-move btneditar',
                              'title' => 'Editar movimentação')); ?> 
            <?php
                if($move['Move']['status'] == 0){
                    echo  $this->Html->link('CONFIRMAR',
                                    array('action' => 'confirmar', $move['Move']['id']),
                                    array('id' => 'move-'.$move['Move']['id'].'-'.$mes.'-'.$ano,
                                          'class' => 'btnexcluir confirmar-move',
                                          'title' => 'Confirmar'));
                }
            ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<?= $this->element('sql_dump'); ?>

<script type="text/javascript">
    // <![CDATA[
    $(document).ready(function () {
        
        $("a.editar-move").fancybox({
            'transitionIn'  :   'none',
            'transitionOut' :   'none',
            'width'         :   500,
            'height'        :   500,
            'speedIn'       :   600, 
            'speedOut'      :   200, 
            'overlayShow'   :   false,
            'type'          :   'iframe' 
        });  

        $("a.excluir-move").fancybox({
            'transitionIn'  :   'none',
            'transitionOut' :   'none',
            'width'         :   500,
            'height'        :   150,
            'speedIn'       :   600, 
            'speedOut'      :   200, 
            'overlayShow'   :   false,
            'type'          :   'iframe' 
        });

        $('.confirmar-move').click(function(){
        
            var id = $(this).attr("id");
            $(this).detach();
            $.ajax({
                url: '/moves/confirmar', 
                data: ({ id: id }),
                beforeSend: function(){
                    $(this).before('<img src="/img/ajax-loader.gif" alt="... carregando dados ..." id="loading" />');
                },
                success: function(result){
                    
                    var json = $.parseJSON(result);
                    if(json.result){
                        $('.info-tabela').html(json.saldos);
                        $('#moveId'+json.id).css({'background-color': '#FFF'});
                    }else{
                        alert('Ocorreu um erro ..');
                    }
                }
            }); 
            
            return false;   
        });
    });
    // ]]>
</script>
