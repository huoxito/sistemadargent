    
    <?php //echo $this->element('sql_dump'); ?>
    <?php
        
        
        if( $campo == 'nome' ){
            echo $session->read('Auth.Usuario.nome').' '; 
        }else{
            echo $session->read('Auth.Usuario.email').' '; 
        }
        
        
    ?>