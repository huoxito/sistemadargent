    
    <div class="gastos index">
        
        
        <div id="contentHeader">

            <?php   echo $this->element('gasto_menu');  ?>
        
            <div class="buscar">
                
                <?php
                    echo $form->create('Gasto',
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
                    echo $form->input('destino_id',
                                        array('empty' => 'Destinos',
                                              'div' => array('class' => 'formSearchDiv'),
                                              'class' => 'formSearchSelect',
                                              'selected' => isset($this->params['named']['destino_id']) ? $this->params['named']['destino_id'] : null));   
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

            <?php
                if(isset($faturamentos)){
            ?> 
                <p>Faturamento: <b><?php echo $faturamentos; ?></b></p>
                <p>Gastos: <b><?php echo $despesas; ?></b></p> 
                <p>Saldo: <b><?php echo $saldo; ?></b></p> 
            <?php
                }else{
                
                echo $total;
            ?>
                <p>|</p>
                <?php   if( !empty($groupPorData) && isset($paginator) ){    ?>
                
                <span class="pagina">Página</span>
                <p><?php echo $paginator->counter(array('format' => __('%page%',true))); ?></p>
                <span class="pagina">de</span>
                <p><?php echo $paginator->counter(array('format' => __('%pages%',true))); ?></p>
                <p>|</p>
                <p><?php echo $paginator->counter(array('format' => __('%count%',true))); ?></p>
                <span class="pagina">Registros</span>
                <?php   }   ?>
                
                <?php   }      ?>
            </p>

            <div class="renda">
                <?php echo $this->Html->image('renda.jpg',
                                        array('alt' => 'inserir categoria',
                                              'width' => '143',
                                              'height' => '19',
                                              'url' => array('controller' => 'destinos',
                                                             'action' => 'add'))); ?>
            </div>
            <div class="faturamento">
                <?php echo $this->Html->image('faturamento.jpg',
                                        array('alt' => 'inserir faturamento',
                                              'width' => '143',
                                              'height' => '20',
                                              'url' => array('controller' => 'gastos',
                                                             'action' => 'add'))); ?>
            </div>
            
        </div>
        
        </div>
        
        <div class="relatoriosWraper">
            
            <div id="relatorioRapido">
                
                <div class="titulos">
                    <h2>Relatórios <span>RÁPIDOS</span> </h2>
                </div>
                
                <ul id="mesesRelatorio">
                    <?php foreach($objMeses as $meses): ?>
                        <li>
                            <?php
                                if(isset($this->params['pass'][0]) && $this->params['pass'][0] == $meses['numMes'])
                                    echo $meses['mes'];
                                else
                                    echo $this->Html->link($meses['mes'],
                                                    array('action' => 'index',
                                                          $meses['numMes'],
                                                          $meses['ano']),
                                                    array('class' => 'relatoriosLinks'));
                            ?>
                        </li>
                    <?php endforeach; ?>    
                </ul>
            
            </div>
        
        </div>
        
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
                        <span class="valor">
                        R$ <?php  echo $registro['Gasto']['valor']; ?>
                        </span>
                        <?php echo $registro['Destino']['nome']; ?>
                    </div>
                    
                    <?php echo $registro['Gasto']['observacoes']; ?>
                    
                    <div class="linksRegistros">
                    <?php   echo $html->link('',
                                        array('action' => 'edit', $registro['Gasto']['id'], time()),
                                        array('class' => 'colorbox-edit editar')
                                        ); ?> 
                    <?php   echo $html->link('',
                                         array('action' => 'delete', $registro['Gasto']['id'], time()),
                                         array('class' => 'colorbox-delete excluir')
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
            
            $(".registros").mouseover(function() {
                $(this).css("background-color",'#F2FFE3');
            }).mouseout(function(){
                $(this).css("background-color",'#FFF');
            });
        });
        // ]]>
    </script>
    