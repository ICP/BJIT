DROP TABLE IF EXISTS `#__ugc_items`;

DELETE FROM `#__content_types` WHERE (type_alias LIKE 'com_ugc.%');