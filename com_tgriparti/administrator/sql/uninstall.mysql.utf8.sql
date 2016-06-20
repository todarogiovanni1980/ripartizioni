DROP TABLE IF EXISTS `#__tgriparti_condominio`;
DROP TABLE IF EXISTS `#__tgriparti_nominativo`;
DROP TABLE IF EXISTS `#__tgriparti_ricevuta`;
DROP TABLE IF EXISTS `#__tgriparti_lettura`;

DELETE FROM `#__content_types` WHERE (type_alias LIKE 'com_tgriparti.%');