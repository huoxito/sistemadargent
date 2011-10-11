    
<div id="content-home"> 
    <div id="infos">
        <div id=about>
        <h1>O que é o Dargent?</h1>
        <p class="definicao">Sistema de controle financeiro pessoal simples e seguro.</p>
        <p class="definicao">O sistema fornece a categorização de seus ganhos e gastos e, através de gráficos, mostra quais as suas principais categorias.</p>
        <p class="definicao">Os relatórios são de fácil acesso, permitindo você ter um histórico rápido sobre como anda sua movimentação financeira.</p>
        <h1>Vantagens</h1>
        <ul>
            <li><span>1.</span> Simples, rápido e prático. Em pouco tempo você pode inserir vários registros.</li>
            <li><span>2.</span> Programe todas suas contas e salários com antecedência.</li>
            <li><span>3.</span> Veja gráficos comparativos da sua movimentação financeira.</li>
        </ul>
        <h1>Faça seu cadastro</h1>
        <p class="definicao">Leva menos de um minuto.</p>
        <p class="definicao">Basta inserir nome, email, login e senha.</p>
        <p class="definicao">É gratuito.</p>
        </div>
        <div id=form-cadastro>
            <h1>Cadastre-se</h1>
            <?= $this->Form->create('RegistrarUsuario', array('type' => 'file', 'url' => '/cadastro'));?>

                <?= $this->Form->input('nome', array( 'class' => 'l-input')); ?>
                <?= $this->Form->input('email', array( 'class' => 'l-input')); ?>
                <?= $this->Form->input('passwd', array('label' => 'Senha', 'value' => '', 'class' => 'l-input')); ?>
                <?= $this->Form->input('passwd_confirm', array('type' => 'password', 'value' => '', 'label' => 'Confirmar Senha',
                                  'class' => 'l-input')); ?>
                                
            <?= $this->Form->end(array('label' => 'Criar Minha Conta', 'class' => 'botao-cadastro', 'div' => false));?>
        </div>
    </div>


</div>
