    <div class="gastos index">
        
        <h2><?php echo __('Dargent - Sistema Simples de Gerenciamento Financeiro!');?></h2>
        <p>Iaaaewww <?php echo $this->Session->read('Auth.Usuario.nome'); ?> !</p>
        
        
        <p class="infos" style="margin-top: 10px;">No último mês você gastou pelo menos <span style="color: #EE3322;">R$ <?php echo $totalgasto; ?> reais</span> ! E recebeu <b>R$ <?php echo $totalganho; ?> reais</b> !</p>
        
        <p class="infos" style="margin-top: 10px;">Principal destino da grana ------- > <span style="color: #EE3322;"><?php echo strtoupper($principalDestino); ?></span> com R$ <?php echo $valorDestino; ?> reais gastos.</p>
        
        <p class="infos">Principal fonte de grana ------- > <span style="color: #EE3322;"><?php echo strtoupper($principalFonte); ?></span> com R$ <?php echo $valorFonte; ?> reais recebidos.</p>
        
    </div>
    
    
    
