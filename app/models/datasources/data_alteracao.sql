
/*
ALTER TABLE `drg_ganhos` CHANGE `dataentrada` `datadabaixa` DATE NULL DEFAULT NULL
ALTER TABLE `drg_ganhos` ADD `datadevencimento` DATE NULL AFTER `datadabaixa`

ALTER TABLE `drg_gastos` CHANGE `datasaida` `datadabaixa` DATE NULL DEFAULT NULL 
ALTER TABLE `drg_gastos` ADD `datadevencimento` DATE NULL AFTER `datadabaixa`

ALTER TABLE `drg_fontes` CHANGE `nome` `nome` VARCHAR( 30 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL
ALTER TABLE `drg_destinos` CHANGE `nome` `nome` VARCHAR( 30 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL

ALTER TABLE `drg_ganhos` CHANGE `observacoes` `observacoes` VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL
ALTER TABLE `drg_gastos` CHANGE `observacoes` `observacoes` VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL

ALTER TABLE `drg_agendamentos` CHANGE `tipo` `tipo` VARCHAR( 10 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL 
*/



ALTER TABLE `drg_usuarios` ADD `ultimologin` DATETIME NULL AFTER `foto` ,
ADD `numdeacessos` INT NULL AFTER `ultimologin` 