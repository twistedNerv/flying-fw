CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `surname` varchar(45) NOT NULL,
  `username` varchar(45) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `location` varchar(45) DEFAULT NULL,
  `description` longtext,
  `level` int(11) NOT NULL DEFAULT '2',
  `active` int(11) DEFAULT '1',
  `lastloginDT` varchar(45) DEFAULT NULL,
  `lastloginIP` varchar(45) DEFAULT NULL,
  `createdDT` varchar(45) DEFAULT NULL,
  `createdIP` varchar(45) DEFAULT NULL,
  `theme` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

INSERT INTO `user` (`name`, `surname`, `username`, `password`, `email`, `level`, `active`, `theme`) VALUES 
("Flying", "Framework", "ffw", "$2y$10$FmSqt6i683A5uKtNXZMSmuvpYtMN4e7.1N3D2n0Nf.aLmLhWnsTeK", "test@test.test", 5, 1, "default");