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
    <p style="margin-left: 100px; "><?php   echo $registros[$_Model]['observacoes'];  ?></p>
    <?php   }   ?>
    
    <p style="margin-left: 100px; " class="registro-atualizado">
        <?php   if( isset($dataAlterada) ){  ?> 
        Data da baixa: <?php   echo $dataAlterada;  ?></p>
        <?php   }   ?>
    </p>
    
    
    <div class="links-registros-calendario" id="acoes-<?php echo $_Model; ?>-<?php echo $registros[$_Model]['id']; ?>">
        <span class="registro-atualizado">
            Confirmado
        </span>
        <?php   echo $html->link(__('Cancelar', true),
                            'javascript:;',
                            array('onclick' => 'confirmar('.$registros[$_Model]['cancelar'].',\''.$registros[$_Model]['cancelar'].'\')')); ?>
    </div>  