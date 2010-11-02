    
    <?php  //$js->get('.headers')->event('click', '$(this).toggle()');    ?>
    
    <div class="ganhos index">
        
        <div id="contentHeader">
            
            <?php   echo $this->element('ganho_menu'); ?>
            
            <div class="buscar">
                
                <?php
                    echo $form->create('Ganho',
                                            array('type' => 'get',
                                                  'action' => 'search',
                                                  'inputDefaults' => array('label' => false)));   
                ?>
                <span>Buscar</span>
                <p>FATURAMENTOS</p>
                
                
                <?php
                    /*
                    echo $form->input('observacoes',
                                        array('style' => 'float: left;width: 180px; padding: 6px; height: 16px; margin: 1px 5px 0 0;',
                                              'maxlength' => '50',
                                              'default' => isset($this->params['named']['observacoes']) ? $this->params['named']['observacoes'] : null
                                              ));   
                    */
                    echo $form->input('fonte_id',
                                        array('empty' => 'Fontes',
                                              'div' => array('class' => 'formSearchDiv'),
                                              'class' => 'formSearchSelect',
                                              'selected' => isset($this->params['named']['fonte_id']) ? $this->params['named']['fonte_id'] : null));   
                ?>
                <div class="formSearchDiv">
                <?php
                    echo $form->month(false,
                                        isset($this->params['named']['month']) ? $this->params['named']['month'] : null,
                                        array(__('monthNames',true),
                                              'empty' => 'Mês',
                                              'class' => 'formSearchSelect'));
                ?>
                </div>
                <div class="formSearchDiv">
                <?php
                    echo $form->year(false,
                                        $minYear = '2010',
                                        $maxYear = '2010',
                                        isset($this->params['named']['year']) ? $this->params['named']['year'] : null,
                                        array('empty' => 'Ano',
                                              'class' => 'formSearchSelect'));
                ?>
                </div>
                <input type="image" value="" class="botao" />

            </div>
            
        </div>
        
        
            
        <cake:nocache>
        <?php   echo $this->Session->flash(); ?>
        </cake:nocache>
        
        <div style="height: auto; overflow: hidden;padding:10px 0;width:100%;background-color:#e9ffcc;">
            
        
        <div class="balancoBotoes">
            <p>
            <?php
                if(!isset($listar)){
                    echo '« '.$html->link('voltar a listagem inicial', array('action' => 'index'), array('class' => 'link_headers'));
                }
            ?>
            <?php   echo ''.$total.'';    ?>
            </p>
            <!--
            <p>Faturamento:</p><b>R$ 00,00</b>
            <p>Gastos:</p> <b>R$ 00,00</b>
            <p>Saldo:</p> <b>R$ 00,00</b>
            -->
            <p>|</p>
            <span class="pagina">Página</span>
            <p><?php echo $paginator->counter(array('format' => __('%page%',true))); ?></p>
            <span class="pagina">de</span>
            <p><?php echo $paginator->counter(array('format' => __('%pages%',true))); ?></p>
            <p>|</p>
            <p><?php echo $paginator->counter(array('format' => __('%end%',true))); ?></p>
            <span class="pagina">Registros</span>
            
            <div class="renda"><a href="#"><img src="<?php echo $html->url('/'); ?>img/renda.jpg" width="143" height="19" /></a></div>
            <div class="faturamento"><a href="#"><img src="<?php echo $html->url('/'); ?>img/faturamento.jpg" width="143" height="20" /></a></div>
        </div>
        
        </div>
        
        <div class="ganhos info">
        <?php
            if(!isset($listar)){
                echo '« '.$html->link('voltar a listagem inicial', array('action' => 'index'), array('class' => 'link_headers'));
            }
        ?>
        <?php   echo '<span style="font-weight: bold; color: #000;">'.$total.'</span>';    ?>
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
        <p id="paginator-info">
            <?php
            $paginator->counter(array(
            'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
            ));
            ?>
        </p>
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
                
                <div class="registros <?php if($count < $num) echo 'borda-inferior'; ?>" id="ganho-<?php echo $registro['Ganho']['id']; ?>">
                
                    <div class="">
                        R$ <?php  echo $registro['Ganho']['valor']; ?>  «
                        <?php echo $registro['Fonte']['nome']; ?>
                    </div>
                    
                    <?php echo $registro['Ganho']['observacoes']; ?>
                    
                    <div class="links-registros">
                    <?php   echo $html->link(__('Editar', true),
                                            array('action' => 'edit', $registro['Ganho']['id'], time()),
                                            array('class' => 'colorbox-edit')
                                            ); ?> 
                    <?php   echo $html->link(__('Deletar', true),
                                             array('action' => 'delete', $registro['Ganho']['id'], time()),
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