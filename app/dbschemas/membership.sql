CREATE TABLE `membership` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `actiongroup_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`user_id`,`actiongroup_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;