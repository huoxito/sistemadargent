<?php

    $resposta = array(
        'result' => $result,
        'error' => $error
    );

    echo json_encode($resposta);

    //echo $this->element('sql_dump'); 
?>
