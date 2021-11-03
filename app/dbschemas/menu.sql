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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

INSERT INTO `menu` (`title`, `description`, `url`, `level`, `position`, `parent`, `active`, `admin`) VALUES
("Menu", "Editing menu and menu groups", "menu", 4, 1, 0, 1, 1),
("Users", "Editing users", "user/update", 4, 1, 0, 1, 1),
("Groups", "Editing action groups", "actiongroup/update", 4, 2, 0, 1, 1),
("Logs", "View logs", "logs/index", 4, 3, 0, 1, 1),
("Builder", "Creating modules", "builder/index", 5, 4, 0, 1, 1),
("Settings", "Basic settings", "install", 5, 5, 0, 1, 1),
("Board", "Board - main menu group", "board", 2, 1, 0, 1, 0),
("View posts", "View last board posts", "board/index", 2, 2, 6, 1, 0),
("Edit posts", "Edit board posts", "board/update", 2, 3, 6, 1, 0);