    
    <div id="cadastro">
        	
        <h1>Cadastro</h1>
        
        <div id="form"> 
            
            <?php echo $form->create('Usuario', array('type' => 'file', 'url' => '/cadastro'));?>
            
            <div>
                <?php echo $form->input('nome',
                                            array('div' => false,
                                                  'error' => array('wrap' => 'span', 'class' => 'error'),
                                                  'class' => 'l-input')); ?>
            </div>
            
            <div>
                <?php echo $form->input('email',
                                            array('div' => false,
                                                  'error' => array('wrap' => 'span', 'class' => 'error'),
                                                  'class' => 'l-input')); ?>
            </div>
            
            <div>
                <?php echo $form->input('login',
                                            array('div' => false,
                                                  'error' => array('wrap' => 'span', 'class' => 'error'),
                                                  'class' => 'l-input')); ?>
            </div>
            
            <div>
                <?php echo $form->input('passwd',
                                            array('label' => 'Senha',
                                                  'div' => false,
                                                  'value' => '',
                                                  'error' => array('wrap' => 'span', 'class' => 'error'),
                                                  'class' => 'l-input')); ?>
            </div>
            
            <div>
                <?php echo $form->input('passwd_confirm',
                                            array('type' => 'password',
                                                  'div' => false,
                                                  'value' => '',
                                                  'label' => 'Confirmar Senha',
                                                  'error' => array('wrap' => 'span', 'class' => 'error'),
                                                  'class' => 'l-input')); ?>
            </div>
            
            
            <div>
                <?php echo $form->input('Usuario.foto',
                                            array('type'=>'file',
                                                  'label' => 'Foto ( campo não obrigatório )',
                                                  'div' => false,
                                                  'error' => array('wrap' => 'span', 'class' => 'error'),
                                                  'class' => 'l-input')); ?>
            </div>
            
            <p class="termos">
                Ao clicar em "Criar minha conta", abaixo, você concorda com os <a href="#">Termos de serviço</a> e a 
                <a href="#">Política de Privacidade</a>.
            </p>
                
                <?php echo $form->end(array('label' => 'Criar Minha Conta', 'class' => 'botao-cadastro', 'div' => false));?>
                
            </form>
             
    </div>

    