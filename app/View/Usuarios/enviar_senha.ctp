

    <?php echo $this->Session->flash('email'); ?>
        
    <div id="cadastro">

        <h1>Envio de senha</h1>
        
        <?php echo $this->Session->flash(); ?>
        <p>Insira seu email cadastrado no sistema</p>
        
        <div id="form"> 
            
            <?php echo $this->Form->create('Usuario', array('type' => 'file', 'url' => '/enviarSenha'));?>
            
            <div>
                <?php echo $this->Form->input('email',
                                array('div' => false,
                                      'label' => 'Insira seu email',
                                      'error' => array('wrap' => 'span', 'class' => 'error'),
                                      'class' => 'l-input')); ?>
            </div>
            
                <?php echo $this->Form->end(array('label' => 'Enviar',
                                            'class' => 'botao-cadastro',
                                            'div' => false));?>
                
            </form>
             
        </div>
    
    </div>
    