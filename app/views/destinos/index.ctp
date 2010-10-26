    <div class="destinos index">
        
        <?php   echo $this->element('destino_menu'); ?>
        <?php   echo $this->Session->flash(); ?>
        
        
        
        <p id="paginator-info">
        <?php
            if(isset($numRegistros)){
                echo ''.$numRegistros.' categorias de despesas. Listadas com a porcentagem em relação a todo o seu faturamento registrado.';
            }   
            //echo $paginator->counter(array('format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)));
        ?></p>
        
        <ul id="list-categorias">       
        <?php

        foreach ($porcentagens as $key => $porcentagem):
        ?>
            <li id="destino-<?php echo $destinos[$key]['Destino']['id']; ?>" class="registros">
                <div style="height: auto; overflow: hidden;">
                    <div style="float: left;"><?php echo $destinos[$key]['Destino']['porcentagem']; ?> % « </div>
                    <span class="categoria_nome" id="nome-<?php echo $destinos[$key]['Destino']['id']; ?>">
                        <?php echo $destinos[$key]['Destino']['nome']; ?>
                    </span>

                    <div style="float: right;"><?php echo $destinos[$key]['Destino']['modified']; ?></div>
                    
                    <div style="clear: both;">
                        <?php if( isset($destinos[$key]['Gasto']) ){   ?>
                        Última interação: R$ <?php echo $destinos[$key]['Gasto']['valor']; ?> em <?php echo $destinos[$key]['Gasto']['datadabaixa']; ?>
                        <?php }else{   ?>
                        Não há registros relacionados a essa categoria
                        <?php } ?>
                    </div>                            
                    
                </div>
                <div class="categ-actions">
                    <?php
                        echo $html->link(__('Editar', true),
                                            array('action' => 'edit', $destinos[$key]['Destino']['id'], time()),
                                            array('class' => 'colorbox-edit')
                                            ); 
                        echo $html->link(__('Deletar', true),
                                            array('action' => 'delete', $destinos[$key]['Destino']['id'], time()),
                                            array('class' => 'colorbox-delete')
                                            );
                    ?>
                </div>
            </li>

        <?php endforeach; ?>
        </ul>  
        
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
    

