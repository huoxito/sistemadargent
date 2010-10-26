
    
    <?php //echo $this->element('sql_dump'); ?>
    
    <?php   echo $html->link(__('Confirmar', true),
                        'javascript:;',
                        array('onclick' => 'confirmar('.$registros['id'].',\''.$registros['tipo'].'\')')); ?>
                        
    <?php   echo $html->link(__('Editar', true),
                        array('action' => 'edit',$registros['id'],$registros['tipo']),
                        array('class' => 'colorbox-edit')
                        ); ?> 
    
    <?php   echo $html->link(__('Deletar', true),
                         array('action' => 'delete',$registros['id'],$registros['tipo']),
                         array('class' => 'colorbox-delete')
                         ); ?>
    
    <script type="text/javascript">
        // <![CDATA[
        $(document).ready(function () {
            $('.colorbox-delete').colorbox({width:"60%", height:"280", opacity: 0.5, iframe: true});
            $('.colorbox-edit').colorbox({width:"60%", height:"500", opacity: 0.5, iframe: true});
        });
        // ]]>
    </script>