
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
                <h2 class="graphHeaders">Comparativo nos últimos 7 meses</h2>
                <div id="graficoComparativoImg">

                </div>
            </div>

            <div class="graficosPizza">

                <h2 class="graphHeaders">Faturamentos</h2>
                <img src="<?= $pieGanho; ?>" title="Gastos" alt="Gastos" />
            </div>

            <div class="graficosPizza">
                <h2 class="graphHeaders">Despesas</h2>
                <img src="<?php   echo $pieGasto; ?>" title="Ganhos" alt="Ganhos" />

            </div>

        </div>


    </div>

<script type="text/javascript">

$(document).ready(function () {

    $.ajax({
        url: '<?php echo $this->Html->url(array("controller" => "graficos","action" => "comparativo"));?>',
        beforeSend: function(){
            $('#graficoComparativoImg').html('<?= $this->Html->image('ajax-loader-p.gif'); ?>');
        },
        success: function(result){
            $('#graficoComparativoImg img').detach();
            $('#graficoComparativoImg').html(result);
        }
    });

});

</script>

