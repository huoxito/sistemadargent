<?php

class GraficosController extends AppController{

    var $uses = array('Ganho', 'Gasto');
    var $components = array('Data','PieChart','LineChart');

    function index(){

        $objDestinosValores = $objDestinos = $objFontesValores = $objFontes = null;
        $destinos = $this->Gasto->find('all',
                                array('fields' => array('Destino.nome', 'SUM(Gasto.valor) AS total'),
                                        'conditions' =>
                                            array('Gasto.status' => 1,
                                                    'Gasto.usuario_id' => $this->Auth->user('id')),
                                        'order' => 'total DESC',
                                        'group' => array('Gasto.destino_id'),
                                        'limit' => '5'
                                ));

        foreach($destinos as $destino){

            $objDestinosValores[] = $destino[0]['total'];
            $objDestinos[] = $destino['Destino']['nome'];
            //$objDestinosCores[] = $cor;
        }

        # seto o tipo de chart e monto pie de gastos
        $this->PieChart->Chart->setProperty('cht', 'p');
        $this->PieChart->Chart->setDimensions(350,200);
        $this->PieChart->Chart->addDataSet($objDestinosValores);
        $this->PieChart->Chart->setLegend(array($objDestinos));
        $this->PieChart->Chart->setColors(array("FF1515"));
        $pieGasto = $this->PieChart->Chart->getUrl();
        $this->set('pieGasto', $pieGasto);

        $fontes = $this->Ganho->find('all',
                            array('fields' =>
                                   array('Fonte.nome', 'SUM(Ganho.valor) AS total'),
                                           'conditions' =>
                                               array('Ganho.status' => 1,
                                                       'Ganho.usuario_id' => $this->Auth->user('id')),
                                           'order' => 'total DESC',
                                           'group' => array('Ganho.fonte_id'),
                                           'limit' => '5'
                               ));

        foreach($fontes as $fonte){
            $objFontesValores[] = $fonte[0]['total'];
            $objFontes[] = $fonte['Fonte']['nome'];
            //$objDestinosCores[] = $cor;
        }
        # limpo os dados já enviados da classe e monto a outra pie
        $this->PieChart->Chart->clearDataSets();
        $this->PieChart->Chart->addDataSet($objFontesValores);
        $this->PieChart->Chart->setLegend(array($objFontes));
        $this->PieChart->Chart->setColors(array("00D500"));
        $pieGanho = $this->PieChart->Chart->getUrl();
        $this->set('pieGanho', $pieGanho);
    }

    function comparativo(){

        $mes = date('m');
        $ano = date('Y');

        for($i=0;$i<6;$i++){

            list($mes,$ano) = explode('-',date('m-Y',mktime(0,0,0,$mes,1,$ano)));

            # aproveito pra jogar no array o nome dos meses
            $meses[] = $this->Data->retornaNomeDoMes((int)$mes);

            $this->Ganho->recursive = -1;
            $ganhos[] = $this->Ganho->find('all',
                                            array('fields' => array('SUM(Ganho.valor) AS total,
                                                                    MONTH(datadabaixa) AS mes'),
                                                    'conditions' =>
                                                        array('Ganho.status' => 1,
                                                                'Ganho.usuario_id' => $this->Auth->user('id'),
                                                                'MONTH(Ganho.datadabaixa)' => $mes,
                                                                'YEAR(Ganho.datadabaixa)' => $ano,
                                                            ),
                                                    ));
            $this->Gasto->recursive = -1;
            $gastos[] = $this->Gasto->find('all',
                                            array('fields' => array('SUM(Gasto.valor) AS total,
                                                                    MONTH(datadabaixa) AS mes'),
                                                    'conditions' =>
                                                        array('Gasto.status' => 1,
                                                                'Gasto.usuario_id' => $this->Auth->user('id'),
                                                                'MONTH(Gasto.datadabaixa)' => $mes,
                                                                'YEAR(Gasto.datadabaixa)' => $ano,
                                                            ),
                                                    ));
            $mes--;
        }

        foreach($ganhos as $ganho){
            if( empty($ganho[0][0]['total']) ){
                $ganho[0][0]['total'] = 0;
            }
            $ganhoValores[] = $ganho[0][0]['total'];
            $valorMaximo[] = $ganho[0][0]['total'];
        }
        foreach($gastos as $gasto){
            if( empty($gasto[0][0]['total']) ){
                $gasto[0][0]['total'] = 0;
            }
            $gastoValores[] = $gasto[0][0]['total'];
            $valorMaximo[] = $gasto[0][0]['total'];
        }

        # inverto a ordem das keys dos arrays
        krsort($ganhoValores);
        krsort($gastoValores);
        krsort($meses);
        arsort($valorMaximo);
        # pego o valor mais alto entre os ganhos e gastos
        list($valorMaisAlto) = array_slice($valorMaximo,0,1);

        # tudo isso pra arrendodar um valor, exemplo 1345->1000
        $intervalos = $valorMaisAlto/8;
        $intervalosInt = (int)$intervalos;
        $intervalosStr = (string)$intervalosInt;
        $intervalosStr = strlen($intervalosStr)-1;
        $intervalos = round($intervalos,-$intervalosStr);

        $valorMaisAlto = $valorMaisAlto + $intervalos;

        $this->LineChart->Chart->setProperty('cht', 'lc');
        $this->LineChart->Chart->setDimensions(750,250);
        $this->LineChart->Chart->clearDataSets();
        $this->LineChart->Chart->addDataSet($gastoValores);
        $this->LineChart->Chart->addDataSet($ganhoValores);
        $this->LineChart->Chart->setLegend(array('Despesas', 'Faturamentos'));
        $this->LineChart->Chart->setColors(array('D50000', '00D500'));
        $this->LineChart->Chart->setVisibleAxes(array('x','y'));
        $this->LineChart->Chart->setDataRange(0,$valorMaisAlto);
        //$this->LineChart->Chart->setAxisRange(1,436,1610);
        $this->LineChart->Chart->setLegendPosition('t');
        // axisnr, from, to, step
        $this->LineChart->Chart->addAxisRange(1,0,$valorMaisAlto,$intervalos);
        $this->LineChart->Chart->addAxisLabel(0,$meses);
        $this->LineChart->Chart->setGridLines(100,10,4,0);
        $graficoComparativo = $this->LineChart->Chart->getImgCode();

        if(empty($valorMaisAlto)){
            $graficoComparativo = false;
        }
        $this->set('graficoComparativo',$graficoComparativo);

        $this->layout = 'ajax';
    }
}
?>

