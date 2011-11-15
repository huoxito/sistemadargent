    
    <?php //echo $this->element('sql_dump'); ?>
    <?php
        
        
        if( $campo == 'nome' ){
            echo $this->Session->read('Auth.Usuario.nome').' '; 
        }else{
            echo $this->Session->read('Auth.Usuario.email').' '; 
        }
        
        
    ?>