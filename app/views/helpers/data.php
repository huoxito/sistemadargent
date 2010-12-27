<?php

class DataHelper extends AppHelper {
    
    var $name = 'Data';
    
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
        
        if($formato === 'diamesano')
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
            # data já esta no formato 'humano'
            $dataFormatada = $diaSemana[$diaDaSemana].', '.$ano.' '.$mesLongo[$mes].', '.$dia;
        }else if ( $formato === 'descricaocompleta' ){
            $dataFormatada = $diaSemana[$diaDaSemana].', '.$dia.' '.$mesLongo[$mes].' '.$ano.', '.$hora;
        }else{
            $dataFormatada = $dia.'-'.$mes.'-'.$ano.', '.$hora;
        }
        
        return $dataFormatada;
	}
    
}

?>