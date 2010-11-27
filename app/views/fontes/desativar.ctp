<?php

    $link = $this->Html->link('ATIVAR',
                    array('#javascript:;'),
                    array('class' => 'btneditar',
                          'onclick' => 'desativar(1)'));

    $message = "<p>Categoria Desativada</p>";
    $value = $this->element('sql_dump');
    
    echo json_encode(array('link' => $link,
                           'msg' => $message,
                           'sql' => $value));
   