    <div>
        
        <span style="width: 100px;display: block;float: left;"><?php   echo $_Model;  ?></span>
        <span style="width: 180px;display: block;float: left">
            R$ <?php   echo $registros[$_Model]['valor'];  ?>
        </span>
        <span style="">
        <?php   echo $registros[$_Categoria]['nome'];  ?> 
        </span>
        
    </div>
    
    <?php   if( !empty($registros[$_Model]['observacoes']) ){  ?> 
    <p style="margin-left: 100px;"><?php   echo $registros[$_Model]['observacoes'];  ?></p>
    <?php   }   ?>
    
    <p style="margin-left: 100px;" class="registro-atualizado">
        Registro atualizado ! 
        
        <?php   if( isset($dataAlterada) ){  ?> 
        Vencimento alterado para <?php   echo $dataAlterada;  ?></p>
        <?php   }   ?>
    </p>
    
    
    <div class="links-registros-calendario" id="acoes-<?php echo $_Model; ?>-<?php echo $registros[$_Model]['id']; ?>">
        <?php   echo $html->link(__('CONFIRMAR', true),
                            'javascript:;',
                            array('onclick' => 'confirmar('.$registros[$_Model]['id'].',\''.$_Model.'\')',
                                  'class' => 'btnacoes')); ?>
        <?php   echo $html->link(__('EDITAR', true),
                            array('action' => 'edit',$registros[$_Model]['id'],$_Model),
                            array('class' => 'colorbox-edit btneditar')
                            ); ?> 
        <?php   echo $html->link(__('DELETAR', true),
                             array('action' => 'delete',$registros[$_Model]['id'],$_Model),
                             array('class' => 'colorbox-delete btnexcluir')
                             ); ?>
    </div>  
        
    <script type="text/javascript">
        // <![CDATA[
        $(document).ready(function () {
            $('.colorbox-delete').colorbox({width:"60%", height:"280", opacity: 0.5, iframe: true});
            $('.colorbox-edit').colorbox({width:"60%", height:"500", opacity: 0.5, iframe: true});
        });
        // ]]>
    </script>