    
    
<?php

    echo $form->create('Usuario',array('default' => false,'class' => 'oneinput'));
    
    if ( $campo === 'Name' ){
        echo $form->input('nome',
                    array('error' => false,
                          'label' => false,
                          'div' => false,
                          'default' => $session->read('Auth.Usuario.nome'),
                          'id' => 'Name')
                        
                );
    }
    
    if ( $campo === 'Email' ){
        echo $form->input('email',
                    array('error' => false,
                          'label' => false,
                          'div' => false,
                          'default' => $session->read('Auth.Usuario.email'),
                          'id' => 'Email')            
                );
    }



    echo $form->end(array('label' => 'SALVAR',
                            'onclick' => 'editar(\''.$campo.'\');',
                            'class' => 'btnaddcategoria',
                            'div' => false,
                            'after' => ' <input type="submit" class="btnaddcategoria" onclick="cancela(\''.$campo.'\',\''.$value.'\');" value="CANCELAR" />'));
?>