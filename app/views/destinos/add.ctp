    
    <div class="destinos form">
        
        <div id="contentHeader">
            <?php   echo $this->element('destino_menu'); ?>
        </div>
        
        <div class="balancoBotoesWraper">
            
            <div class="balancoBotoes">
                
            </div>
            
        </div>
        
        <cake:nocache>
        <?php   echo $this->Session->flash(); ?>
        </cake:nocache>
        
        <div class="formWraper">

            <?php echo $this->Form->create('Destino');?>
            <fieldset>
            <?php   echo $this->Form->input('nome', array('error' => false)); ?>
            </fieldset>
            <?php echo $this->Form->end('Inserir');?>
        
        </div>
        
    </div>

