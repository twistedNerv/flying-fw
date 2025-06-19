CREATE TABLE `devmodule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `testtext` varchar(45) DEFAULT NULL,
  `testpassword` varchar(45) DEFAULT NULL,
  `testnumber` varchar(45) DEFAULT NULL,
  `testdescription` longtext DEFAULT NULL,
  `testeditor` longtext DEFAULT NULL,
  `testemail` varchar(45) DEFAULT NULL,
  `testdate` varchar(45) DEFAULT NULL,
  `testcolor` varchar(45) DEFAULT NULL,
  `testselect` varchar(45) DEFAULT NULL,
  `testradio` varchar(45) DEFAULT NULL,
  `testcheckbox` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci