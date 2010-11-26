    
    <?php //echo $this->element('sql_dump'); ?>
    
    <div>
        
        <span class="labelPainel">
            <?php   echo $label;  ?>
        </span>
        <p class="agendamentoInfoLinha">
            R$ <?= $registros[$_Model]['valor'];  ?> reais com
            <span class="agendamentoCategoria">
                <?= $registros[$_Categoria]['nome'];  ?>
            </span>
        </p>
        
    </div>
    
    <?php   if( !empty($registros[$_Model]['observacoes']) ){  ?> 
    <p class="agendamentoInfoLinha">
        <?php   echo $registros[$_Model]['observacoes'];  ?>
    </p>
    <?php   }   ?>
    
    <p class="agendamentoInfoLinha agendamentoProxLancamento">
        Registro atualizado ! 
        
        <?php   if( isset($dataAlterada) ){  ?> 
        Vencimento alterado para <?php   echo $dataAlterada;  ?></p>
        <?php   }   ?>
    </p>
    
    
    
    <div class="links-registros-calendario acoesPainel" id="acoes-<?php echo $_Model; ?>-<?php echo $registros[$_Model]['id']; ?>">
        <?php   echo $html->link(__('CANCELAR', true),
                            'javascript:;',
                            array('onclick' => "cancelar(".$registros[$_Model]['id'].",'".$_Model."')",
                                  'class' => 'btnacoes')); ?>
    </div>  
        
    <script type="text/javascript">
        // <![CDATA[
        $(document).ready(function () {
            $('.colorbox-delete').colorbox({width:"60%", height:"280", opacity: 0.5, iframe: true});
            $('.colorbox-edit').colorbox({width:"60%", height:"500", opacity: 0.5, iframe: true});
        });
        // ]]>
    </script>