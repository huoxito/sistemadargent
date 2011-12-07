    
    
<?php

    echo $this->Form->create('Usuario',array('default' => false,'class' => 'oneinput'));
    
    if ( $campo === 'Name' ){
        echo $this->Form->input('nome',
                    array('error' => false,
                          'label' => false,
                          'div' => false,
                          'default' => $this->Session->read('Auth.Usuario.nome'),
                          'id' => 'Name')
                        
                );
    }
    
    if ( $campo === 'Email' ){
        echo $this->Form->input('email',
                    array('error' => false,
                          'label' => false,
                          'div' => false,
                          'default' => $this->Session->read('Auth.Usuario.email'),
                          'id' => 'Email')            
                );
    }



    echo $this->Form->end(array('label' => 'SALVAR',
                            'onclick' => 'editar(\''.$campo.'\');',
                            'class' => 'btnaddcategoria',
                            'div' => false,
                            'after' => ' <input type="submit" class="btnaddcategoria" onclick="cancela(\''.$campo.'\',\''.$value.'\');" value="CANCELAR" />'));
?>