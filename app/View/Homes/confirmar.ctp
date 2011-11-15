
    
    <?php //echo $this->element('sql_dump'); ?>
    
    <span class="blue ajaxResponse<?= $registros['id'] ?>" style="float: left;">
        Confirmado !
    </span>
    
    <?php   echo $this->Html->link(__('CANCELAR'),
                        'javascript:;',
                        array('onclick' => "cancelar(".$registros['id'].",'".$registros['tipo']."')",
                              'class' => 'btnacoes')); ?>
    
