    
    <?php //echo $this->element('sql_dump'); ?>
    
    <div>
        
        <span class="labelPainel">
            <?php   echo $label;  ?>
        </span>
        <p class="agendamentoInfoLinha">
            <span class="valor">
                R$ <?= $registros[$_Model]['valor'];  ?>
            </span>
            <span class="categoriaListagem spansBlocks">
                <?= $registros[$_Categoria]['nome'];  ?>
            </span>
            <span class="contaListagem">
                <?= $registros['Conta']['nome']; ?>
            </span>
        </p>
        
    </div>
    
    <?php   if( !empty($registros[$_Model]['observacoes']) ){  ?> 
    <p class="agendamentoInfoLinha">
        <?php   echo $registros[$_Model]['observacoes'];  ?>
    </p>
    <?php   }   ?>
    
    <p class="ajaxResponseCategorias ajaxResponse<?= $registros[$_Model]['id']; ?>">
        Registro Confirmado ! 
        
        <?php   if( isset($dataAlterada) ){  ?> 
        Data da baixa: <?php   echo $dataAlterada;  ?>
        <?php   }   ?>
    </p>
    
    
    
    <div class="links-registros-calendario acoesPainel" id="acoes-<?php echo $_Model; ?>-<?php echo $registros[$_Model]['id']; ?>">
        <?php   echo $this->Html->link(__('CANCELAR'),
                            'javascript:;',
                            array('onclick' => "cancelar(".$registros[$_Model]['id'].",'".$_Model."')",
                                  'class' => 'btnacoes')); ?>
    </div>  
        
    <script type="text/javascript">
        // <![CDATA[
        $(document).ready(function () {
            $('.colorbox-delete').colorbox({width:"500", height: '220', opacity: 0.5, iframe: true});
            $('.colorbox-edit').colorbox({width:"800", height: "510", opacity: 0.5, iframe: true});
        });
        // ]]>
    </script>