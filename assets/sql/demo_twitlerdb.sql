
 
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
 
-- --------------------------------------------------------

--
-- Table structure for table `demo_twitlerdb`
--

CREATE TABLE `demo_twitlerdb` (
  `id` int(10) NOT NULL auto_increment,
  `uid` varchar(16) collate utf8_unicode_ci NOT NULL,
  `sname` varchar(45) collate utf8_unicode_ci NOT NULL,
  `tweet` varchar(140) collate utf8_unicode_ci NOT NULL default '',
  `dt` datetime NOT NULL default '0000-00-00 00:00:00',
  `name` varchar(90) collate utf8_unicode_ci NOT NULL,
  `email` varchar(100) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=50 ;

--
-- Dumping data for table `demo_twitlerdb`
--

INSERT INTO `demo_twitlerdb` VALUES(1, '81411014', 'SenorDre', 'Hello World', '2014-03-14 10:15:17', 'test', 'test@test.com');
 
