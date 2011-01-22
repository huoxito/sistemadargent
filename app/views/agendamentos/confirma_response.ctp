

<span class="tipoAgendamentoLabel">
    <?= $label; ?>
</span>

<div class="agendamentoInfo agendamentoInfo<?= $item['Agendamento']['id']; ?>">
    
    <p class="agendamentoInfoLinha">
        <span class="valorAgenda<?php echo $item['Agendamento']['id']; ?>">
            R$ <?= $item['Agendamento']['valor']; ?>
        </span> reais 
        com
        <span class="agendamentoCategoria categoria<?php echo $item['Agendamento']['id']; ?>">
            <?= $item['Agendamento']['categoria']; ?>
        </span> 
    </p>
    
    <?php if( !empty($item['Frequencia']['nome']) ){  ?>
    <p class="agendamentoInfoLinha">
        Frequência das parcelas:
        <span class="agendamentoFrequencia"><?= $item['Frequencia']['nome']; ?></span>.
        
        <?php   if ( $item['Agendamento']['numLancamentos'] > 0 ){ ?>
        Restando <span class="agendamentoFrequência"><?= $item['Agendamento']['numLancamentos'] ?></span> lançamentos.
        <?php   } ?>
    </p>
    <?php } ?>
    
    <p class="agendamentoInfoLinha">
        <span class="agendamentoProxLancamento">
            Registro confirmado e migrado para a interface de <?= $label ?>s
        </span>
    </p>    
    
    <?php if( isset($item['Agendamento']['proxLancamento']) && $item['Agendamento']['proxLancamento'] ){  ?>
    <p class="agendamentoInfoLinha">
        
        Próximo lançamento para:
        <span class="agendamentoProxLancamento">
            <?= $item['Agendamento']['proximoReg']; ?>
        </span>
        
        <?= $this->Html->link('CONFIRMAR',
                    array('action' => 'confirmaLancamento',
                          $item['Agendamento']['proximoRegId'],
                          $item['Agendamento']['model'],
                          time()),
                    array('class' => 'btnacoes confirmaAgendamento',
                          'title' => 'Confirmar lançamento')); ?>
        
    </p>
    
    <?php }else{ ?>
    <p class="agendamentoInfoLinha agendamentoProxLancamento">
        Agendamento concluído
    </p>
    <?php } ?>
    
    <?php   if( !empty($item['Agendamento']['observacoes']) ){   ?>
    <p class="agendamentoInfoLinha Observacoes<?php echo $item['Agendamento']['id']; ?>">
        Observações: <?= $item['Agendamento']['observacoes']; ?>
    </p> 
    <?php   }   ?>

</div>

<?php if( isset($item['Agendamento']['proxLancamento']) && $item['Agendamento']['proxLancamento'] ){  ?>
<div class="categ-actions" style="margin-top: -45px;">
    <?php
        echo $this->Html->link('',
                        array('action' => 'edit',
                              $item['Agendamento']['id'],time()),
                        array('title' => 'Editar Agendamento',
                              'class' => 'colorbox-edit editar'));
        echo $this->Html->link('',
                        array('action' => 'delete',
                              $item['Agendamento']['id']),
                        array('title' => 'Excluir Agendamento',
                              'class' => 'colorbox-delete excluir'));
    ?>
</div>
<?php   }   ?>


<?php //echo $this->element('sql_dump'); ?>
                
                
<script type="text/javascript">
    // <![CDATA[
    $(document).ready(function () {
        $('.colorbox-delete').colorbox({width:"60%", height:"200", opacity: 0.5, iframe: true});
        $('.colorbox-edit').colorbox({width:"60%", height:"500", opacity: 0.5, iframe: true});
        $('.confirmaAgendamento').colorbox({width:"600", height:"300", opacity: 0.5, iframe: true});
    });
    // ]]>
</script>