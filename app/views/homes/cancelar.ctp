
    
    <?php //echo $this->element('sql_dump'); ?>
    
    <?php   echo $html->link(__('CONFIRMAR', true),
                        'javascript:;',
                        array('onclick' => 'confirmar('.$registros['id'].',\''.$registros['tipo'].'\')',
                              'class' => 'btnacoes')); ?>
                        
    <?php   echo $html->link(__('EDITAR', true),
                        array('action' => 'edit',$registros['id'],$registros['tipo']),
                        array('class' => 'colorbox-edit btneditar')
                        ); ?> 
    
    <?php   echo $html->link(__('EXCLUIR', true),
                         array('action' => 'delete',$registros['id'],$registros['tipo']),
                         array('class' => 'colorbox-delete btnexcluir')
                         ); ?>
    
    <script type="text/javascript">
        // <![CDATA[
        $(document).ready(function () {
            $('.colorbox-delete').colorbox({width:"500", height: '200', opacity: 0.5, iframe: true});
            $('.colorbox-edit').colorbox({width:"800", height: "450", opacity: 0.5, iframe: true});
        });
        // ]]>
    </script>