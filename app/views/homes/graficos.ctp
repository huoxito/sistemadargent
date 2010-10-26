
    <div class="gastos index">
        
        <h2><?php __('Relatórios gráficos');?></h2>
        <!--<p>Iaaaewww <?php echo $session->read('Auth.Usuario.nome'); ?> !</p>-->
        
        <?php   echo $this->Session->flash(); ?>
        
        <div id='graficoComparativo' style="height: auto: overflow: hidden;clear:both;">
            <?php echo $graficoComparativo; ?>
        </div>
        
        
        <div style="height: auto: overflow: hidden;float:left;margin: 20px 0 0 20px;">
        <h3>Faturamentos</h3>
        
        <img src="<?php   echo $pieGanho; ?>" title="Gastos" alt="Gastos" />
        </div>
        
        <div style="height: auto: overflow: hidden;float:left; margin: 20px 0 0 20px;">
        <h3>Despesas</h3>
        <img src="<?php   echo $pieGasto; ?>" title="Ganhos" alt="Ganhos" />
        </div>
        
    </div>
    
    
    
