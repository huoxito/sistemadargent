

<div class="contas form">
    
    <div id="contentHeader">
        <h1>Contas</h1>
    </div>
    
    <div class="balancoBotoesWraper">
        <div class="balancoBotoes">
            <p>
                Insira sua nova conta com seu respectivo saldo.
            </p>
        </div>
    </div>
    
    <?= $this->Session->flash(); ?>
    
    <div class="formWraper formBox">
        
        <?= $this->Form->create('Conta',
                            array('inputDefaults' =>
                                    array('error' => array('wrap' => 'span')))); ?>
        <fieldset>
            <?php
                echo $this->Form->input('nome');
                echo $this->Form->input('saldo');
                echo $this->Form->input('tipo');
                echo $this->Form->input('status');
            ?>
        </fieldset>
        <?php echo $this->Form->end(__('Submit', true));?>
    </div>
    
</div>
    
    
    
    