CREATE TABLE `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class` varchar(45) DEFAULT NULL,
  `method` varchar(45) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `log` varchar(300) DEFAULT NULL,
  `datetime` varchar(45) DEFAULT NULL,
  `userid` varchar(45) DEFAULT NULL,
  `userip` varchar(45) DEFAULT NULL,
  `useragent` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;