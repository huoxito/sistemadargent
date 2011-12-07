

    <div class="index">
        <div id="contentHeader">
            <h1>
                Últimas interações
            </h1>
        </div>
        
        <div id="ultimasInteracoesWraper">
            
            <div id="ultimasInteracoes">
                
                <?php foreach($ultimasInteracoes as $item){ ?>

                    <p class="interacao">
                        <span class="model"><?= $item['Model']; ?></span>
                        <span class="valor">R$ <?= $item['valor']; ?></span>
                        <?php echo $item['categoria']; ?> 
                        <span class="data"><?= $this->Data->formata($item['modified'],'descricaocompleta'); ?></span>
                    </p>

                <?php   }   ?>  
            
            </div>
            
        </div>
    </div>
