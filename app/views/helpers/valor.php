<?php

class ValorHelper extends AppHelper {
    
    var $name = 'Valor';
    
    function formata($valor, $tipo = 'banco'){
                
        $valor = number_format($valor,2,",",".");	
        if ($valor == '0,00'){
            return $valor;
        }else{
            return $valor;
        }
    }
}

?>