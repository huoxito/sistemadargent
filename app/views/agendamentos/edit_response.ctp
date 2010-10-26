<?php //echo $this->element('sql_dump');
    $class = null; ?>
        
        <td>
            <span style="display: block; margin: 10px 0 10px 10px;">
                <span style="color: <?php echo $agendamento['Agendamento']['color']; ?>; font-weight: bold;">
                    <?php echo $agendamento['Agendamento']['tipo']; ?>
                </span>
                    -
                    <?php echo $agendamento['Frequencia']['nome']; ?>
                    -
                    R$ <?php echo $agendamento['Agendamento']['valor']; ?>
                    -
                    <?php echo $agendamento['Agendamento']['categoria']; ?>
                
            </span>
            
            <div style="margin: 0 0 10px 30px;height: auto; overflow: hidden;">
            <span style="display: block; font-weight: normal;">
                <?php echo $agendamento['Agendamento']['numLancamentos']; ?> lançamentos restantes.
                À ser confirmado no dia <?php echo $agendamento['Agendamento']['vencimento']; ?>.
            </span>
            
            <span style="display: block; font-weight: normal;">
                Próximo lançamento para <span style="color:#003D4C;"><?php echo $agendamento['Agendamento']['proximoReg']; ?></span>
                <span class="registro-atualizado">Registro atualizado</span>
            </span>
            
            <?php   if( !empty($agendamento['Agendamento']['observacoes']) ){   ?>
            <span style="float: left; font-weight: normal; margin-right: 3px;">OBS: </span>   
                        <?php   echo $agendamento['Agendamento']['observacoes']; ?>
            <?php   }   ?>
            </div>
        </td>
        
        <td class="actions">
            <span style="display: block; margin: 20px 0 10px;"><?php echo $agendamento['Agendamento']['modified']; ?></span>
            <?php echo $html->link(__('Editar', true), array('action' => 'edit', $agendamento['Agendamento']['id']), array('title' => 'Editar Agendamento', 'class' => 'colorbox-edit')); ?>
            <?php echo $html->link(__('Deletar', true), array('action' => 'delete', $agendamento['Agendamento']['id']), array('title' => 'Excluir Agendamento', 'class' => 'colorbox-delete')); ?>
       
        </td>
        
        <script type="text/javascript">
            // <![CDATA[
            $(document).ready(function () {
                $('.colorbox-delete').colorbox({width:"60%", height:"280", opacity: 0.5, iframe: true});
                $('.colorbox-edit').colorbox({width:"60%", height:"500", opacity: 0.5, iframe: true});
            });
            // ]]>
        </script>
        

