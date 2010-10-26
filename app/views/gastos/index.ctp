    
    <div class="gastos index">
        
        <?php   echo $this->element('gasto_menu');  ?>
        
        <div class="filters" style="">
            
            <?php
                echo $form->create('Gasto',
                                    array('type' => 'get',
                                          'action' => 'search',
                                          'inputDefaults' => array('label' => false, 'div' => false)));  
                
                echo $form->input('observacoes',
                                    array('style' => 'float: left;width: 180px; padding: 6px; height: 16px; margin: 1px 5px 0 0;',
                                          'maxlength' => '50',
                                          'default' => isset($this->params['named']['observacoes']) ? $this->params['named']['observacoes'] : null
                                          ));   
                
                echo $form->input('destino_id',
                                    array('empty' => 'Destinos',
                                          'selected' => isset($this->params['named']['destino_id']) ? $this->params['named']['destino_id'] : null));
                
                echo $form->month(false,
                                    isset($this->params['named']['month']) ? $this->params['named']['month'] : null,
                                    array(__('monthNames',true), 'empty' => 'Mês'));
                
                echo $form->year(false,
                                    $minYear = '2010',
                                    $maxYear = '2010',
                                    isset($this->params['named']['year']) ? $this->params['named']['year'] : null,
                                    array('empty' => 'Ano'));  
                
                echo $form->submit('Buscar',
                                    array('div' => false, 'class' => 'submit'));  
                
                echo $form->end();
            ?>
            
        </div>
        
        
        <cake:nocache>
        <?php   echo $this->Session->flash(); ?>
        </cake:nocache>
        
        
        <div class="ganhos info">
            <?php   if(!isset($listar)) echo '« '.$html->link('voltar a listagem inicial', array('action' => 'index'), array('class' => 'link_headers'));?>
            <?php   echo '<span style="font-weight: bold;">'.$total.'</span>';    ?>
        </div>
        
        <ul id="relatorio_rapido">
                <li>Relátorios rápidos</li>
            <?php foreach($objMeses as $meses): ?>
                <li>
                    <?php
                        if(isset($this->params['pass'][0]) && $this->params['pass'][0] == $meses['numMes'])
                            echo $meses['mes'];
                        else
                            echo $html->link($meses['mes'], array('action' => 'index', $meses['numMes'],  $meses['ano']));
                    ?>
                </li>
            <?php endforeach; ?>    
        </ul>
        
        <?php   if( !empty($groupPorData) && isset($paginator) ){    ?>
        
        <p  id="paginator-info">
        <?php
            $paginator->counter(array('format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)));
        ?></p>
        
        <?php   }   ?>
        
        <ul id="list">
            <?php
                    foreach($groupPorData as $data){
                    $num = count($data['registro']);
                    $count = 1;
            ?>
            
            <li class="registrosPorData">
                <div class="groupdata">
                <?php  echo $data['dia']; ?>
                </div>
                
                <?php   foreach($data['registro'] as $registro){  ?>
                
                <div class="registros <?php if($count < $num) echo 'borda-inferior'; ?>" id="gasto-<?php echo $registro['Gasto']['id']; ?>">
                    
                    <div class="">
                        R$ <?php  echo $registro['Gasto']['valor']; ?>  «
                        <?php echo $registro['Destino']['nome']; ?>
                    </div>
                    
                        <?php echo $registro['Gasto']['observacoes']; ?>
                        <div class="links-registros">
                        <?php   echo $html->link(__('Editar', true),
                                            array('action' => 'edit', $registro['Gasto']['id'], time()),
                                            array('class' => 'colorbox-edit')
                                            ); ?> 
                        <?php   echo $html->link(__('Deletar', true),
                                             array('action' => 'delete', $registro['Gasto']['id'], time()),
                                             array('class' => 'colorbox-delete')
                                             ); ?>
                        </div>  
                    
                        
                </div>
                <?php   $count++;}   ?>
            </li>
            
            <?php   }   ?>
        </ul>
        
        <?php   if( !empty($groupPorData) && isset($paginator) ){    ?>
        <div class="paging">
            <?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
         | 	<?php echo $paginator->numbers();?>
         |  <?php echo $paginator->next(__('next', true).' >>', array(), null, array('class' => 'disabled'));?>
        </div>
        <?php   }   ?>
        
    </div>
    
    <script type="text/javascript">
        // <![CDATA[
        $(document).ready(function () {
            $('.colorbox-delete').colorbox({width:"60%", height: '220', opacity: 0.5, iframe: true});
            $('.colorbox-edit').colorbox({width:"60%", height: "530", opacity: 0.5, iframe: true});
        });
        // ]]>
    </script>
    