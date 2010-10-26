    <?php //echo $this->element('sql_dump'); ?>

    <div class="">
    R$ <?php  echo $registro['Gasto']['valor']; ?>  «
        <?php echo $registro['Destino']['nome']; ?>
        <span class="registro-atualizado">Registro atualizado</span>
        
        <?php   if( isset($dataAlterada) ){ ?>
        <span class="registro-atualizado">
            Data alterada para <?php echo $dataAlterada; ?>
        </span>
        <?php   }   ?>
    </div>
    
    <?php echo $registro['Gasto']['observacoes']; ?>
    
    <div class="links-registros">
    <?php   echo $html->link(__('Editar', true),
                        array('action' => 'edit', $registro['Gasto']['id']),
                        array('class' => 'colorbox-edit')
                        ); ?> 
    <?php   echo $html->link(__('Deletar', true),
                         array('action' => 'delete', $registro['Gasto']['id']),
                         array('class' => 'colorbox-delete')
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