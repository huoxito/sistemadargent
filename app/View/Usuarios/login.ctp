    
<div id="content-home"> 
    <div id="infos">
        <div id=about>
            <h1 class=def>O que é o Dargent?</h1>
            <p>Sistema de controle financeiro pessoal simples.</p>
            <p>
                Possui um controle de caixa para suas movimentações. É possível criar
                quantas contas achar necessário. O mesmo para categorias. O sistema
                monta gráficos comparativos das suas movimentações e das suas
                principais categorias. Há filtros para personalizar essas informações de
                acordo com o periodo escolhido.
            </p>
            <p>
                Não há um termo de compromisso para usar o sistema. Não há publicidade na
                aplicação. Não há assinaturas. Use como desejar. É possível excluir sua conta
                e os dados que você inseriu a qualquer momento.
            </p>
            <p>
                Cada usuário tem acesso apenas a suas movimentações.
            <p>
            <p>
                A aplicação foi desenvolvida inicialmente como uma forma de estudo 
                do framework CakePHP. O código está
                disponível no <a href="https://github.com/huoxito/sistemadargent" title="sistema dargent">github</a>.
            </p>
        </div>
        <div id=form-cadastro>
            <?= $this->Form->create('Usuario', array('type' => 'file', 'url' => '/cadastro'));?>

                <?= $this->Form->input('nome', array( 'class' => 'l-input')); ?>
                <div class="input text">
                <?= $this->Form->input('email_register', 
                        array('label' => 'Email', 'class' => 'l-input', 'div' => false)); ?>
                    <? if(isset($this->validationErrors["Usuario"]["email"])){ ?> 
                        <div class="error-message"><?= $this->validationErrors["Usuario"]["email"][0]; ?></div>
                    <? } ?>
                </div>
                <?= $this->Form->input('passwd', array('label' => 'Senha', 'value' => '', 'class' => 'l-input')); ?>
                <?= $this->Form->input('passwd_confirm', array('type' => 'password', 'value' => '', 'label' => 'Confirmar Senha',
                                  'class' => 'l-input')); ?>
                                
            <?= $this->Form->end(array('label' => 'Criar Minha Conta', 'class' => 'botao-cadastro', 'div' => false));?>
        </div>
    </div>


</div>
