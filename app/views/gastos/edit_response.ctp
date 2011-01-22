    
    <?php //echo $this->element('sql_dump'); ?>

    <p class="agendamentoInfoLinha">
        R$ <?php  echo $registro['Gasto']['valor']; ?>  reais com
        <span class="agendamentoCategoria">
        <?php echo $categoria; ?>
        </span>
    </p>
    
    <?php   if(!empty($registro['Gasto']['observacoes'])){ ?>
    <p class="agendamentoInfoLinha">
        <?php echo $registro['Gasto']['observacoes']; ?>
    </p>
    <?php   }   ?>
    
    <p class="ajaxResponseCategorias">
        Registro atualizado !
        <?php   if( isset($dataAlterada) ){ ?>
            Data alterada para <?php echo $dataAlterada; ?>
        <?php   }   ?>
    </p>
    
    <div class="categ-actions acoesPainel">
        <?= $this->Html->link('EDITAR',
                            array('action' => 'edit', $registro['Gasto']['id'], time()),
                            array('class' => 'colorbox-edit btneditar',
                                  'title' => 'Editar Despesa')); ?> 
        <?= $this->Html->link('EXCLUIR',
                            array('action' => 'delete', $registro['Gasto']['id'], time()),
                            array('class' => 'colorbox-delete btnexcluir',
                                  'title' => 'Excluir Despesa')); ?>
    </div>  
    
    <script type="text/javascript">
        // <![CDATA[
        $(document).ready(function () {
            $('.colorbox-delete').colorbox({width:"500", height: '220', opacity: 0.5, iframe: true});
            $('.colorbox-edit').colorbox({width:"800", height: "430", opacity: 0.5, iframe: true});
        });
        // ]]>
    </script>