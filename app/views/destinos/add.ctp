    
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
        
        <?php   echo $this->Session->flash(); ?>
        
        <div class="formWraper formBox">

            <?= $this->Form->create('Destino');?>
            <fieldset>
                <?= $this->Form->input('nome', array('error' => array('wrap' => 'span')));    ?>
                <?= $this->Form->end('Inserir');?>
            </fieldset>
        
        </div>
        
    </div>

