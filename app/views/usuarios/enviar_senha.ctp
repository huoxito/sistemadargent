

    <?php echo $this->Session->flash(); ?>
    <?php echo $this->Session->flash('email'); ?>
        
    <div id="cadastro">

        <h1>Envio de senha</h1>
        
        <p>Uma senha será gerada e enviada para seu email. Após logar novamente no sistema é muito importante que você mude sua senha.</p>
        
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
    
    