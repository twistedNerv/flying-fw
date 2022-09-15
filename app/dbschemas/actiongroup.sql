CREATE TABLE `actiongroup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8_slovenian_ci NOT NULL,
  `description` longtext COLLATE utf8_slovenian_ci DEFAULT NULL,
  `action` varchar(45) COLLATE utf8_slovenian_ci DEFAULT NULL,
  `section` varchar(45) COLLATE utf8_slovenian_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;