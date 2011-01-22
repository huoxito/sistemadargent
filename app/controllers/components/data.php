<?php

class DataComponent extends Object {
    
    var $name = 'Data';
    
    function retornaNomeDoMes($numero=0){
        
        $mes = array(1=>"Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"); 
        return $mes[$numero];
    }
    
    function listaUltimosMeses($numMeses=null, $mesExcluido=null, $anoExcluido=null){
        
        # LOOP PARA PEGAR OS 5 ÚLTIMOS MESES
        //if(!isset($numMeses)) $numMeses = 5; else $numMeses = $numMeses;
       
        $voltaAno = 0; 
        $m = 0;
        while($m<=$numMeses){
            
            $numMes = date('n')-$m;
            $ano = date('Y');
            
            if(!empty($voltaAno)){
                $numMes = $numMes+($voltaAno*12);     
            }
            
            if($numMes==0){
                $numMes = 12; $voltaAno++;  # INCREMENTO CADA VEZ QUE O ANO MUDA
            }       
            
            if(!empty($voltaAno)) $ano = date('Y')-$voltaAno;  
            
            #   LISTO TODOS INCLUSIVE O MÊS SELECIONADO
            //if($numMes != $mesExcluido || $ano != $anoExcluido){
                $objMeses[] = array('mes' => $this->retornaNomeDoMes($numMes).' / '.$ano, 'numMes' => $numMes, 'ano' => $ano, 'marcador' => $m);
            //}else{
             
            //}
            
            
            $m++;
        }
        
        return $objMeses;
        
    }
    
    function retornaUltimoDiaDoMes($mes, $ano){
        return date('d', mktime(0, 0, 0, $mes+1, 0, $ano));
    }
    
    function somaDias($data,$dias,$tipo=1,$separador)
    {
        $ano = substr($data, 0, 4);
        $mes = substr($data, 5, 2);
        $dia = substr($data, 8, 2);
        $hora = substr($data, 11, 8);
        $dia_previsto = $dia + $dias;
        
        if ($tipo==1){
            $data_prevista = date("d".$separador."m".$separador."Y", mktime(0, 0, 0, $mes ,$dia_previsto, $ano));
        }else if ($tipo==2){
            $data_prevista = date("Y".$separador."m".$separador."d", mktime(0, 0, 0, $mes ,$dia_previsto, $ano));
        }
        
        
        return $data_prevista.' '.$hora;
    }
    
    function formata($data, $formato = 'completa')
	{
        $hora = substr($data,11,8);
        if(!empty($hora)){
            list ($h,$m,$s) = explode (':', $hora);
            $hora = $h.'h'.$m.'m';
        }
        
        $data = substr($data,0,10);
        list ($ano,$mes,$dia) = explode ('-', $data);
                
        $diaSemana = array();
        $diaSemana["Sun"] = "Dom";
        $diaSemana["Mon"] = "Seg";
        $diaSemana["Tue"] = "Ter";
        $diaSemana["Wed"] = "Qua";
        $diaSemana["Thu"] = "Qui";
        $diaSemana["Fri"] = "Sex";
        $diaSemana["Sat"] = "Sáb";
        
        $mesAno = array();
        $mesAno['01'] = "Jan";
        $mesAno['02'] = "Fev";
        $mesAno['03'] = "Mar";
        $mesAno['04'] = "Abr";
        $mesAno['05'] = "Mai";
        $mesAno['06'] = "Jun";
        $mesAno['07'] = "Jul";
        $mesAno['08'] = "Ago";
        $mesAno['09'] = "Set";
        $mesAno['10'] = "Out";
        $mesAno['11'] = "Nov";
        $mesAno['12'] = "Dez";
        
        $mesLongo = array();
        $mesLongo['01'] = "Janeiro";
        $mesLongo['02'] = "Fevereiro";
        $mesLongo['03'] = "Março";
        $mesLongo['04'] = "Abril";
        $mesLongo['05'] = "Maio";
        $mesLongo['06'] = "Junho";
        $mesLongo['07'] = "Julho";
        $mesLongo['08'] = "Agosto";
        $mesLongo['09'] = "Setembro";
        $mesLongo['10'] = "Outubro";
        $mesLongo['11'] = "Novembro";
        $mesLongo['12'] = "Dezembro";
        
        $diaDaSemanaTimeStamp = mktime(0,0,0,$mes,$dia,$ano);
        $diaDaSemana = date('D',$diaDaSemanaTimeStamp);
        
        if($formato === 'completa')
        {
            $dataFormatada = $dia.'-'.$mes.'-'.$ano.', '.$hora;
        }
        else if($formato === 'diamesano')
        {
            $dataFormatada = $dia.'-'.$mes.'-'.$ano;
        }
        else if($formato === 'porextenso')
        {
            $dataFormatada = $dia.'-'.$mesAno[$mes].'-'.$ano;
            
        }else if ( $formato === 'mesextenso' ){
            # data já esta no formato 'humano'
            list ($dia,$mes,$ano) = explode ('-', $data);
            $mesExtenso = $mesAno[$mes];
            $dataFormatada = $dia.'-'.$mesExtenso.'-'.$ano;
        }else if ( $formato === 'diadasemana' ){
            $dataFormatada = $diaSemana[$diaDaSemana];
        }else if ( $formato === 'longadescricao' ){
            $dataFormatada = $diaSemana[$diaDaSemana].', '.$dia.' '.$mesLongo[$mes].', '.$ano;
        }else if ( $formato === 'descricaocompleta' ){
            $dataFormatada = $diaSemana[$diaDaSemana].', '.$dia.' '.$mesLongo[$mes].' '.$ano.', '.$hora;
        }
        
        return $dataFormatada;
	}
    
    # nosso formato , retorno false se data2 for maior que data1
    function comparaDatas($data1, $data2)																
	{																									
		
        list($dia1,$mes1,$ano1) = explode('-',$data1);																	
		list($dia2,$mes2,$ano2) = explode('-',$data2);																			
		
        $timestamp1 = mktime(0,0,0,$mes1,$dia1,$ano1);					
		$timestamp2 = mktime(0,0,0,$mes2,$dia2,$ano2);									
		
        if ($timestamp1 === $timestamp2){																	
            return true;																				
        }else if($timestamp1 > $timestamp2){			
            return true;	
        }else{
            return false;	
        }
    }
    
}

?>