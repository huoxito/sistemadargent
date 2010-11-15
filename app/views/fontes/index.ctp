    
    
    <div class="fontes index">
        
        <div id="contentHeader">    
            <?php   echo $this->element('fonte_menu'); ?>
            <?php   echo $this->Session->flash(); ?>
        </div>
        
        
        <div class="balancoBotoesWraper">

            <div class="balancoBotoes">
                <?php if(isset($numRegistros)){ ?>
                    <?php echo $numRegistros; ?> Categorias listadas
                <?php }   ?>
                
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
                                        array('class' => 'btnaddcategoria')); ?>
                </div>
                
            </div>
            
        </div>
        
        <ul id="list-categorias">
        <?php
        foreach ($porcentagens as $key => $porcentagem):

        ?>
            <li id="fonte-<?php echo $fontes[$key]['Fonte']['id']; ?>" class="registros">
                <div style="height: auto; overflow: hidden;">
                    
                    <div class="" style="height:auto; overflow:hidden;	padding: 5px 0;">
                        
                        <span class="categoria_nome" id="nome-<?php echo $fontes[$key]['Fonte']['id']; ?>">
                            <?php echo $fontes[$key]['Fonte']['nome']; ?>
                        </span>
                        
                        <span class="valor">
                            <?php echo $fontes[$key]['Fonte']['porcentagem']; ?> %
                        </span>
                    </div>

                    <div style="float: right;margin-top:-23px;">
                        <?php echo $fontes[$key]['Fonte']['modified']; ?>
                    </div>
                    
                    <div style="clear: both;">
                        <?php if( isset($fontes[$key]['Ganho']) ){   ?>
                        Última interação: R$ <?php echo $fontes[$key]['Ganho']['valor']; ?> em <?php echo $fontes[$key]['Ganho']['datadabaixa']; ?>
                        <?php }else{   ?>
                        Não há registros relacionados a essa categoria
                        <?php } ?>
                    </div>                            
                    
                </div>
                <div class="categ-actions">
                    <?php
                        echo $html->link('',
                                            array('action' => 'edit', $fontes[$key]['Fonte']['id'], time()),
                                            array('class' => 'colorbox-edit editar')
                                            ); 
                        echo $html->link('',
                                            array('action' => 'delete', $fontes[$key]['Fonte']['id'], time()),
                                            array('class' => 'colorbox-delete excluir')
                                            );
                    ?>
                </div>
            </li>

        <?php endforeach; ?>
        </ul>
        <!--
        <div class="paging">
            <?php //echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
         | 	<?php //echo $paginator->numbers();?>
            <?php //echo $paginator->next(__('next', true).' >>', array(), null, array('class' => 'disabled'));?>
        </div>    
        -->
        
    </div>
    
    <script type="text/javascript">
        $(document).ready(function () {
            
            $('.colorbox-delete').colorbox({width:"60%", height: '220', opacity: 0.5, iframe: true});
            $('.colorbox-edit').colorbox({width:"60%", height: "300", opacity: 0.5, iframe: true});
            
            $("li.registros").mouseover(function() {
                $(this).css("background-color",'#F2FFE3');
            }).mouseout(function(){
                $(this).css("background-color",'#FFF');
            });
            
        });
                
    </script>
    
    
    
    
    

