<?php
    
    if($status){
        
        $link = $this->Html->link('DESATIVAR',
                        '#javascript:;',
                        array('class' => 'btnexcluir',
                              'onclick' => 'mudarStatus('.$id.',0)'));
        
        $message = "<p>Categoria Ativada</p>";
    }else{
    
        $link = $this->Html->link('ATIVAR',
                        '#javascript:;',
                        array('class' => 'btneditar',
                              'onclick' => 'mudarStatus('.$id.',1)'));
    
        $message = "<p>Categoria Desativada</p>";
    }
    
    $value = $this->element('sql_dump');
    echo json_encode(array('link' => $link,
                           'msg' => $message,
                           'sql' => null));
    