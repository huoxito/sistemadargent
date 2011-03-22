<?php
    # variaveis de sessão do usuário
    $usuarioLogado = $session->read('Auth.Usuario.nome');
?>  

    <?= $this->Html->image('logo.png',
                        array('width' => '191',
                              'height' => '60',
                              'alt' => 'Dargent Sistema Financeiro',
                              'style' => 'margin-top:15px;',
                              'url' => '/')); ?>

    <div id="topo-right">
    
        <div id="UserInfoBox">
            
            <div style="float: right; padding: 0 0 0 10px;">
                
                <h1 id="userNameTopo"><?php echo $usuarioLogado; ?></h1>
                <span class="minhaconta">
                    <?php echo $this->Html->link('MINHA CONTA',
                                                array('controller' => '/',
                                                      'action' => 'perfil'));  ?>
                </span>
                
                <span class="sair">
                    <?php echo $this->Html->link('SAIR',
                                           array('controller' => 'usuarios',
                                                 'action' => 'logout'),
                                           array('alt'=> __('sair', true),
                                                 'title'=> __('sair', true)));?>
                </span> 
            
            </div>
        </div>
        
        <div class="box-left sugestoesTopo">
            <a href="<?php echo $this->Html->url(array('controller' => 'sugestoes', 'action' => 'add')); ?>" title="home">
                <?= $this->Html->image('sugestoes.jpg',
                            array('width' => '42',
                                  'height' => '34',
                                  'alt' => 'sugestões')); ?>
            </a>
            <h1 id="sugestoesTopo">
                <?php   echo $this->Html->link('Sugestões',
                                    array('controller' => 'sugestoes',
                                          'action' => 'add'),
                                    array('alt'=> __('Sugestões', true),
                                          'title'=> __('Sugestões', true)));
                ?>
            </h1>
            <p>AJUDE-NOS A <br />DESENVOLVER O DARGENT</p>
        </div>
        
        <?php $saldos = $this->requestAction('contas/saldo'); ?>
        <div class="labelSaldoTopoBox">
            <table id="tabela_topo_mes" border="0">
                <tr>
                    <td class="">
                        <span class="label">Faturamentos</span> 
                        <span class="value">
                            R$ <?= $this->Valor->formata($saldos['ganhos']) ?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td class="">
                        <span class="label">Despesas</span>
                        <span class="value">
                            R$ <?= $this->Valor->formata($saldos['gastos']) ?>
                        </span> 
                    </td>
                </tr>
            </table>
        </div>
        <div class="caixaSaldo">
            <span class="labelSaldoTopo saldoTopo">Saldo no mês</span>
            <span class="valorSaldoNoTopo">
                <span class="dollarTopo">R$</span>
                <?= $this->Valor->formata($saldos['diferenca']) ?>
            </span>
        </div>

        
    </div>
    
