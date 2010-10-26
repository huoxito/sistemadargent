    
    
    <div class="fontes index">
        
        <?php   echo $this->element('fonte_menu'); ?>
        
        <?php   echo $this->Session->flash(); ?>
        
        <p id="paginator-info">
        <?php
            if(isset($numRegistros)){
                echo ''.$numRegistros.' categorias de faturamentos. Listadas com a porcentagem em relação a todo o seu faturamento registrado.';
            }            
            //echo $paginator->counter(array('format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)));
        ?></p>
        
        <ul id="list-categorias">
        <?php
        foreach ($porcentagens as $key => $porcentagem):

        ?>
            <li id="fonte-<?php echo $fontes[$key]['Fonte']['id']; ?>" class="registros">
                <div style="height: auto; overflow: hidden;">
                    <div style="float: left;"><?php echo $fontes[$key]['Fonte']['porcentagem']; ?> % « </div>
                    <span class="categoria_nome" id="nome-<?php echo $fontes[$key]['Fonte']['id']; ?>">
                        <?php echo $fontes[$key]['Fonte']['nome']; ?>
                    </span>

                    <div style="float: right;"><?php echo $fontes[$key]['Fonte']['modified']; ?></div>
                    
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
                        echo $html->link(__('Editar', true),
                                            array('action' => 'edit', $fontes[$key]['Fonte']['id'], time()),
                                            array('class' => 'colorbox-edit')
                                            ); 
                        echo $html->link(__('Deletar', true),
                                            array('action' => 'delete', $fontes[$key]['Fonte']['id'], time()),
                                            array('class' => 'colorbox-delete')
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
                $(this).css("background-color",'#FFF9EF');
            }).mouseout(function(){
                $(this).css("background-color",'#FFF');
            });
            
        });
                
    </script>
    
    
    
    
    

