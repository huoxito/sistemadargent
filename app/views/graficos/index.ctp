
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
            
            <div class="filtrosPie">
                <h2 class="graphHeaders">
                    Intervalo de data para relatório de categorias
                    <input type="text" class="filtro-data" id="pieDataInicial" value="" />
                    até 
                    <input type="text" class="filtro-data" id="pieDataFinal" value="" />
                </h2>
            </div>

            <div id="pieGanho" class="graficosPizza">
                <img src="<?= $pieGanho; ?>" title="Gastos" alt="Gastos" />
            </div>

            <div id="pieGasto" class="graficosPizza">
                <img src="<?php   echo $pieGasto; ?>" title="Ganhos" alt="Ganhos" />
            </div>

        </div>


    </div>


<?php 
    echo $this->Html->script('jquery.textareaCounter.plugin');  
    echo $this->Html->script("forms");      
?>

<script type="text/javascript">
 
$(document).ready(function () {
    
    function pad(n){
        return n < 10 ? '0' + n : n
    }
    
    var obj = new Date();
    var fim = pad(obj.getDate()) + '-' + pad(obj.getMonth()+1) + '-' + obj.getFullYear();

    obj.setDate(obj.getDate()-30);
    var inicio = pad(obj.getDate()) + '-' + pad(obj.getMonth()+1) + '-' + obj.getFullYear();
    
    $("#pieDataFinal").val(fim);
    $("#pieDataInicial").val(inicio);

    $("#pieDataInicial").datepicker({
        dateFormat: "dd-mm-yy",
    });
    
    $("#pieDataFinal").datepicker({
        dateFormat: "dd-mm-yy",
    });

    $.ajax({
        url: '/graficos/comparativo' ,
        beforeSend: function(){
            $('#graficoComparativoImg').html('<img src="/img/ajax-loader-p.gif" alt="carregando ..." />');
        },
        success: function(result){
            $('#graficoComparativoImg img').detach();
            $('#graficoComparativoImg').html(result);
        }
    });
    
    carregaPies(inicio, fim);
     
    function carregaPies(inicio, fim){
        
        $.ajax({
            url: '/graficos/pies' ,
            data: { inicio: inicio, fim: fim },
            beforeSend: function(){
                $('#pieGanho, #pieGasto').html('<img src="/img/ajax-loader-p.gif" alt="carregando ..." />');
            },
            success: function(result){

                var json = $.parseJSON(result); 
                
                $('#pieGanho img, #pieGasto img').detach();
                $('#pieGanho').html('<img src="'+json.ganho+'" alt="gráfico faturamentos" />');
                $('#pieGasto').html('<img src="'+json.gasto+'" alt="gráfico despesas" />');
            }
        });
    }
    
    $(".filtro-data").change(function(){
        
        var inicio = $('#pieDataInicial').val();
        var fim = $('#pieDataFinal').val();
        carregaPies(inicio, fim);
    }); 
     
});

</script>

