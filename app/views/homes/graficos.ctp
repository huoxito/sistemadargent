
    <div class="graficos index">
        
        <div id="contentHeader">    
            <h1>
                <?php __('Relatórios gráficos');?>
            </h1>
        </div>
        
        <div class="balancoBotoesWraper">

            <div class="balancoBotoes">
                <p>Gráfico Comparativo das entradas e saídas e das respectivas categorias</p>
            </div>
        
        </div>
        
        <div id="graficosWraper">

            <div id='graficoComparativo' style="height: auto: overflow: hidden; text-align: center; ">
                <h2 style="padding: 10px 0;">Comparativo nos últimos 7 meses</h2>
                <?php echo $graficoComparativo; ?>
            </div>
            
            <div class="graficosPizza">
                
                <h2>Faturamentos</h3>
                
                <img src="<?php   echo $pieGanho; ?>" title="Gastos" alt="Gastos" />
            </div>
                
            <div class="graficosPizza">
                <h2>Despesas</h3>
                <img src="<?php   echo $pieGasto; ?>" title="Ganhos" alt="Ganhos" />
                
            </div>  
        
        </div>
        
        
    </div>
    
    
    
