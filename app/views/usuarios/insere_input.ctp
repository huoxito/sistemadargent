    
    
<?php

    echo $form->create('Usuario',array('default' => false,'class' => 'oneinput'));
    
    if ( $campo === 'Name' ){
        echo $form->input('nome',
                    array('error' => false,
                          'label' => false,
                          'div' => false,
                          'style' => 'padding: 5px;',
                          'default' => $session->read('Auth.Usuario.nome'),
                          'id' => 'Name')
                        
                );
    }
    
    if ( $campo === 'Email' ){
        echo $form->input('email',
                    array('error' => false,
                          'label' => false,
                          'div' => false,
                          'style' => 'padding: 5px;',
                          'default' => $session->read('Auth.Usuario.email'),
                          'id' => 'Email')            
                );
    }



    echo $form->end(array('label' => 'Salvar',
                            'onclick' => 'editar(\''.$campo.'\');',
                            'class' => 'cleanInput',
                            'div' => false,
                            'after' => ' <input type="submit" class="cleanInput" onclick="cancela(\''.$campo.'\',\''.$value.'\');" value="Cancelar" />'));
?>