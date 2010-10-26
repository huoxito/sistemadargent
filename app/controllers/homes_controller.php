<?php

class HomesController extends AppController{
    
    var $uses = array('Ganho', 'Gasto');  
    var $components = array('Valor', 'Data', 'PieChart','LineChart');

    /*
    var $cacheAction = array(
        'index' => '1 hour'
    );
    */
    
    function index(){
        

        $inicial    = date('Y-m-d 00:00:00');
        $final      = $this->Data->somaDias(date('Y-m-d H:i:s'), 30, 2, '-');
        
        $this->Ganho->recursive = 0;
        $ganhos = $this->Ganho->find('all',
                            array('conditions' =>
                                       array('Ganho.status' => 0,
                                           'Ganho.usuario_id' => $this->Auth->user('id'),
                                           'Ganho.datadevencimento BETWEEN ? AND ?' => array($inicial, $final)),
                                  'limit' => '30',
                                  'order' => array('Ganho.datadevencimento' => 'asc', 'Ganho.modified' => 'asc')
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
        
        
        $Mes = $this->Data->retornaNomeDoMes(date('m'));
        $mesNumerico = date('m');
        $Dia = date('d');
        $Ano = date('Y');
        $ultimoDiaDoMes = $this->Data->retornaUltimoDiaDoMes($mesNumerico,$Ano);
        for($i=0;$i<30;$i++){
            
            $Dia = str_pad($Dia, 2, 0, STR_PAD_LEFT);
            $dataCalendario = $Ano.'-'.$mesNumerico.'-'.$Dia;
            $calendario[$Ano][$Mes][$Dia] = array(//'dia' => $Dia,
                                                'diadasemana' => $this->Data->formata($dataCalendario,'diadasemana'));
            
            
            foreach($ganhos as $item){
                
                if($item['Ganho']['datadevencimento'] === $dataCalendario ){
                    $calendario[$Ano][$Mes]['lista'] = true;
                    $calendario[$Ano][$Mes][$Dia]['registros'][] =
                                    array('data' => $this->Data->formata($item['Ganho']['datadevencimento'],'porextenso'),
                                          'tipo' => 'Ganho',
                                          'valor' => $item['Ganho']['valor'],
                                          'categoria' => $item['Fonte']['nome'],
                                          'id' => $item['Ganho']['id'],
                                          'obs' => $item['Ganho']['observacoes']);         
                }
            }
            
            foreach($gastos as $item){
                
                if($item['Gasto']['datadevencimento'] === $dataCalendario ){
                    $calendario[$Ano][$Mes]['lista'] = true;
                    $calendario[$Ano][$Mes][$Dia]['registros'][] =
                                    array('data' => $this->Data->formata($item['Gasto']['datadevencimento'],'porextenso'),
                                          'tipo' => 'Gasto',
                                          'valor' => $item['Gasto']['valor'],
                                          'categoria' => $item['Destino']['nome'],
                                          'id' => $item['Gasto']['id'],
                                          'obs' => $item['Gasto']['observacoes']);
                }
            }
            
            if($Dia == $ultimoDiaDoMes){
                
                $Dia = 1;
                if($mesNumerico === 12){
                    $mesNumerico = 1;
                    $Ano = $Ano + 1;
                }else{
                    $mesNumerico = $mesNumerico + 1;
                }
                $Mes = $this->Data->retornaNomeDoMes($mesNumerico);
                $ultimoDiaDoMes = $this->Data->retornaUltimoDiaDoMes($mesNumerico,$Ano);
            }else{
                $Dia++;
            }
            
        }
        
        $this->set(compact('calendario'));
        
        //echo '<pre>';
        //print_r($calendario);
        //echo '</pre>';
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
        
        # seto o tipo de chart e monto pie de ganhos
        $this->PieChart->Chart->setProperty('cht', 'p');
        $this->PieChart->Chart->setDimensions(350,200);
        $this->PieChart->Chart->addDataSet($objDestinosValores);
        $this->PieChart->Chart->setLegend(array($objDestinos));
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
        $this->LineChart->Chart->setColors(array('ED237A', 'FFF000'));
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
              
                $chk = $this->$_Model->read(null, $this->params['url']['id']);
                # permissao
                if($chk[$_Model]['usuario_id'] != $this->Auth->user('id')){
                    echo 'error'; exit;
                }else{
                    
                    $this->$_Model->id = $this->params['url']['id'];
                    $dados[$_Model] = array('datadabaixa' => date('d-m-Y'),
                                            'status' => 1);
                    if($this->$_Model->save($dados)){
                        
                        if($_Model == 'Ganho'){
                            $_Categoria = 'Fonte';
                        }else{
                            $_Categoria = 'Destino';
                        }
                        
                        $registros = array('id' => $chk[$_Model]['id'],
                                           'categoria' => $chk[$_Categoria]['nome'],
                                           'valor' => $chk[$_Model]['valor'],
                                           'tipo' => $_Model,
                                           'obs' => $chk[$_Model]['observacoes']
                                           );
                        
                        $this->set(compact('registros'));
                        $this->layout = 'ajax';
                    }else{
                        echo 'error';   exit;
                    }
                }
            }
        }
        //$this->autoRender = false;
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
        
        
        if (!$id && empty($this->data)) {
            $this->redirect(array('action'=>'index'));
        }
        
        if( !$_Model && isset($this->params['url']['tipo']) ){
            $_Model = $this->params['url']['tipo'];
        }
        
        if($_Model == 'Ganho'){
            $_Categoria = 'Fonte';
            $categorias = 'fontes';
            $categoriaId = 'fonte_id';
        }else if ($_Model == 'Gasto'){
            $_Categoria = 'Destino';
            $categorias = 'destinos';
            $categoriaId = 'destino_id';
        }else{
            $this->redirect('error404');
        }
        
        $this->data = $this->$_Model->read(null, $id);
        
        # permissão do usuário
        $this->checkPermissao($this->data[$_Model]['usuario_id']);
        
        $this->data[$_Model]['datadevencimento'] = $this->Data->formata($this->data[$_Model]['datadevencimento'], 'diamesano');
        $categorias = $this->$_Model->$_Categoria->find('list',
                                            array('conditions' =>
                                                  array('status' => 1,
                                                        'usuario_id' => $this->Auth->user('id')))
                                            );
        $this->set(array('fontes' => $categorias, 'destinos'=> $categorias));
        $this->set('_Model',$_Model);
        $this->set('id',$id);
        $this->layout = 'colorbox';
        
    }
    
    # acao pode editar ou confirmar o registro
    function editResponse(){
        
        if( $this->params['isAjax'] ){
            
            $_Model = $this->params['url']['tipo'];
            if($_Model == 'Ganho'){
                $_Categoria = 'Fonte';
                $categorias = 'fontes';
                $categoriaId = 'fonte_id';
            }else if ($_Model == 'Gasto'){
                $_Categoria = 'Destino';
                $categorias = 'destinos';
                $categoriaId = 'destino_id';
            }else{
                $this->redirect('error404');
            }
            
            $chk = $this->$_Model->read(array($_Model.'.usuario_id',
                                            $_Model.'.datadevencimento as data'),$this->params['url']['id']);
            # permissão do usuário
            if( $this->checkPermissao($chk[$_Model]['usuario_id'],true) ){ 
                
                $item[$_Model] = array('valor' => $this->params['url']['valor'],
                                        'observacoes' => $this->params['url']['obs'],
                                        $categoriaId => $this->params['url']['categoria']);
                
                
                if( $this->params['url']['action'] == 'editar' ){
                    $item[$_Model]['datadevencimento'] = $this->Data->formata($this->params['url']['data'],'diamesano');
                }else{
                    $item[$_Model]['status'] = 1;
                    $item[$_Model]['datadabaixa'] = $this->params['url']['data'];
                    if($this->Data->comparaDatas(date('d-m-Y'),$item[$_Model]['datadabaixa'])){
                        // ok
                    }else{
                        echo 'data';    exit;
                    }
                }
                
                $this->$_Model->id = $this->params['url']['id'];
                if ($this->$_Model->save($item)) {
                    $resposta = $this->$_Model->find('first',
                                array (
                                    'fields' => array($_Model.'.valor',
                                                      $_Model.'.observacoes',
                                                      $_Model.'.id',
                                                      $_Categoria.'.nome'),
                                    'conditions' => array($_Model.'.id' => $this->params['url']['id'])
                                    ));
                    
                    $this->set('_Categoria',$_Categoria);
                    $this->set('_Model',$_Model);
                    $this->set('registros',$resposta);
                    
                    # se usuário alterar a data exibo data alterada
                    $dataAntiga = $this->Data->formata($chk[$_Model]['data'],'diamesano');
                    if( $this->params['url']['data'] != $dataAntiga ){
                        $dataAlterada = $this->Data->formata($this->params['url']['data'],'mesextenso');
                        $this->set('dataAlterada',$dataAlterada);
                    }
                    
                    if( $this->params['url']['action'] === 'confirmar' ){
                        $this->render('confirm_response');
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
        }
    }
    
    function cancelar(){
        
        if($this->params['isAjax']){
            
            $_Model = $this->params['url']['tipo'];
            if( $_Model != 'Ganho' && $_Model != 'Gasto' ){
                echo 'error'; exit;
            }else{
              
                $chk = $this->$_Model->read(null, $this->params['url']['id']);
                # permissao
                if($chk[$_Model]['usuario_id'] != $this->Auth->user('id')){
                    echo 'error';   exit;
                }else{
                    
                    $this->$_Model->id = $this->params['url']['id'];
                    $dados[$_Model] = array('datadabaixa' => null,
                                            'status' => 0);
                    if($this->$_Model->save($dados, false)){
                        
                        if($_Model == 'Ganho'){
                            $_Categoria = 'Fonte';
                        }else{
                            $_Categoria = 'Destino';
                        }
                        
                        $registros = array('id' => $chk[$_Model]['id'],
                                           'categoria' => $chk[$_Categoria]['nome'],
                                           'valor' => $chk[$_Model]['valor'],
                                           'tipo' => $_Model,
                                           'vencimento' => $chk[$_Model]['datadevencimento'],
                                           'obs' => $chk[$_Model]['observacoes']
                                           );
                        
                        $this->set(compact('registros'));
                        $this->layout = 'ajax';
                        //exit;
                    }else{
                        echo 'error';   exit;
                    }
                }
            }
        }
    }

}
?>