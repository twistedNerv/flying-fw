CREATE TABLE `board` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_slovenian_ci NOT NULL,
  `content` longtext COLLATE utf8_slovenian_ci NOT NULL,
  `postdate` varchar(45) COLLATE utf8_slovenian_ci DEFAULT NULL,
  `postuser` varchar(45) COLLATE utf8_slovenian_ci DEFAULT NULL,
  `visible` varchar(45) COLLATE utf8_slovenian_ci DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;
