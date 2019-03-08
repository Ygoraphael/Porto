

CREATE TABLE IF NOT EXISTS `#__wdsfacebookkeywords` (
  `discription` varchar(200) NOT NULL,
  `linkurl` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `#__wdskeywords`
--

INSERT INTO `#__wdsfacebookkeywords` (`discription`, `linkurl`) VALUES
('Website Maintenance', 'http://www.webdesignservices.net'),
('Online Marketing Firm', '	http://www.webdesignservices.net'),
('Web Design Company', 'http://www.webdesignservices.net'),
('Web Design', 'http://www.webdesignservices.net'),
('Web Designers', 'http://www.webdesignservices.net'),
('Web Design Firms', 'http://www.webdesignservices.net'),
('Website support', 'http://www.webdesignservices.net/website-packages-extensions/category/40-website-maintenance-website-support.html'),
('SEO Services', 'http://www.webdesignservices.net/services/search-engine-optimization.html')
;

-- --------------------------------------------------------

--
-- Table structure for table `#__wdskeywords_select`
--

CREATE TABLE IF NOT EXISTS `#__wdsfacebookkeywords_select` (
  `discription` varchar(200) NOT NULL,
  `linkurl` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `#__wdskeywords_select`
--

INSERT INTO `#__wdsfacebookkeywords_select` (`discription`, `linkurl`) SELECT `discription`,`linkurl` FROM `#__wdsfacebookkeywords` ORDER BY RAND() LIMIT 1;