
    <div class="ganhos index">
    
        <div id="contentHeader">
            <h1>
                <?php echo 'Painel de lançamentos';?>
            </h1>
        </div>
        
        <div class="balancoBotoesWraper">
        <div class="balancoBotoes">
            <p>Acesse o menu <?php echo $this->Html->link('Minha Conta',
                                array('controller' => '/','action' => 'perfil'));  ?> para conferir / editar seus dados</p>
        </div>
        </div>
        
        <div class="relatoriosWraper" style="border-bottom: 1px solid #E9E9E9;">
           
            <div id="relatorioRapido">
                <h2>
                    <?php echo 'Lançamentos em um intervalo de 60 dias';?>
                </h2>
                <p style="font-size: 12px; margin: 10px 0; ">
                    - Esta interface permite que você confirme os lançamentos com apenas um click.<br />
                    - Você também editar os registros para fazer qualquer alteração e só então confirmá-los.
                </p>
            </div>
        </div>
            
        <cake:nocache>
        <?php   echo $this->Session->flash(); ?>
        </cake:nocache>
        
        
        <div class="painelWraper">
        
            <?php   if($count === 0){  ?>
                <p class="semResgistrosMsg">
                    Nenhum lançamento agendado nos próximos dias
                </p>
            <?php   } ?>
            
            
            <?php   foreach($calendario as $keyAno => $ano){  ?>
                           
                <?php   foreach($ano as $key => $mes){  ?>
                            
                    <div style="height: auto; overflow: hidden; padding-bottom: 15px; background-color: #FFF;">
                        
                        <?php if ( isset($ano[$key]['lista']) ){  ?>
                        <p style="font-size: 18px; font-family: Georgia; margin: 10px;">
                            <?php echo $key; ?> - <?php echo $keyAno; ?>
                        </p>
                        <?php   }   ?>
                        
                        <?php   foreach($mes as $keyDia => $dia){  ?>
                            
                            <?php if ( isset($dia['registros']) ){  ?>
                            
                            <ul class="list">
                            
                            <li class="registrosPorData">
                            
                                <div class="groupdata agenda">
                                    <?php echo $keyDia; ?> - <?php echo $dia['diadasemana']; ?>
                                </div>
                                  
                                <?php
                                    foreach( $dia['registros'] as $key => $registros ){
                                        $num = count($dia['registros']);
                                        $count = 1;
                                ?>
                                    
                                    <div class="registros <?php if($count < $num) echo 'borda-inferior'; ?>" id="registro-<?php echo $registros['tipo']; ?>-<?php echo $registros['id']; ?>">
                                        <div>
                                            
                                            <span style="width: 100px;display: block;float: left;"><?php   echo $registros['tipo'];  ?></span>
                                            <span style="width: 180px;display: block;float: left">
                                                R$ <?php   echo $registros['valor'];  ?>
                                            </span>
                                            <span style="">
                                            <?php   echo $registros['categoria'];  ?> 
                                            </span>
                                            
                                        </div>
                                        <?php   if( !empty($registros['obs']) ){  ?> 
                                        <p style="margin-left: 100px; width: 30%;"><?php   echo $registros['obs'];  ?></p>
                                        <?php   }   ?>
                                        
                                        
                                        <div class="links-registros-calendario" id="acoes-<?php echo $registros['tipo']; ?>-<?php echo $registros['id']; ?>">
                                        
                                            <?php   if($registros['dataFutura']){  ?>
                                            <?php   echo $this->Html->link('CONFIRMAR',
                                                                'javascript:;',
                                                                array('onclick' => 'confirmar('.$registros['id'].',\''.$registros['tipo'].'\')',
                                                                      'class' => 'btnacoes')); ?>
                                            <?php   }  ?>
                                                                      
                                            <?php   echo $this->Html->link('EDITAR',
                                                                array('action' => 'edit',$registros['id'],$registros['tipo']),
                                                                array('class' => 'colorbox-edit btneditar')
                                                                ); ?> 
                                            <?php   echo $this->Html->link('EXCLUIR',
                                                                 array('action' => 'delete',$registros['id'],$registros['tipo']),
                                                                 array('class' => 'colorbox-delete btnexcluir')
                                                                 ); ?>
                                        
                                        </div>  
                                               
                                    </div>    
                                
                                <?php    $count++;}  ?>
                                
                            </li>
                            </ul>
                            
                            <?php    }  ?>
                            
                        <?php    }  ?>
                        
                    </div>
                                
                <?php    }  ?>
                
            <?php    }  ?>  
       
        </div>
        
        
    </div>

    <script type="text/javascript">
        
        // <![CDATA[
            $(document).ready(function () {
                $('.colorbox-delete').colorbox({width:"60%", height: '220', opacity: 0.5, iframe: true});
                $('.colorbox-edit').colorbox({width:"60%", height: "530", opacity: 0.5, iframe: true});
            });
            
            $("div.registros").mouseover(function() {
                $(this).css("background-color",'#F2FFE3');
            }).mouseout(function(){
                $(this).css("background-color",'#FFF');
            });
            
            function confirmar(id, tipo){
                $.ajax({
                        url: '<?php echo $html->url(array("controller" => "homes","action" => "confirmar"));?>',
                        cache: false,
                        type: 'GET',
                        contentType: "application/x-www-form-urlencoded; charset=utf-8",
                        data: ({ tipo: tipo, id: id }),
                        beforeSend: function(){
                            $('#acoes-' + tipo + '-' + id).prepend('<div style="float: left;"><?= $this->Html->image('ajax-loader-p.gif'); ?></div>');
                        },
                        success: function(result){
                            
                            if(result == 'error'){
                                alert('Algo improvável aconteceu, por favor tente novamente');
                            }else{
                                $('#acoes-' + tipo + '-' + id).html(result);
                            }
                        }
                        
                    });
            }
            
            function cancelar(id, tipo){
                $.ajax({
                        url: '<?php echo $html->url(array("controller" => "homes","action" => "cancelar"));?>',
                        cache: false,
                        type: 'GET',
                        contentType: "application/x-www-form-urlencoded; charset=utf-8",
                        data: ({ tipo: tipo, id: id }),
                        beforeSend: function(){
                            $('#acoes-' + tipo + '-' + id).prepend('<?= $this->Html->image('ajax-loader-p.gif'); ?>');
                        },
                        success: function(result){
                        
                            if(result == 'error'){
                                alert('Algo improvável aconteceu, por favor tente novamente');
                            }else{
                                $('#acoes-' + tipo + '-' + id).html(result);
                            }
                        }
                        
                    });
            }
        // ]]>
    </script>
    
