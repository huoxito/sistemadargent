    
    <?php //echo $this->element('sql_dump'); ?>
    <?php
        
        
        if( $campo == 'nome' ){
        
            echo $session->read('Auth.Usuario.nome').' '; 
            
            echo $html->link(__('Editar', true),
                                    '#javascript:;',
                                    array('onclick' => 'insereInput(\'Name\',\''.$session->read('Auth.Usuario.nome').'\')')
                                    );
        }else{
            
            echo $session->read('Auth.Usuario.email').' '; 
            
            echo $html->link(__('Editar', true),
                                    '#javascript:;',
                                    array('onclick' => 'insereInput(\'Email\',\''.$session->read('Auth.Usuario.email').'\')')
                                    );
        }
        
        
    ?>