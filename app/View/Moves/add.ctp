    <div class="moves form">
        <div id="contentHeader">
            <h1>Cadastro de Movimentações</h1>
        </div>
        <div id=subheader>
            <div class=paddinglateral>
            <?= $this->Html->link('voltar pra listagem',
                        array('controller' => 'moves', 'action' => 'index'),
                        array('class' => 'btnadd')); ?> 
            </div>
        </div>
        <?php echo $this->Session->flash(); ?>
        <div class="formWraper formBox">
            <?= $this->Form->create('Move',
                            array('inputDefaults' =>
                                    array('error' => array('wrap' => 'span')))); ?>
            <fieldset>                        
                <div class="input">
                    Obs. Marque o campo parcelar para agendar movimentações que 
                    obedecem uma certa frequência.
                </div>
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
                            <?= $this->validationErrors['Move']['tipo'][0] ?>
                        </span>
                    <?php } ?>
                </div>
                
                <div id="categorias_">
                 
                    <?php if(!array_key_exists('Categoria',(array)$this->request->data)){ ?>
                    
                    <div id="selectCategoria" class="input text required">
                        <?= $this->Form->input('categoria_id',
                                            array('empty' => 'Escolha uma categoria',
                                                  'div' => false,
                                                  'error' => false)) ?>
                        <a href="#" class="btnadd" title="inserir" id="insereInputCategorias" onclick="insereInputCategorias(); return false;">
                            INSERIR NOVA CATEGORIA
                        </a>
                        <?php if (isset($this->validationErrors['Move']['categoria_id'])){ ?>
                            <span class="error-message">
                                <?= $this->validationErrors['Move']['categoria_id'][0] ?>
                            </span>
                        <?php } ?>
                    </div>
                        
                    <?php }else{ ?>
                        
                    <div id="inputCategoria" class="input text required">
                        <?= $this->Form->input('Categoria.0.nome',
                                            array('label' => 'Categoria',
                                                  'div' => false,
                                                  'error' => false)) ?>
                        <a href="#" title="selecionar" class="btnadd" id="insereSelectCategorias" onclick="insereSelectCategorias(); return false;">
                            SELECIONAR UMA CATEGORIA
                        </a>
                        <?php if (isset($this->validationErrors['Categoria']['nome'])){ ?>
                            <span class="error-message">
                                <?= $this->validationErrors['Categoria']['nome'][0] ?>
                            </span>
                        <?php } ?>
                    </div>
                        
                    <?php } ?>
                    
                </div>
                     
                <?= $this->Form->input('conta_id'); ?>
                <?= $this->Form->input('valor',
                                    array('id' => 'valorMask'));  ?>
                <?= $this->Form->input('data', 
                                    array('type' => 'text',
                                          'id' => 'data-calendario'));  ?>
                <?= $this->Form->input('obs',
                                        array('label' => 'Observações')); ?>
                
                <div class="input">
                <?php
                    $options = array('0'=>' Apenas um registro ', '1'=>' Parcelar ');
                    $attributes = array('legend'=> false,
                                        'class' => 'config',
                                        'label' => false,
                                        'onchange' => 'disableOrNotInputs(this.value);');
                    echo $this->Form->radio('config',$options,$attributes);   
                ?>
                </div>
                
                <div class="leftInput">
                    <?php
                         $options = array(
                            'mensal' => 'mensal', 'bimestral' => 'bimestral', 'trimestral' => 'trimestral',
                            'semestral' => 'semestral', 'anual' => 'anual'
                         );
                         echo $this->Form->select('frequencia', $options,
                                    array('empty' => false, 'id' => 'frequencia-a'));
                    ?>
                </div>
                
                <div class="leftInput">    
                    <?= $this->Form->input('numdeparcelas',
                                            array('label' => 'Em 1 + ',
                                                  'div' => false,
                                                  'id' => 'numparcelas')); ?>
                </div>

                <div class="submit">
                    <input type="submit" value="Inserir">
                    <?php echo $this->Form->checkbox('keepon'); ?>
                    <span class="label">Continuar inserindo registros</span>
                </div>

            </fieldset>

            </form>   
            
        </div>

    </div>
    
<script type="text/javascript">  
$(document).ready(function () {
    disableOrNotInputs($('input:radio:checked').val());
    $('#data-calendario').datepicker('setDate', new Date());
});
</script>



