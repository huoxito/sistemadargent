    
    <div class="destinos form">
        
        <div id="contentHeader">
            <?php   echo $this->element('destino_menu'); ?>
        </div>
        
        <div class="balancoBotoesWraper">
            
            <div class="balancoBotoes">
                <p>Insira um novo destino para suas Despesas</p>
                
                <div class="headeraddlinks">
                    <?php echo $this->Html->link('LISTAR DESPESAS',
                                            array('controller' => 'gastos',
                                                  'action' => 'index'),
                                            array('class' => 'btnaddcategoria')); ?>
                </div>
                <div class="headeraddlinks">
                    <?php echo $this->Html->link('LISTAR DESTINOS',
                                            array('controller' => 'destinos',
                                                  'action' => 'index'),
                                            array('class' => 'btnaddcategoria')); ?>
                </div>
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

