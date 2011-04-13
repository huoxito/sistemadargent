
            <p class="info-tabela">
                Despesas <span class="negativo">R$ <?= $despesas ?></span>
                Faturamentos R$ <span class="positivo"><?= $faturamentos ?></span> 
                Saldo R$ <span class="<?= $classSaldo ?>"><?= $saldo ?></span>
            </p>
             
            <table cellpadding="0" cellspacing="0" class="tabelaListagem">
                <tr>
                    <th align="center">Data</th>
                    <th align="left">Tipo</th>
                    <th align="left">Valor</th>
                    <th align="left">Categoria</th>
                    <th align="left">Obs.</th>
                    <th align="center">Ações</th>
                </tr>
                <?php foreach ($moves as $move): ?>
                <tr id="moveId<?= $move['Move']['id'];?>" class="registros">
                    <td align="center" width="80">
                        <?= $this->Time->format('d-m-Y', $move['Move']['data']); ?>
                    </td>
                    <td align="center" width="20" class="<?= $move['Move']['color']; ?>">
                        <b><?= $move['Move']['tipo']; ?></b>
                    </td>
                    <td class="<?= $move['Move']['color']; ?>" width="100">
                        <?= $move['Move']['valor']; ?>
                    </td>
                    <td width="150">
                        <?= $move['Categoria']['nome']; ?>
                    </td>
                    <td>
                        <?= $move['Move']['obs']; ?>
                    </td>
                    <td class="actions">
                        <?= $this->Html->link('EDITAR',
                                    array('action' => 'edit', $move['Move']['id']),
                                    array('class' => 'colorbox-edit btneditar',
                                          'title' => 'Editar move')); ?> 
                        <?= $this->Html->link('DELETE', 
                                        array('action' => 'delete', $move['Move']['id']),
                                        array('class' => 'colorbox-delete btnexcluir',
                                              'title' => 'Excluir move')); ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
            <?= $this->element('sql_dump'); ?>
