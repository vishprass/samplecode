CREATE TABLE IF NOT EXISTS `contcactus` (
  ` id` int(10) NOT NULL auto_increment,
  `name` varchar(255) collate latin1_general_ci NOT NULL,
  `email` varchar(255) collate latin1_general_ci NOT NULL,
  `comments` text collate latin1_general_ci NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY  (` id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;
INSERT INTO `menus` (`id`, `name`, `link`, `menutype`, `menuorder`, `access`, `publish`) VALUES
(NULL, 'CONTACT US', './contactus.php', '1',6, NULL, 1);