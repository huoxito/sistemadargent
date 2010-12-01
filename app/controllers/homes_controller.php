<?php

class HomesController extends AppController{
    
    var $uses = array('Ganho', 'Gasto');  
    var $components = array('Valor', 'Data', 'PieChart','LineChart');

    function index(){
        
        $inicial = date('Y-m-d', mktime(0,0,0,date('m'),date('d')-30,date('Y')));
        $final = date('Y-m-d', mktime(0,0,0,date('m'),date('d')+30,date('Y')));
        
        $this->Ganho->recursive = 0;
        $ganhos = $this->Ganho->find('all',
                            array('conditions' =>
                                       array('Ganho.status' => 0,
                                             'Ganho.usuario_id' => $this->Auth->user('id'),
                                             'Ganho.datadevencimento BETWEEN ? AND ?' => array($inicial, $final)),
                                  'limit' => '30',
                                  'order' => array('Ganho.datadevencimento' => 'asc')
                                  ));
        
        $this->Gasto->recursive = 0;
        $gastos = $this->Gasto->find('all',
                            array('conditions' =>
                                       array('Gasto.status' => 0,
                                               'Gasto.usuario_id' => $this->Auth->user('id'),
                                               'Gasto.datadevencimento BETWEEN ? AND ?' => array($inicial, $final)),
                                  'limit' => '30',
                                  'order' => array('Gasto.datadevencimento' => 'asc', 'Gasto.modified' => 'asc')
                                  ));
        
        $dataInicial = date('Y-m-d', mktime(0,0,0,date('m')-1,date('d'),date('Y')));
        list($Ano,$mesNumerico,$Dia) = explode('-',$dataInicial);
        $count = 0;
        for($i=0;$i<60;$i++){
            
            $Dia = str_pad($Dia, 2, 0, STR_PAD_LEFT);
            $dataNoLoop = date('Y-m-d', mktime(0,0,0,$mesNumerico,$Dia,$Ano));
            list($Ano,$mesNumerico,$Dia) = explode('-',$dataNoLoop);
            $dataCalendario = $Ano.'-'.$mesNumerico.'-'.$Dia;
            $Mes = $this->Data->retornaNomeDoMes($mesNumerico);
            $dataMaxima = $this->Data->comparaDatas(date('d-m-Y'),$Dia.'-'.$mesNumerico.'-'.$Ano);
            
            $calendario[$Ano][$Mes][$Dia] = array(//'dia' => $Dia,
                                                'diadasemana' => $this->Data->formata($dataCalendario,'diadasemana'));
            
            foreach($ganhos as $item){
                
                if($item['Ganho']['datadevencimento'] === $dataCalendario ){
                    $calendario[$Ano][$Mes]['lista'] = true;
                    $calendario[$Ano][$Mes][$Dia]['registros'][] =
                                    array('data' => $this->Data->formata($item['Ganho']['datadevencimento'],'porextenso'),
                                          'tipo' => 'Ganho',
                                          'label' => 'Faturamento',
                                          'valor' => $item['Ganho']['valor'],
                                          'categoria' => $item['Fonte']['nome'],
                                          'id' => $item['Ganho']['id'],
                                          'obs' => $item['Ganho']['observacoes'],
                                          'dataFutura' => $dataMaxima);         
                    $count++;
                }
            }
            
            foreach($gastos as $item){
                
                if($item['Gasto']['datadevencimento'] === $dataCalendario ){
                    $calendario[$Ano][$Mes]['lista'] = true;
                    $calendario[$Ano][$Mes][$Dia]['registros'][] =
                                    array('data' => $this->Data->formata($item['Gasto']['datadevencimento'],'porextenso'),
                                          'tipo' => 'Gasto',
                                          'label' => 'Despesa',
                                          'valor' => $item['Gasto']['valor'],
                                          'categoria' => $item['Destino']['nome'],
                                          'id' => $item['Gasto']['id'],
                                          'obs' => $item['Gasto']['observacoes'],
                                          'dataFutura' => $dataMaxima);
                    $count++;
                }
            }

            $Dia++;
        }
        
        $this->set(compact('count'));
        $this->set(compact('calendario'));
    }
    
    function graficos(){
        
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
        
        if( date('m')==1 ){
            $mes = 12;
            $ano = date('Y')-1;
        }else{
            $mes = date('m')-1;
            $ano = date('Y');
        }
        
        for($i=0;$i<6;$i++){
            
            if($mes == 0){
                $mes = 12;
                $ano = $ano - 1;
            }
            # aproveito pra jogar no array o nome dos meses
            $meses[] = $this->Data->retornaNomeDoMes($mes);
            
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
        $this->set('graficoComparativo',$graficoComparativo);
        
    }

    function ultimoMes(){
        
        $mesAnterior = date('m')-1;
        if($mesAnterior==0) $mesAnterior = 12;
        
        ###### GASTOS DO ÚLTIMO MÊS
        $gastosUltimoMes = $this->Gasto->find('all',
                                    array('fields' => 'SUM(valor) AS total',
                                          'conditions' =>
                                                array("MONTH(Gasto.datadabaixa)" => $mesAnterior,
                                                      'Gasto.status' => 1,
                                                      'Gasto.usuario_id' => $this->Auth->user('id')),
                                                        )
                                              );
        $totalGastoULtimoMes = $this->Valor->formataValor($gastosUltimoMes[0][0]['total'],2);         
        
        ###### GANHOS DO ÚLTIMO MÊS
        $ganhosULtimoMes = $this->Ganho->find('all',
                                        array('fields' => 'SUM(valor) AS total',
                                              'conditions' =>
                                                    array("MONTH(Ganho.datadabaixa)" => $mesAnterior,
                                                          'Ganho.usuario_id' => $this->Auth->user('id')))
                                              );
        
        $totalGanhoULtimoMes = $this->Valor->formataValor($ganhosULtimoMes[0][0]['total'],2);
        return array('gastos' => $totalGastoULtimoMes, 'ganhos' => $totalGanhoULtimoMes);  
    }
    
    
    function confirmar(){
        
        if($this->params['isAjax']){
            
            $_Model = $this->params['url']['tipo'];
            if( $_Model != 'Ganho' && $_Model != 'Gasto' ){
                echo 'error';
            }else{
                
                $this->$_Model->Behaviors->detach('Modifiable');
                $chk = $this->$_Model->find('first', array('conditions' => array($_Model.'.id' => $this->params['url']['id'])));
                # permissao
                if($chk[$_Model]['usuario_id'] != $this->Auth->user('id')){
                    echo 'error'; exit;
                }else{
                    
                    $this->$_Model->id = $this->params['url']['id'];
                    $dados[$_Model] = array('datadabaixa' => $chk[$_Model]['datadevencimento'],'status' => 1);
                    if($this->$_Model->save($dados, false,array('datadabaixa','status'))){

                        $registros = array('id' => $chk[$_Model]['id'],'tipo' => $_Model);
                        $this->set(compact('registros'));
                        $this->layout = 'ajax';
                    }else{
                        echo 'error';   exit;
                    }
                }
            }
        }
    }
    
    
    function delete($id = null,$_Model = null) {
        
        if( !$id && isset($this->params['url']['id']) ){
            $id = (int)$this->params['url']['id'];
        }
        if( !$_Model && isset($this->params['url']['tipo']) ){
            $_Model = $this->params['url']['tipo'];
        }
        
        if($_Model == 'Ganho'){
            $_Categoria = 'Fonte';
        }else if ($_Model == 'Gasto'){
            $_Categoria = 'Destino';
        }else{
            $this->redirect('error404');
        }
        
        $itens = $this->$_Model->read(array($_Model.'.id',
                                            $_Model.'.usuario_id',
                                            $_Model.'.valor',
                                            $_Model.'.datadevencimento',
                                            $_Model.'.observacoes',
                                            $_Categoria.'.nome'), $id);
        
        # permissão do usuário
        $this->checkPermissao($itens[$_Model]['usuario_id']);
        
        if( $this->params['isAjax'] ){
        
            if ($this->$_Model->delete($id)) {
                echo 'deleted';
            }   
            $this->autoRender = false;
        
        }else{
            
            $itens[$_Model]['datadevencimento'] = $this->Data->formata($itens[$_Model]['datadevencimento'],'porextenso');
            
            $this->set('_Categoria',$_Categoria);
            $this->set('_Model',$_Model);
            $this->set('itens',$itens);    
            $this->layout = 'colorbox';
        }
    }
    
    
    function edit($id = null, $_Model = null){

        if ( !$id || ($_Model !== 'Ganho' && $_Model !== 'Gasto' )) {
            $this->cakeError('error404');
        }

        $this->data = $this->$_Model->read(null, $id);
        $this->checkPermissao($this->data[$_Model]['usuario_id']);
        
        if($_Model === 'Ganho'){
            $_Categoria = 'Fonte';
            $categorias = 'fontes';
            $categoriaId = 'fonte_id';
            $this->data[$_Model]['label'] = 'Faturamento';
        }else{
            $_Categoria = 'Destino';
            $categorias = 'destinos';
            $categoriaId = 'destino_id';
            $this->data[$_Model]['label'] = 'Despesa';
        }
        
        $this->data[$_Model]['vencimento'] = $this->Data->formata($this->data[$_Model]['datadevencimento'], 'diamesano');
        if( $this->Data->comparaDatas(date('d-m-Y'),$this->data[$_Model]['vencimento']) ){
            $this->data[$_Model]['datainicial'] = $this->data[$_Model]['vencimento'];
            $this->data[$_Model]['dataAmigavel'] = $this->Data->formata($this->data[$_Model]['datadevencimento'],'longadescricao');
        }else{
            $this->data[$_Model]['datainicial'] = date('d-m-Y');
            $this->data[$_Model]['dataAmigavel'] = $this->Data->formata(date('Y-m-d'),'longadescricao');
        }
        
        $categorias = $this->$_Model->$_Categoria->find('list',
                                            array('conditions' =>
                                                  array('status' => 1,
                                                        'usuario_id' => $this->Auth->user('id'))));
        $this->set(array('fontes' => $categorias, 'destinos'=> $categorias));
        $this->set('_Model',$_Model);
        $this->set('id',$id);
        $this->layout = 'colorbox';
    }
    
    
    function editResponse(){
        
        if( $this->params['isAjax'] ){
            
            $_Model = $this->params['url']['tipo'];
            if($_Model == 'Ganho'){
                $label = 'Faturamento';
                $_Categoria = 'Fonte';
                $categoriaId = 'fonte_id';
            }else if ($_Model == 'Gasto'){
                $label = 'Despesa';
                $_Categoria = 'Destino';
                $categoriaId = 'destino_id';
            }else{
                echo 'error'; exit;
            }
            
            $chk = $this->$_Model->find('first', array('conditions' => array($_Model.'.id' => $this->params['url']['id'])));
            # permissão do usuário
            if( $this->checkPermissao($chk[$_Model]['usuario_id'],true) ){ 
                
                $item[$_Model] = array('valor' => $this->params['url']['valor'],
                                       'observacoes' => $this->params['url']['obs'],
                                       $categoriaId => $this->params['url']['categoria'],
                                       'datadabaixa' => $this->params['url']['data'],
                                       'status' => 1);
                
                if(!$this->Data->comparaDatas(date('d-m-Y'),$this->params['url']['data'])){
                    echo 'validacao';    exit;
                }
                
                $this->$_Model->id = $this->params['url']['id'];
                if ($this->$_Model->save($item)) {
                    $resposta = $this->$_Model->find('first',
                                array ('conditions' => array($_Model.'.id' => $this->params['url']['id'])));
                    
                    $this->set('_Categoria',$_Categoria);
                    $this->set('_Model',$_Model);
                    $this->set('registros',$resposta);
                    $this->set('label',$label);
                    # se usuário alterar a data exibo data alterada
                    $dataAntiga = $this->Data->formata($chk[$_Model]['datadevencimento'],'diamesano');
                    if( $this->params['url']['data'] != $dataAntiga ){
                        $dataAlterada = $this->Data->formata($this->params['url']['data'],'mesextenso');
                        $this->set('dataAlterada',$dataAlterada);
                    }
                    
                    $this->layout = 'ajax';
                }else{
                    
                    echo 'validacao';
                    $this->autoRender = false;
                }
            }else{
                
                # registro não pertence ao usuário
                echo 'error';   
                $this->autoRender = false;
            }
        }else{
            $this->cakeError('error404');
        }
    }
    
    function cancelar(){
        
        if($this->params['isAjax']){
            
            $_Model = $this->params['url']['tipo'];
            if( $_Model != 'Ganho' && $_Model != 'Gasto' ){
                echo 'error'; exit;
            }else{
              
                $chk = $this->$_Model->find('first', array('conditions' => array($_Model.'.id' => $this->params['url']['id'])));
                # permissao
                if($chk[$_Model]['usuario_id'] != $this->Auth->user('id')){
                    echo 'error';   exit;
                }else{
                    
                    $this->$_Model->id = $this->params['url']['id'];
                    $dados[$_Model] = array('datadabaixa' => null,'status' => 0);
                    if($this->$_Model->save($dados, false,array('datadabaixa','status'))){
                        
                        $registros = array('id' => $chk[$_Model]['id'],'tipo' => $_Model,);
                        $this->set(compact('registros'));
                        $this->layout = 'ajax';
                    }else{
                        echo 'error';   exit;
                    }
                }
            }
        }
    }

}
?>