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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

INSERT INTO `menu` (`title`, `description`, `url`, `level`, `position`, `parent`, `active`, `admin`) VALUES 
("Edit menu", "Editing menu and menu groups", "menu", 4, 1, 0, 1, 1),
("Edit users", "Editing users", "user/update", 4, 2, 0, 1, 1),
("Builder", "Creating modules", "builder/index", 5, 3, 0, 1, 1),
("Preglej", "Preglej zadnja obvestila", "board/index", 2, 1, 4, 1, 0),
("Uredi", "Dodaj ali uredi obvestila", "board/update", 2, 2, 4, 1, 0);
