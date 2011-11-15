
<?php
    $resposta = array(
            'result' => $result,
            'saldos' => 'Despesas <span class="negativo">R$ ' . $despesas . ' </span>
                        Faturamentos R$ <span class="positivo">' . $faturamentos . '</span> 
                        Saldo R$ <span class="'. $classSaldo .'">' . $saldo . '</span>'
    );

    echo json_encode($resposta); 

?>
<?php echo $this->element('sql_dump'); ?>
