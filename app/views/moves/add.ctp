 
    <div class="moves form">
        
        <div id="contentHeader">
            <h1>Cadastro de Movimentações</h1>
        </div>
        
        <div class="formWraper formBox">
                 
            <?= $this->Form->create('Move',
                            array('inputDefaults' =>
                                    array('error' => array('wrap' => 'span')))); ?>
                                    
            <fieldset>
                               
                <div class="input required">
                    <label>Tipo</label>
                    <?php
                        $options = array('Faturamento'=> ' Faturamento ', 'Despesa'=>' Despesa ');
                        $attributes = array('legend'=> false,
                                            'class' => 'config',
                                            'label' => false);
                        echo $this->Form->radio('tipo',$options,$attributes);   
                    ?>
                    <?php if (isset($this->validationErrors['Move']['tipo'])){ ?>
                        <span class="error-message">
                            <?= $this->validationErrors['Move']['tipo'] ?>
                        </span>
                    <?php } ?>
            </div>
            
            <div id="categorias_">
             
                <?php if(!array_key_exists('Categoria',(array)$this->data)){ ?>
                
                <div id="selectCategoria" class="input text required">
                    <?= $this->Form->input('categoria_id',
                                        array('empty' => 'Escolha uma categoria',
                                              'div' => false,
                                              'error' => false)); ?>
                    <a href="#" class="btnadd" title="inserir" id="insereInputCategorias">
                        INSERIR NOVA CATEGORIA
                    </a>
                    <?php if (isset($this->validationErrors['Move']['categoria_id'])){ ?>
                        <span class="error-message">
                            <?= $this->validationErrors['Move']['categoria_id'] ?>
                        </span>
                    <?php } ?>
                    </div>
                    
                    <?php }else{ ?>
                    
                    <div id="inputCategoria" class="input text required">
                        <?= $this->Form->input('Categoria.nome',
                                            array('label' => 'Categoria',
                                                  'div' => false,
                                                  'error' => false)); ?>
                        <a href="#" title="selecionar" class="btnadd" id="insereSelectCategorias">
                            SELECIONAR UMA CATEGORIA
                        </a>
                        <?php if (isset($this->validationErrors['Categoria']['nome'])){ ?>
                            <span class="error-message">
                                <?= $this->validationErrors['Categoria']['nome'] ?>
                            </span>
                        <?php } ?>
                    </div>
                    
                    <?php } ?>
                
                </div>
                 
                <?= $this->Form->input('conta_id'); ?>
                <?= $this->Form->input('valor',
                                    array('id' => 'valorMask'));  ?>
                <?= $this->Form->input('data', array('type' => 'text'));  ?>
                <?= $this->Form->input('obs',
                                        array('label' => 'Observações')); ?>
                
                <div class="submit">
                    <input type="submit" value="Inserir">
                    <?php echo $this->Form->checkbox('keepon'); ?>
                    <span class="label">Continuar inserindo registros</span>
                </div>
                
            </fieldset>
            
        </div>

    </div>
    
