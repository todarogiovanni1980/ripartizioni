CREATE TABLE IF NOT EXISTS `#__tgriparti_condominio` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`created_by` INT(11)  NOT NULL ,
`modified_by` INT(11)  NOT NULL ,
`via` VARCHAR(50)  NOT NULL ,
`cap` VARCHAR(255)  NOT NULL ,
`citta` VARCHAR(255)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `#__tgriparti_nominativo` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`created_by` INT(11)  NOT NULL ,
`modified_by` INT(11)  NOT NULL ,
`nome` VARCHAR(255)  NOT NULL ,
`condomino` INT NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `#__tgriparti_ricevuta` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`created_by` INT(11)  NOT NULL ,
`modified_by` INT(11)  NOT NULL ,
`nome` VARCHAR(255)  NOT NULL ,
`descrizione` TEXT NOT NULL ,
`costo` FLOAT NOT NULL ,
`data` DATE NOT NULL ,
`condominio` INT NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `#__tgriparti_lettura` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`created_by` INT(11)  NOT NULL ,
`modified_by` INT(11)  NOT NULL ,
`nominativo` INT NOT NULL ,
`lettura` VARCHAR(255)  NOT NULL ,
`ripartizione` INT NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8mb4_unicode_ci;


INSERT INTO `#__content_types` (`type_title`, `type_alias`, `table`, `content_history_options`)
SELECT * FROM ( SELECT 'Condominio','com_tgriparti.condominio','{"special":{"dbtable":"#__tgriparti_condominio","key":"id","type":"Condominio","prefix":"Ripartizione AMAPTable"}}', '{"formFile":"administrator\/components\/com_tgriparti\/models\/forms\/condominio.xml", "hideFields":["checked_out","checked_out_time","params","language"], "ignoreChanges":["modified_by", "modified", "checked_out", "checked_out_time"], "convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"catid","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"group_id","targetTable":"#__usergroups","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"created_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"}]}') AS tmp
WHERE NOT EXISTS (
	SELECT type_alias FROM `#__content_types` WHERE (`type_alias` = 'com_tgriparti.condominio')
) LIMIT 1;

INSERT INTO `#__content_types` (`type_title`, `type_alias`, `table`, `content_history_options`)
SELECT * FROM ( SELECT 'Nominativo','com_tgriparti.nominativo','{"special":{"dbtable":"#__tgriparti_nominativo","key":"id","type":"Nominativo","prefix":"Ripartizione AMAPTable"}}', '{"formFile":"administrator\/components\/com_tgriparti\/models\/forms\/nominativo.xml", "hideFields":["checked_out","checked_out_time","params","language"], "ignoreChanges":["modified_by", "modified", "checked_out", "checked_out_time"], "convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"catid","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"group_id","targetTable":"#__usergroups","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"created_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"condomino","targetTable":"#__tgriparti_condominio","targetColumn":"id","displayColumn":"nome"}]}') AS tmp
WHERE NOT EXISTS (
	SELECT type_alias FROM `#__content_types` WHERE (`type_alias` = 'com_tgriparti.nominativo')
) LIMIT 1;

INSERT INTO `#__content_types` (`type_title`, `type_alias`, `table`, `content_history_options`)
SELECT * FROM ( SELECT 'Ricevuta','com_tgriparti.ricevuta','{"special":{"dbtable":"#__tgriparti_ricevuta","key":"id","type":"Ricevuta","prefix":"Ripartizione AMAPTable"}}', '{"formFile":"administrator\/components\/com_tgriparti\/models\/forms\/ricevuta.xml", "hideFields":["checked_out","checked_out_time","params","language" ,"descrizione"], "ignoreChanges":["modified_by", "modified", "checked_out", "checked_out_time"], "convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"catid","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"group_id","targetTable":"#__usergroups","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"created_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"condominio","targetTable":"#__tgriparti_condominio","targetColumn":"id","displayColumn":"nome"}]}') AS tmp
WHERE NOT EXISTS (
	SELECT type_alias FROM `#__content_types` WHERE (`type_alias` = 'com_tgriparti.ricevuta')
) LIMIT 1;

INSERT INTO `#__content_types` (`type_title`, `type_alias`, `table`, `content_history_options`)
SELECT * FROM ( SELECT 'Lettura','com_tgriparti.lettura','{"special":{"dbtable":"#__tgriparti_lettura","key":"id","type":"Lettura","prefix":"Ripartizione AMAPTable"}}', '{"formFile":"administrator\/components\/com_tgriparti\/models\/forms\/lettura.xml", "hideFields":["checked_out","checked_out_time","params","language"], "ignoreChanges":["modified_by", "modified", "checked_out", "checked_out_time"], "convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"catid","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"group_id","targetTable":"#__usergroups","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"created_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"nominativo","targetTable":"#__tgriparti_nominativo","targetColumn":"id","displayColumn":"nome"},{"sourceColumn":"ripartizione","targetTable":"#__tgriparti_ricevuta","targetColumn":"id","displayColumn":"nome"}]}') AS tmp
WHERE NOT EXISTS (
	SELECT type_alias FROM `#__content_types` WHERE (`type_alias` = 'com_tgriparti.lettura')
) LIMIT 1;
