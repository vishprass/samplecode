-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 10, 2010 at 01:53 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `fmg2`
--

-- --------------------------------------------------------

--
-- Table structure for table `acl_groups`
--

CREATE TABLE IF NOT EXISTS `acl_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `acl_groups`
--

INSERT INTO `acl_groups` (`id`, `name`) VALUES
(1, 'user'),
(2, 'admin'),
(3, 'superadmin');

-- --------------------------------------------------------

--
-- Table structure for table `acl_resources`
--

CREATE TABLE IF NOT EXISTS `acl_resources` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `min_level` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `acl_resources`
--

INSERT INTO `acl_resources` (`id`, `name`, `min_level`) VALUES
(1, 'index', 1),
(2, 'dynamic', 1),
(7, 'contactus', 3),
(6, 'cms', 3),
(8, 'createPage', 2),
(9, 'users', 2),
(10, 'resource', 3),
(11, 'menu', 2),
(12, 'user', 2),
(13, 'cms', 1),
(14, 'index', 3),
(15, 'index', 1),
(16, 'page', 2),
(17, 'adminPanel', 2),
(18, 'tstmny', 2),
(19, 'adcus', 2),
(20, 'contact', 1),
(21, 'news', 1),
(22, 'search', 1),
(23, 'partners', 2),
(24, 'asd', 1);

-- --------------------------------------------------------

--
-- Table structure for table `acl_resource_groups`
--

CREATE TABLE IF NOT EXISTS `acl_resource_groups` (
  `group_id` int(11) NOT NULL,
  `resource_id` int(11) NOT NULL,
  `permit` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `acl_resource_groups`
--


-- --------------------------------------------------------

--
-- Table structure for table `acl_resource_user`
--

CREATE TABLE IF NOT EXISTS `acl_resource_user` (
  `user_id` int(11) NOT NULL,
  `resource_id` int(11) NOT NULL,
  `permit` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `acl_resource_user`
--


-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `parent`, `name`, `description`, `status`, `created`) VALUES
(1, 0, 'office', 'office', 1, '2010-06-08 19:59:55'),
(2, 1, 'pen', 'writing', 1, '2010-06-09 12:51:46'),
(4, 1, 'paper', 'writing', 1, '2010-06-09 11:57:52'),
(5, 1, 'water', 'drinking', 1, '2010-06-09 11:58:33'),
(20, 0, 'beverages', 'soft drinks non alcoholic drink low calories recommended for all ages contains artificial acids no fruits content.', 1, '2010-06-09 16:34:40'),
(16, 12, 'nokia', 'rough n tough', 1, '2010-06-09 15:06:12'),
(15, 12, 'sony errison', 'v good', 1, '2010-06-09 14:57:47'),
(12, 0, 'mobiles 3g', 'talk', 1, '2010-06-09 13:18:27'),
(17, 7, 'a', 'abcd', 1, '2010-06-09 15:07:28'),
(18, 9, 'b', 'abcd', 1, '2010-06-09 15:07:32'),
(19, 1, 'test', 'test', 1, '2010-06-09 15:16:51'),
(21, 20, 'tea', 'good for health', 1, '2010-06-09 16:35:04'),
(22, 20, 'coffee', 'good for brain', 1, '2010-06-09 16:35:24'),
(27, 26, 'test1', 'tes1', 1, '2010-06-09 17:29:14'),
(26, 0, 'test', 'test', 1, '2010-06-09 17:28:52');

-- --------------------------------------------------------

--
-- Table structure for table `cms`
--

CREATE TABLE IF NOT EXISTS `cms` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `pagename` varchar(255) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `body` text,
  `landing_page` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `pageurl` varchar(500) NOT NULL,
  `page_titles` varchar(500) NOT NULL,
  `meta` text,
  `description` text,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;

--
-- Dumping data for table `cms`
--

INSERT INTO `cms` (`id`, `pagename`, `title`, `body`, `landing_page`, `created`, `pageurl`, `page_titles`, `meta`, `description`, `status`) VALUES
(17, 'aboutus', 'old_title_field', '<table style=\\"width: 605px; height: 317px;\\" border=\\"0\\" cellspacing=\\"0\\" cellpadding=\\"0\\">\r\n<tbody>\r\n<tr>\r\n<td>\r\n<p><img style=\\"float: left;\\" src=\\"../../../app/view/themes/media/images/458_front_3-4_big.jpg\\" alt=\\"\\" width=\\"300\\" height=\\"188\\" /></p>\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam nec  velit velit, in pharetra turpis. Suspendisse potenti. Vivamus a nisl  eget enim molestie interdum. Nunc vestibulum dui enim. Sed ullamcorper  ullamcorper turpis, vitae ultrices erat luctus vel. Nam nec erat at  metus ultricies pellentesque lacinia vel odio. Maecenas sit amet erat  turpis, non sodales sem. Nunc in quam vehicula velit pellentesque  luctus. Praesent interdum enim ut lorem vulputate blandit. Vestibulum  ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia  Curae; Quisque non augue lorem.</p>\r\n<p>Mauris eu luctus justo. Suspendisse lectus elit, euismod sit amet  accumsan nec, aliquam vel urna. Mauris vel pellentesque lectus. In magna  odio, varius at placerat quis, porttitor in lacus. Nunc ornare  venenatis mattis. Ut nec erat et nisl bibendum interdum vitae quis enim.  Donec a dolor at nibh mollis adipiscing. Aliquam sit amet mauris nibh,  eu convallis mauris. Pellentesque vulputate erat ut dolor fringilla  bibendum. Nullam quis metus vitae turpis euismod molestie at at dui.  Praesent id aliquam dui. Nunc aliquet nisl massa. Suspendisse at est  congue lectus hendrerit blandit. Nam viverra odio nec nibh tempus  dignissim. Mauris mattis nunc quis ante volutpat vestibulum.  Pellentesque habitant morbi tristique senectus et netus et malesuada  fames ac turpis egestas. Lorem ipsum dolor sit amet, consectetur  adipiscing elit. Praesent placerat diam accumsan velit vulputate ut  egestas libero placerat. Nunc ullamcorper nunc eget libero ornare  aliquet. Morbi leo nisl, rutrum ac viverra at, lobortis quis magna.</p>\r\n<p>check update</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>', 2, '2010-04-07 01:30:09', '', 'check page title editign', 'Check keyword editig', 'check description editing', 1),
(19, 'home', 'old_title_field', '<table style=\\"width: 605px; height: 317px;\\" border=\\"0\\" cellspacing=\\"0\\" cellpadding=\\"0\\">\r\n<tbody>\r\n<tr>\r\n<td style=\\"font-family: verdana; font-size: 13px;\\" height=\\"22\\" valign=\\"top\\">&nbsp;<strong style=\\"color: #302b2c;\\"><img src=\\"../../../app/view/themes/media/images/users/icons.jpg\\" alt=\\"\\" width=\\"24\\" height=\\"22\\" /> Welcome</strong></td>\r\n</tr>\r\n<tr>\r\n<td>&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td align=\\"left\\" valign=\\"top\\">\r\n<table style=\\"width: 100%;\\" border=\\"0\\" cellspacing=\\"0\\" cellpadding=\\"0\\">\r\n<tbody>\r\n<tr>\r\n<td align=\\"left\\" valign=\\"top\\">\r\n<table style=\\"width: 100%;\\" border=\\"0\\" cellspacing=\\"0\\" cellpadding=\\"0\\">\r\n<tbody>\r\n<tr>\r\n<td width=\\"130\\">&nbsp;<img src=\\"../../../app/view/themes/media/images/users/images_welcome.jpg\\" alt=\\"\\" width=\\"130\\" height=\\"91\\" /></td>\r\n<td style=\\"padding-left: 5px;\\" width=\\"76%\\">&nbsp;<strong>Lorem ipsum dolor sit amet, consectuer</strong><br /> Ipsum dolor sit aconsectetuer adipis cing el auris ferment laoreet  aliquam leo. Ut tellus dolor, dapibus eget, elementum vel, cursus  eleifend, elit. Aenean auctor wisi et urna. Aliquam erat volutpat. Duis  ac turpis. Integer rutrum ante eu lacus Amet er ore auris...<br />\r\n<div class=\\"clicklink\\"><a href=\\"file:///C:/Documents%20and%20Settings/siamak/Desktop/Biosfera_html%283%29/Biosfera_html/index.html#\\">Click  here &raquo;</a></div>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>&nbsp;</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td valign=\\"top\\">\r\n<table style=\\"width: 100%;\\" border=\\"0\\" cellspacing=\\"0\\" cellpadding=\\"0\\">\r\n<tbody>\r\n<tr>\r\n<td width=\\"48%\\" align=\\"left\\" valign=\\"top\\">\r\n<table style=\\"width: 100%;\\" border=\\"0\\" cellspacing=\\"0\\" cellpadding=\\"0\\">\r\n<tbody>\r\n<tr>\r\n<td style=\\"font-family: verdana; font-size: 13px;\\" height=\\"22\\" valign=\\"top\\">&nbsp;<strong style=\\"color: #302b2c;\\"><img src=\\"../../../app/view/themes/media/images/users/icons.jpg\\" alt=\\"\\" width=\\"24\\" height=\\"22\\" /> Office Suppliers</strong></td>\r\n</tr>\r\n<tr>\r\n<td align=\\"left\\" valign=\\"top\\">\r\n<table style=\\"width: 100%;\\" border=\\"0\\" cellspacing=\\"0\\" cellpadding=\\"0\\">\r\n<tbody>\r\n<tr>\r\n<td>&nbsp;<img src=\\"../../../app/view/themes/media/images/users/images_water.jpg\\" alt=\\"\\" width=\\"90\\" height=\\"79\\" /></td>\r\n<td style=\\"padding-left: 10px;\\"><strong>Water Delivery</strong><br /> aconsectetuer adipis cing el auris ferment laoreet aliquam leo. Ut  tellus aconsectetuer... <br />\r\n<div class=\\"clicklink\\"><a href=\\"file:///C:/Documents%20and%20Settings/siamak/Desktop/Biosfera_html%283%29/Biosfera_html/index.html#\\">Click  here &raquo;</a></div>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>&nbsp;<img src=\\"../../../app/view/themes/media/images/users/images_insurance.jpg\\" alt=\\"\\" width=\\"90\\" height=\\"79\\" /></td>\r\n<td style=\\"padding-left: 10px;\\">&nbsp;<strong>Insurance</strong><br /> Integer rutrum ante eu lacus. Amet er orem ipsum dolor sit  aconsectetuer adipiscing ell...<br />\r\n<div class=\\"clicklink\\"><a href=\\"file:///C:/Documents%20and%20Settings/siamak/Desktop/Biosfera_html%283%29/Biosfera_html/index.html#\\">Click  here &raquo;</a></div>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n<td width=\\"4%\\" align=\\"center\\"><img src=\\"../../../app/view/themes/media/images/dotted_linenew.jpg\\" alt=\\"\\" width=\\"1\\" height=\\"227\\" /></td>\r\n<td width=\\"48%\\" align=\\"left\\" valign=\\"top\\">\r\n<table style=\\"width: 100%;\\" border=\\"0\\" cellspacing=\\"0\\" cellpadding=\\"0\\">\r\n<tbody>\r\n<tr>\r\n<td style=\\"font-family: verdana; font-size: 13px;\\" height=\\"22\\" valign=\\"top\\">&nbsp;<strong style=\\"color: #302b2c;\\"><img src=\\"../../../app/view/themes/media/images/users/icons.jpg\\" alt=\\"\\" width=\\"24\\" height=\\"22\\" /> Our Products</strong></td>\r\n</tr>\r\n<tr>\r\n<td align=\\"left\\" valign=\\"top\\">\r\n<table style=\\"width: 100%;\\" border=\\"0\\" cellspacing=\\"0\\" cellpadding=\\"0\\">\r\n<tbody>\r\n<tr>\r\n<td>&nbsp;\r\n<div class=\\"text\\" style=\\"padding-left: 10px;\\"><strong>Our Products</strong><br /> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam metus  arcu, condimentum nec, tempor quis, malesuada vel, ante. ligula.</div>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\\"padding-left: 20px;\\">&nbsp; {DATA.LINK}<br />\r\n<div id=\\"product_link\\">\r\n<ul>\r\n</ul>\r\n</div>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>', 1, '2010-04-07 02:33:50', '', 'First Media Partners', 'fmg partners, fmg business', 'fmg partners, fmg business', 1),
(29, 'contactus', 'old_title_field', '<table border=\\"0\\">\r\n<tbody>\r\n<tr>\r\n</tr>\r\n<tr>\r\n<td>&nbsp;</td>\r\n<td class=\\"objective\\">Contact Us Here ..............<br /></td>\r\n</tr>\r\n</tbody>\r\n</table>', 3, '2010-04-14 12:25:48', '', 'Rasmus Lerdorf', 'hello', 'php', 1),
(34, 'test', 'old_title_field', '<p>test</p>', 0, '2010-06-22 17:49:14', '', 'test', 'test', 'test', 1),
(33, 'sa', 'old_title_field', '<div id=\\"wrapper\\">\r\n<p>h,j.l</p>\r\n</div>', 0, '2010-06-17 17:12:43', '', 'ourproducts', 'ourproducts', 'ourproducts', 1);

-- --------------------------------------------------------

--
-- Table structure for table `contactus`
--

CREATE TABLE IF NOT EXISTS `contactus` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  `units` int(11) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `state` varchar(250) DEFAULT NULL,
  `city` varchar(250) DEFAULT NULL,
  `zip` varchar(7) DEFAULT NULL,
  `message` text,
  `created` datetime DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `contactus`
--

INSERT INTO `contactus` (`id`, `name`, `company`, `email`, `telephone`, `units`, `street`, `state`, `city`, `zip`, `message`, `created`, `status`) VALUES
(12, 'secondary', NULL, NULL, '121-111-1212', 0, 'Street', 'PE', 'City', 'Zip', NULL, NULL, NULL),
(11, 'secondary', NULL, NULL, '111-111-1111', 0, 'Street', 'AK', 'City', 'Zip', NULL, NULL, NULL),
(8, 'secondary', NULL, NULL, '111-111-1111', 0, 'Street', '- State -', 'City', 'Zip', NULL, NULL, NULL),
(10, 'primary', NULL, NULL, '111-111-1112', 0, 'Street', 'WV', 'City', '11111', NULL, NULL, NULL),
(9, 'primary', NULL, NULL, '111-111-1111', 0, 'Street', '- State -', 'City', 'Zip', NULL, NULL, NULL),
(13, 'primary', NULL, NULL, '903-585-8534', 0, 'Street', 'QC', 'City', 'Zip', NULL, NULL, NULL),
(14, 'secondary', NULL, NULL, '939-308-0861', 0, 'Street', 'YT', 'City', 'Zip', NULL, NULL, NULL),
(15, 'primary', NULL, NULL, '939-308-0861', 0, 'Street', 'AZ', 'City', 'Zip', NULL, NULL, NULL),
(16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(18, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(19, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(20, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(21, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(22, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(23, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(24, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(25, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(27, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `contcactus`
--

CREATE TABLE IF NOT EXISTS `contcactus` (
  ` id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `email` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `comments` text COLLATE latin1_general_ci NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (` id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `contcactus`
--


-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE IF NOT EXISTS `menus` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `label` varchar(100) DEFAULT NULL,
  `parent` int(10) NOT NULL DEFAULT '0',
  `link` varchar(255) DEFAULT NULL,
  `linktype` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1-external,2-internal',
  `menuorder` tinyint(4) DEFAULT NULL,
  `publish` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `label`, `parent`, `link`, `linktype`, `menuorder`, `publish`) VALUES
(13, 'About Us', 0, 'test', 2, 12, 1),
(14, 'Home', 0, 'contactus', 2, 9, 1),
(25, 'test2', 0, 'aboutus', 2, 13, 1);

-- --------------------------------------------------------

--
-- Table structure for table `menu_setup`
--

CREATE TABLE IF NOT EXISTS `menu_setup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(100) NOT NULL,
  `enable` tinyint(1) NOT NULL,
  `displaytype` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `menu_setup`
--

INSERT INTO `menu_setup` (`id`, `type`, `enable`, `displaytype`) VALUES
(1, 'topmenu', 1, 'suckerfish'),
(2, 'Left Menu', 0, NULL),
(3, 'Right Menu', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `pageid` int(10) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `body` text,
  `image_path` varchar(100) NOT NULL,
  `created` datetime DEFAULT NULL,
  `status` tinyint(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `pageid`, `title`, `body`, `image_path`, `created`, `status`) VALUES
(1, 1, 'qwertyu', 'orem Ipsum is simply dummy text of the printing and  typesetting industry. Lorem Ipsum has been the industry\\''s standard dummy  text ever since the 1', '', '2010-03-18 14:56:32', 1),
(3, 2, 'fgfgjj', 'orem Ipsum is simply dummy text of the printing and  typesetting industry. Lorem Ipsum has been the industry\\''s standard dummy  text ever since the 1', '', '2010-03-18 15:03:47', 1),
(4, 3, 'cghmxhgm', 'orem Ipsum is simply dummy text of the printing and  typesetting industry. Lorem Ipsum has been the industry\\''s standard dummy  text ever since the 1', '', '2010-03-18 15:03:57', 1),
(5, 4, 'help me site map', 'orem Ipsum is simply dummy text of the printing and  typesetting industry. Lorem Ipsum has been the industry\\''s standard dummy  text ever since the 1', '', '2010-03-18 15:04:03', 1);

-- --------------------------------------------------------

--
-- Table structure for table `page_modules`
--

CREATE TABLE IF NOT EXISTS `page_modules` (
  `module_id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `page_modules`
--

INSERT INTO `page_modules` (`module_id`, `page_id`) VALUES
(3, 20),
(1, 20),
(1, 21),
(1, 22),
(3, 22),
(1, 23),
(3, 23),
(1, 24),
(3, 24),
(1, 25),
(3, 25);

-- --------------------------------------------------------

--
-- Table structure for table `partners`
--

CREATE TABLE IF NOT EXISTS `partners` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL,
  `logo` varchar(100) NOT NULL COMMENT 'logo name ',
  `status` tinyint(2) DEFAULT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `partners`
--

INSERT INTO `partners` (`id`, `name`, `url`, `logo`, `status`, `created`) VALUES
(1, 'Mejo George', 'http://www.npd.com', '6B32AF734166.jpg', 1, '2010-03-30 05:59:53');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `description` text NOT NULL,
  `longdescription` text NOT NULL,
  `image` varchar(50) NOT NULL,
  `price` float NOT NULL,
  `category` varchar(255) NOT NULL,
  `code` bigint(20) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=78 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `longdescription`, `image`, `price`, `category`, `code`, `status`, `created`) VALUES
(65, 'whfgdhf', 'hjghjghd', '<p>gfhgfhgfgh</p>', '', 34234, '2', 2342354463, 1, '2010-06-15 13:20:50'),
(66, 'image test final', 'the test of image size', '<p>dhgfshsfdfhdfggftttttttttttttttteeeeeeeeeeeeeeee</p>', '', 221, '1', 656545, 1, '2010-06-15 13:40:41'),
(77, 'adsd', 'vgfgf', '<p>fbngn</p>', '43B4D5D292DC.jpg', 43, '2', 578876797798, 1, '2010-06-25 12:03:21'),
(76, 'ghha', 'sd', '<p>dd</p>', '2632494BA7A6.jpg', 2, '2', 346475687887, 1, '2010-06-25 12:03:04'),
(70, 'a', 'a', '<p>a</p>', '233D28632A5E.jpg', 1, '2', 11, 1, '2010-06-25 11:59:53'),
(71, 'aa', 'a', '<p>a</p>', '3122EBBA12B5.jpg', 1, '2', 111111111111, 1, '2010-06-25 12:00:33'),
(72, 'aaa', 'q', '<p>q</p>', '38E5BB5B943B.jpg', 1, '4', 0, 1, '2010-06-25 12:00:51'),
(73, 'aaaa', 'a', '<p>a</p>', '46F8BB3CD874.jpg', 159, '2', 222233333333, 1, '2010-06-25 12:01:27'),
(74, 'aaa', 'eed', '<p>dd</p>', '62464FFB7E95.jpg', 2, '2', 909089087877, 1, '2010-06-25 12:02:23'),
(75, 'are', 'ff', '<p>ff</p>', '9756F2A35A7A.jpg', 3, '2', 987686547543, 1, '2010-06-25 12:02:46'),
(69, 'add today', 'to check again we are testing', '<p>to check agajhskjdheu ehdfkjs fkjf djhf sdjkfh sdkjfheiurf eiurywiu rfjdgfsdgfiur fwruif wiurf iurf rifw</p>', '9A18D9FA43A2.jpg', 561, '2:4', 2564, 1, '2010-06-16 20:00:59'),
(68, 'final test', 'the testtttttttt', '<p>test of ttttttttttttttt eeeeeeeeeeeeeeee ttttttttttttttttttttt gggggggggggggggggg vvvvvv</p>', '1BEC57CCB96A.jpg', 159, '2', 12354, 1, '2010-06-15 20:23:27');

-- --------------------------------------------------------

--
-- Table structure for table `testimonies`
--

CREATE TABLE IF NOT EXISTS `testimonies` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `pageid` int(10) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `body` text,
  `created` datetime DEFAULT NULL,
  `status` tinyint(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `testimonies`
--

INSERT INTO `testimonies` (`id`, `pageid`, `title`, `body`, `created`, `status`) VALUES
(5, 4, 'News', 'AMI is a privately held corporation that operates as a cooperative  organization with all its Associates. AMI has a mission statement that clearly addresses our client&rsquo;s  requirements.', '2010-03-18 15:04:03', 1),
(8, 0, 'whats up', 'Many more to come.. dasdas. .. dasdasd...', '2010-04-15 10:03:51', 1),
(7, 0, 'todays highlight', 'something happened at adasd', '2010-04-13 10:27:25', 1),
(9, 0, 'india wins fifa World Cup', '<p>india wins fifa wc by beating brazil by 100-0</p>', '2010-06-10 19:03:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `uimodules`
--

CREATE TABLE IF NOT EXISTS `uimodules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `sequence` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `uimodules`
--

INSERT INTO `uimodules` (`id`, `name`, `sequence`) VALUES
(1, 'news', 2),
(2, 'news-flash', 3),
(3, 'signup', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(100) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `accesslevel` tinyint(2) DEFAULT NULL,
  `status` tinyint(2) DEFAULT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `username`, `password`, `email`, `accesslevel`, `status`, `created`) VALUES
(8, 'Vibhore', 'vibhor', '96e79218965eb72c92a549dd5a330112', 'vibhore@tli.com', 3, 1, '2010-03-12 09:42:23'),
(9, 'Admin', 'admin', 'b59c67bf196a4758191e42f76670ceba', 'admin@tlicms.com', 3, 1, '2010-03-12 09:42:57'),
(13, 'Myname', 'user', 'b59c67bf196a4758191e42f76670ceba', 'bishnudec25@gmail.com', 2, 1, '2010-03-17 13:42:44'),
(15, 'Shini', 'shini', 'b59c67bf196a4758191e42f76670ceba', 'shini.g@tlisoftware.com', 3, 1, '2010-03-19 13:03:34'),
(16, 'Mejo', 'mejor', 'b59c67bf196a4758191e42f76670ceba', 'mejo@cosmos.com', 3, 1, '2010-03-24 10:05:01'),
(17, 'Siamak', 'siamakk', 'b59c67bf196a4758191e42f76670ceba', 'siamak.m@tlisoftware.com', 3, 1, '2010-06-17 09:58:01');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
