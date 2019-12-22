CREATE TABLE `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(45) COLLATE utf8_slovenian_ci NOT NULL,
  `description` longtext COLLATE utf8_slovenian_ci DEFAULT NULL,
  `url` varchar(150) COLLATE utf8_slovenian_ci NOT NULL,
  `level` int(11) DEFAULT 1,
  `position` int(11) DEFAULT 1,
  `parent` int(11) DEFAULT 0,
  `active` int(11) NOT NULL DEFAULT 0,
  `admin` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;
