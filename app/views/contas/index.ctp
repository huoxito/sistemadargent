

<div class="contas index">
    
    <div id="contentHeader">
        <h1><?php __('Contas');?></h1>
    </div>
    
    <div class="balancoBotoesWraper">

        <div class="balancoBotoes">
            <p>
                O saldo dessas contas são alterados com as entradas das movimentações.
            </p>            
            <div class="headeraddlinks">
                <?php echo $this->Html->link('TRANSFERÊNCIAS',
                                    array('controller' => 'contas',
                                          'action' => 'transfer'),
                                    array('class' => 'transfer-conta btnadd')); ?>
            </div> 
            <div class="headeraddlinks">
                <?php echo $this->Html->link('CRIAR UMA NOVA CONTA',
                                    array('controller' => 'contas',
                                          'action' => 'add'),
                                    array('class' => 'add-conta btnadd',
                                          'title' => 'Criar uma nova conta')); ?>
            </div>
        </div>
        
    </div>
    
    <div id="table-wrapper">
        
        <p class="info-tabela">
            Saldo total 
            R$ <span id="saldo-Total" class="<?= $class ?>"><?= $this->Valor->formata($total); ?></span>
        </p>
         
        <table cellpadding="0" cellspacing="0" class="tabelaListagem">
            <tr>
                <th align="left">Nome</th>
                <th align="left">Saldo</th>
                <th align="left">Tipo</th>
                <th align="center">Ações</th>
            </tr>
            <?php foreach ($contas as $conta): ?>
            <tr id="contaId<?= $conta['Conta']['id'];?>" class="registros">
                <td>
                    <?= $conta['Conta']['nome']; ?>
                </td>
                <td id="contaSaldo<?= $conta['Conta']['id'] ?>">
                    R$ <?= $this->Valor->formata($conta['Conta']['saldo']); ?>
                </td>
                <td class="tipo">
                    <?= $conta['Conta']['tipo']; ?>
                </td>
                <td class="actions">
                    <?php 
                    if($conta['Conta']['delete']){ 
                        echo $this->Html->link('DELETE', 
                                    array('action' => 'delete', $conta['Conta']['id']),
                                    array('class' => 'delete-conta btnexcluir',
                                          'title' => 'Excluir Conta')); 
                    }
                    ?>
                    <?= $this->Html->link('EDITAR',
                                array('action' => 'edit', $conta['Conta']['id']),
                                array('class' => 'edit-conta btneditar',
                                      'title' => 'Editar Conta')); ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        
    </div>

</div>

<script type="text/javascript">
    
    $(document).ready(function () {
        
        $("a.edit-conta, a.transfer-conta, a.add-conta").fancybox({
            'transitionIn'  :   'none',
            'transitionOut' :   'none',
            'width'         :   500,
            'height'        :   340,
            'speedIn'       :   600, 
            'speedOut'      :   200, 
            'overlayShow'   :   false,
            'type'          :   'iframe' 
        });
        
        $("a.delete-conta").fancybox({
            'transitionIn'  :   'none',
            'transitionOut' :   'none',
            'width'         :   500,
            'height'        :   130,
            'speedIn'       :   600, 
            'speedOut'      :   200, 
            'overlayShow'   :   false,
            'type'          :   'iframe' 
        });
        
    });

</script>

