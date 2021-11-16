CREATE TABLE `devmodule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `testtext` varchar(45) COLLATE utf8_slovenian_ci DEFAULT NULL,
  `testpassword` varchar(45) COLLATE utf8_slovenian_ci DEFAULT NULL,
  `testnumber` varchar(45) COLLATE utf8_slovenian_ci DEFAULT NULL,
  `testdescription` longtext COLLATE utf8_slovenian_ci DEFAULT NULL,
  `testeditor` longtext COLLATE utf8_slovenian_ci DEFAULT NULL,
  `testemail` varchar(45) COLLATE utf8_slovenian_ci DEFAULT NULL,
  `testdate` varchar(45) COLLATE utf8_slovenian_ci DEFAULT NULL,
  `testcolor` varchar(45) COLLATE utf8_slovenian_ci DEFAULT NULL,
  `testselect` varchar(45) COLLATE utf8_slovenian_ci DEFAULT NULL,
  `testradio` varchar(45) COLLATE utf8_slovenian_ci DEFAULT NULL,
  `testcheckbox` varchar(45) COLLATE utf8_slovenian_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci