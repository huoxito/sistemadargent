    
    
    <div class="fontes index">
        
        <div id="contentHeader">    
            <?php   echo $this->element('fonte_menu'); ?>
        </div>
        
        
        <div class="balancoBotoesWraper">

            <div class="balancoBotoes">
                
                <?php if(count($fontes)){ ?>
                <p><?= count($fontes) ?></p>
                <span class="pagina">categorias para os Faturamentos</span>
                <?php }else{ ?>
                <span class="pagina">Nenhuma categoria encontrada</span>
                <?php } ?>
                
                <div class="headeraddlinks">
                    <?php echo $this->Html->link('INSERIR FATURAMENTO',
                                        array('controller' => 'ganhos',
                                              'action' => 'add'),
                                        array('class' => 'btnadd')); ?>
                </div>
                <div class="headeraddlinks">
                    <?php echo $this->Html->link('INSERIR NOVA FONTE',
                                        array('controller' => 'fontes',
                                              'action' => 'add'),
                                        array('class' => 'btnadd')); ?>
                </div>
                
            </div>
            
        </div>
        
        <div class="relatoriosWraper">
            <div id="relatorioRapido">
                <p class="painelHelp">
                    - Só podem ser excluídas as Fontes que não possuem relação com qualquer registro.<br />
                    - Ao desativar as categorias que não são mais relevantes, você impede que elas apareçam como opção ao inserir um Faturamento. 
                </p>
            </div>
        
        </div>
        
        <cake:nocache>
        <?php   echo $this->Session->flash(); ?>
        <cake:nocache>
        
        <div class="categoriasWraper">
            <div class="categorias">
            
                <?php   if(count($porcentagens) === 0){  ?>
                    <p class="semResgistrosMsg">
                        Nenhuma categoria registrada
                    </p>
                <?php   } ?>
            
                <ul id="list-categorias">
                <?php
                foreach ($porcentagens as $key => $porcentagem):
        
                ?>
                    <li id="fonte-<?php echo $fontes[$key]['Fonte']['id']; ?>" class="registros">
                        <div class="categoriaInfo" id="info<?= $fontes[$key]['Fonte']['id']; ?>">
                            
                            <div class="" style="height:auto; overflow:hidden;	padding: 5px 0;">
                                
                                <span class="categoria_nome" id="nome-<?php echo $fontes[$key]['Fonte']['id']; ?>">
                                    <?php echo $fontes[$key]['Fonte']['nome']; ?>
                                </span>
                                
                                <span class="valor">
                                    <?php echo $fontes[$key]['Fonte']['porcentagem']; ?> %
                                </span>
                            </div>
                            
                            <div style="clear: both;">
                                <?php if( isset($fontes[$key]['Ganho']) ){   ?>
                                Última interação: R$ <?php echo $fontes[$key]['Ganho']['valor']; ?> em <?php echo $fontes[$key]['Ganho']['datadabaixa']; ?>
                                <?php }else{   ?>
                                Não há registros relacionados a essa categoria
                                <?php } ?>
                            </div>                            
                            
                        </div>
                        <div class="categ-actions" id="actions<?= $fontes[$key]['Fonte']['id']; ?>">
                            
                            <?= $this->Html->link('EDITAR',
                                            array('action' => 'edit', $fontes[$key]['Fonte']['id'], time()),
                                            array('class' => 'colorbox-edit btneditar',
                                                  'title' => 'Editar Fonte'));   ?>
                                            
                            <span id='linkStatus<?= $fontes[$key]['Fonte']['id']; ?>'>
                            
                            <?php   if($fontes[$key]['Fonte']['status']){   ?>
                                <?= $this->Html->link('DESATIVAR',
                                                '#javascript:;',
                                                array('class' => 'btnexcluir',
                                                      'onclick' => 'mudarStatus('.$fontes[$key]['Fonte']['id'].',0)')); ?>
                            <?php   }else{   ?>
                                <?= $this->Html->link('ATIVAR',
                                                '#javascript:;',
                                                array('class' => 'btneditar',
                                                      'onclick' => 'mudarStatus('.$fontes[$key]['Fonte']['id'].',1)')); ?>
                            
                            <?php   }   ?>
                            
                            </span>
                            
                            <?php if( !isset($fontes[$key]['Ganho']) ){   ?>
                                <?= $this->Html->link('EXCLUIR',
                                                array('action' => 'delete', $fontes[$key]['Fonte']['id'], time()),
                                                array('class' => 'colorbox-delete btnexcluir',
                                                      'title' => 'Excluir Fonte'));    ?>
                            <?php } ?>
                        </div>
                    </li>
        
                <?php endforeach; ?>
                </ul>
            </div> 
        </div>
        
    </div>
    
    <script type="text/javascript">
    
        $(document).ready(function () {
            
            $('.colorbox-delete').colorbox({width:"500", height: '180', opacity: 0.5, iframe: true});
            $('.colorbox-edit').colorbox({width:"500", height: "220", opacity: 0.5, iframe: true});
            
            $("li.registros").mouseover(function() {
                $(this).css("background-color",'#F2FFE3');
            }).mouseout(function(){
                $(this).css("background-color",'#FFF');
            });
            
        });
        
        function mudarStatus(id,action){
            $.ajax({
                url: '<?php echo $this->Html->url(array("controller" => "fontes","action" => "mudarStatus"));?>',
                data: ({ id: id, action: action}),
                beforeSend: function(){
                    $('#actions'+id).prepend('<?= $this->Html->image('ajax-loader-p.gif'); ?>');
                },
                success: function(result){
                    var json = $.parseJSON(result);
                    $('#info'+id+' .ajaxResponseCategorias').detach();
                    $('#linkStatus'+id).html(json.link);
                    $('#info'+id).append(json.msg);
                    $('#fonte-'+id).append(json.sql);
                    $('#actions'+id+' img').detach();
                }
            });
        }
                
    </script>
