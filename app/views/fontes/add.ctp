
    <div class="fontes form">
        
        <div id="contentHeader">
            <?php   echo $this->element('fonte_menu'); ?>
        </div>
        
        <div class="balancoBotoesWraper">
            
            <div class="balancoBotoes">
                <p>Insira uma nova categoria para seus Faturamentos</p>
                
                <div class="headeraddlinks">
                    <?php echo $this->Html->link('LISTAR FATURAMENTOS',
                                            array('controller' => 'ganhos',
                                                  'action' => 'index'),
                                            array('class' => 'btnaddcategoria')); ?>
                </div>
                <div class="headeraddlinks">
                    <?php echo $this->Html->link('LISTAR FONTES',
                                            array('controller' => 'fontes',
                                                  'action' => 'index'),
                                            array('class' => 'btnaddcategoria')); ?>
                </div>
            </div>
            
        </div>
        
        <?php   echo $this->Session->flash(); ?>
        
        <div class="formWraper formBox">
        
            <?= $this->Form->create('Fonte');?>
            <fieldset>
                <?= $this->Form->input('nome',array('error' => array('wrap' => 'span')));    ?>
                <?= $this->Form->end('Inserir');?>
            </fieldset>
        
        </div>
        
    </div>

