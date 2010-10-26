<?php

    class ValorComponent extends Object {
        
        var $name = 'Valor';
        
        function formata($valor, $tipo = 'banco'){
            
            if($tipo === 'banco'){
                
                $valor = trim($valor);
                $valor = str_replace(",","+",$valor);
                $valor = str_replace(".","",$valor);
                $valor = str_replace("+",".",$valor);
                $valor = (float) $valor;
                
                return $valor;
                
            }else{
                
                $valor = number_format($valor,2,",",".");	
                if ($valor == '0,00'){
                    return $valor;
                }else{
                    return $valor;
                }
                //return number_format($valor,2, "," ," ");	
            }
        }
        
        function soma($valorArray, $model){
            
            $total = 0;
            foreach ($valorArray as $valor):
                $total = $total + $valor[$model]['valor'];
            endforeach;  
            return array(
                         'formatado' => $this->formata($total,'humano'),
                         'limpo' => $total
                         );
        }
        
    }

?>