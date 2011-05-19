 
    <div class="ganhos index">
        
        <div id="contentHeader">
            
            <h1>Movimentações</h1> 
            
        </div>
        
        <div class="balancoBotoesWraper">
            
            <div class="balancoBotoes">
                
                <?= $this->Html->link('Inserir', array('action' => 'add')); ?>

            </div>
        
        </div>
        
        <div class="relatoriosWraper">
            
            <div id="relatorioRapido">
                
                <div class="titulos">
                    <h2>
                        <a href="#" class="prev-month" title="anterior" id="<?= $anterior ?>"><img src="/img/previous.png" alt="anterior" /></a>  
                        <span id="mes-movimentacoes"><?= $mes ?></span>
                        <a href="#" title="próximo" class="next-month" id="<?= $proximo ?>"><img src="/img/next.png" alt="próximo" /></a>  
                    </h2>
                </div>
                
            </div>
        
        </div>
        
        <?php   echo $this->Session->flash(); ?>
        
        <div id="table-wrapper">
            <!-- conteudo carregado com ajax -->        
        </div>
        
    </div>
        
<script type="text/javascript">
    // <![CDATA[
    $(document).ready(function () {
        movimentacoes(null, null);
    });
    // ]]>
</script>
