

<div class="contas index">
    
    <div id="contentHeader">
        <h1><?php __('Contas');?></h1>
    </div>
    
    <div class="balancoBotoesWraper">

        <div class="balancoBotoes">
            
            <div class="headeraddlinks">
                <?php echo $this->Html->link('CRIAR UMA NOVA CONTA',
                                    array('controller' => 'contas',
                                          'action' => 'add'),
                                    array('class' => 'btnadd')); ?>
            </div>
        </div>
        
    </div>
    
    <?php echo $this->Session->flash(); ?>
    
    <div class="registrosWraper">
            
        <table cellpadding="0" cellspacing="0" class="tabelaListagem">
            <tr>
                <th>Nome</th>
                <th>Saldo</th>
                <th>Tipo</th>
                <th>Criada</th>
                <th colspan="2">Modificada</th>
            </tr>
            <?php foreach ($contas as $conta): ?>
            <tr id="">
                <td>
                    <?= $conta['Conta']['nome']; ?>
                </td>
                <td>
                    R$ <?= $this->Valor->formata($conta['Conta']['saldo']); ?>
                </td>
                <td>
                    <?= $conta['Conta']['tipo']; ?>
                </td>
                <td>
                    <?= $this->Data->formata($conta['Conta']['created']); ?>
                </td>
                <td>
                    <?= $this->Data->formata($conta['Conta']['modified']); ?>
                </td>
                <td class="actions">
                    <?= $this->Html->link('EDITAR',
                                array('action' => 'edit', $conta['Conta']['id']),
                                array('class' => 'btneditar',
                                      'title' => 'Editar Faturamento')); ?> 
                    <?= $this->Html->link('Delete', array('action' => 'delete', $conta['Conta']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $conta['Conta']['id'])); ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        
    </div>

</div>

<script type="text/javascript">
    // <![CDATA[
    $(document).ready(function () {
        $('.colorbox-delete').colorbox({width:"500", height: '220', opacity: 0.5, iframe: true});
        $('.colorbox-edit').colorbox({width:"800", height: "420", opacity: 0.5, iframe: true});
        
        $(".registros").mouseover(function() {
            $(this).css("background-color",'#F2FFE3');
        }).mouseout(function(){
            $(this).css("background-color",'#FFF');
        });
    });
    // ]]>
</script>

