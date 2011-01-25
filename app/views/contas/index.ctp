

<div class="contas index">
    
    <div id="contentHeader">
        <h1><?php __('Contas');?></h1>
    </div>
    
    <div class="balancoBotoesWraper">

        <div class="balancoBotoes">
            <p>
                O saldo nessas contas mudam de acordo com a adição ou edição 
                de faturamentos e despesas.
            </p>            
            <div class="headeraddlinks">
                <?php echo $this->Html->link('CRIAR UMA NOVA CONTA',
                                    array('controller' => 'contas',
                                          'action' => 'add'),
                                    array('class' => 'colorbox-add btnadd')); ?>
            </div>
        </div>
        
    </div>
    
    <?php echo $this->Session->flash(); ?>
    
    <div class="tableWraper">
            
        <table cellpadding="0" cellspacing="0" class="tabelaListagem">
            <?php foreach ($contas as $conta): ?>
            <tr id="contaId<?= $conta['Conta']['id'];?>" class="registros">
                <td>
                    <?= $conta['Conta']['nome']; ?>
                </td>
                <td>
                    R$ <?= $conta['Conta']['saldo'] ?>
                </td>
                <td class="tipo">
                    <?= $conta['Conta']['tipo']; ?>
                </td>
                <td class="actions">
                    <?= $this->Html->link('EDITAR',
                                array('action' => 'edit', $conta['Conta']['id']),
                                array('class' => 'colorbox-edit btneditar',
                                      'title' => 'Editar Conta')); ?> 
                    <?php 
                    if($conta['Conta']['delete']){ 
                        echo $this->Html->link('DELETE', 
                                    array('action' => 'delete', $conta['Conta']['id']),
                                    array('class' => 'colorbox-delete btnexcluir',
                                          'title' => 'Excluir Conta')); 
                    }
                    ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        
    </div>

</div>

<script type="text/javascript">
    
    $(document).ready(function () {
        
        $('.colorbox-delete').colorbox({width:"500", height: '180', opacity: 0.5, iframe: true});
        $('.colorbox-edit, .colorbox-add').colorbox({width:"800", height: "420", opacity: 0.5, iframe: true});
    });

</script>

