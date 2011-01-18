

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
                $options = array('corrente'=>' Corrente ', 'poupança'=> ' Poupança ', 'cash' => ' Cash ');
                $attributes = array('class' => 'config',
                                    'label' => 'Tipo');
                echo $this->Form->radio('tipo',$options,$attributes);   
                echo $this->Form->end('Criar nova conta');
            ?>
            <div class="input">
            <?php
                
            ?>
            </div>
        </fieldset>
        
    </div>
    
</div>
    
    
    
    