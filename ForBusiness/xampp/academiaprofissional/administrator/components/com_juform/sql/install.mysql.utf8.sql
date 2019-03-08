/*Table structure for table `#__juform_backend_permission` */

DROP TABLE IF EXISTS `#__juform_backend_permission`;

CREATE TABLE `#__juform_backend_permission` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(11) unsigned NOT NULL DEFAULT '0',
  `permission` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_groupid` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `#__juform_backend_permission` */

/*Table structure for table `#__juform_emails` */

DROP TABLE IF EXISTS `#__juform_emails`;

CREATE TABLE `#__juform_emails` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `form_id` int(11) unsigned NOT NULL,
  `from` varchar(255) NOT NULL,
  `from_name` varchar(255) NOT NULL,
  `recipients` text NOT NULL,
  `cc` text NOT NULL,
  `bcc` text NOT NULL,
  `reply_to` text NOT NULL,
  `reply_to_name` text NOT NULL,
  `subject` varchar(255) NOT NULL DEFAULT '',
  `message` text NOT NULL,
  `mode` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `attachments` text NOT NULL,
  `language` char(7) NOT NULL,
  `send_mail_condition` VARCHAR(2) NOT NULL,
  `ordering` int(11) NOT NULL DEFAULT '0',
  `published` tinyint(3) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_formid_published` (`form_id`,`published`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `#__juform_emails` */

/*Table structure for table `#__juform_emails_conditions` */

DROP TABLE IF EXISTS `#__juform_emails_conditions`;

CREATE TABLE `#__juform_emails_conditions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email_id` int(11) unsigned NOT NULL,
  `field_id` int(11) unsigned NOT NULL,
  `operator` varchar(2) NOT NULL,
  `value` varchar(128) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_emailid` (`email_id`),
  KEY `idx_fieldid` (`field_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `#__juform_emails_conditions` */

/*Table structure for table `#__juform_fields` */

DROP TABLE IF EXISTS `#__juform_fields`;

CREATE TABLE `#__juform_fields` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `form_id` int(11) unsigned NOT NULL DEFAULT '0',
  `plugin_id` int(11) unsigned NOT NULL DEFAULT '0',
  `caption` varchar(255) NOT NULL DEFAULT '',
  `field_name` varchar(128) NOT NULL,
  `hide` tinyint(3) DEFAULT '0',
  `hide_caption` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `hide_label` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `attributes` varchar(1024) NOT NULL,
  `predefined_values_type` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `predefined_values` text NOT NULL,
  `php_predefined_values` mediumtext NOT NULL,
  `prefix_text_mod` varchar(255) NOT NULL,
  `suffix_text_mod` varchar(255) NOT NULL,
  `prefix_text_display` varchar(255) NOT NULL,
  `suffix_text_display` varchar(255) NOT NULL,
  `prefix_suffix_wrapper` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `simple_search` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `advanced_search` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `allow_priority` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `priority` int(11) NOT NULL DEFAULT '0',
  `priority_direction` varchar(8) NOT NULL DEFAULT 'asc',
  `backend_list_view` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `backend_list_view_ordering` int(11) NOT NULL DEFAULT '0',
  `required` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  `access` int(11) unsigned NOT NULL DEFAULT '1',
  `published` tinyint(3) NOT NULL DEFAULT '0',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `ignored_options` varchar(1024) NOT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `idx_groupid` (`form_id`),
  KEY `idx_fieldname` (`field_name`),
  KEY `idx_publishing` (`published`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `#__juform_fields` */

/*Table structure for table `#__juform_fields_actions` */

DROP TABLE IF EXISTS `#__juform_fields_actions`;

CREATE TABLE `#__juform_fields_actions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `form_id` int(11) unsigned NOT NULL,
  `field_id` int(11) unsigned NOT NULL,
  `condition` varchar(3) NOT NULL,
  `action` varchar(32) NOT NULL,
  `ordering` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_formid` (`form_id`),
  KEY `idx_fieldid` (`field_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `#__juform_fields_actions` */

/*Table structure for table `#__juform_fields_calculations` */

DROP TABLE IF EXISTS `#__juform_fields_calculations`;

CREATE TABLE `#__juform_fields_calculations` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `form_id` int(11) unsigned NOT NULL,
  `field_id` int(11) unsigned NOT NULL,
  `expression` text NOT NULL,
  `ordering` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_formid` (`form_id`),
  KEY `idx_fieldid` (`field_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `#__juform_fields_calculations` */

/*Table structure for table `#__juform_fields_conditions` */

DROP TABLE IF EXISTS `#__juform_fields_conditions`;

CREATE TABLE `#__juform_fields_conditions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `action_id` int(11) unsigned NOT NULL,
  `field_id` int(11) unsigned NOT NULL,
  `operator` varchar(2) NOT NULL,
  `value` varchar(128) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_actionid` (`action_id`),
  KEY `idx_fieldid` (`field_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `#__juform_fields_conditions` */

/*Table structure for table `#__juform_fields_values` */

DROP TABLE IF EXISTS `#__juform_fields_values`;

CREATE TABLE `#__juform_fields_values` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `submission_id` int(11) unsigned NOT NULL DEFAULT '0',
  `field_id` int(11) unsigned NOT NULL DEFAULT '0',
  `value` mediumtext NOT NULL,
  `counter` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_fieldid_formid` (`field_id`,`submission_id`),
  KEY `idx_formid` (`submission_id`),
  KEY `idx_value` (`value`(8))
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `#__juform_fields_values` */

/*Table structure for table `#__juform_forms` */

DROP TABLE IF EXISTS `#__juform_forms`;

CREATE TABLE `#__juform_forms` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `save_submission` tinyint(3) NOT NULL,
  `show_title` tinyint(3) NOT NULL,
  `required_label` varchar(256) NOT NULL,
  `attributes` varchar(1024) NOT NULL,
  `template_id` int(11) unsigned NOT NULL,
  `template_type` tinyint(3) NOT NULL,
  `template_code` longtext NOT NULL,
  `template_params` text NOT NULL,
  `access` int(11) unsigned NOT NULL DEFAULT '0',
  `hits` int(11) unsigned NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) unsigned NOT NULL DEFAULT '0',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(11) unsigned NOT NULL DEFAULT '0',
  `published` tinyint(3) NOT NULL DEFAULT '0',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `metatitle` varchar(255) NOT NULL,
  `metakeyword` varchar(1024) NOT NULL,
  `metadescription` varchar(1024) NOT NULL,
  `metadata` varchar(2048) NOT NULL,
  `php_ondisplay` text NOT NULL,
  `php_onbeforeprocess` text NOT NULL,
  `php_onprocess` text NOT NULL,
  `php_onsendemail` text NOT NULL,
  `afterprocess_action` varchar(255) NOT NULL,
  `afterprocess_action_value` text NOT NULL,
  `stylesheet` text NOT NULL,
  `stylesheet_declaration` text NOT NULL,
  `javascript` text NOT NULL,
  `javascript_declaration` text NOT NULL,
  `post_to_location` tinyint(3) NOT NULL,
  `silent_post` tinyint(3) NOT NULL,
  `post_method` varchar(8) NOT NULL,
  `post_url` varchar(512) NOT NULL,
  `params` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_title` (`title`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_alias` (`alias`),
  KEY `idx_user_forms` (`created_by`,`published`,`publish_up`,`publish_down`),
  KEY `idx_publishing` (`published`,`publish_up`,`publish_down`),
  KEY `idx_created` (`created`),
  FULLTEXT KEY `idx_desc` (`description`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `#__juform_forms` */

/*Table structure for table `#__juform_plugins` */

DROP TABLE IF EXISTS `#__juform_plugins`;

CREATE TABLE `#__juform_plugins` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(32) NOT NULL DEFAULT 'field',
  `title` varchar(255) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `version` varchar(64) NOT NULL,
  `author` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL,
  `date` varchar(64) NOT NULL,
  `license` varchar(255) NOT NULL,
  `folder` varchar(255) NOT NULL,
  `default` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `params` text NOT NULL,
  `extension_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_type` (`type`),
  KEY `idx_folder` (`folder`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_extension_id` (`extension_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `#__juform_plugins` */

insert  into `#__juform_plugins`(`id`,`type`,`title`,`description`,`version`,`author`,`email`,`website`,`date`,`license`,`folder`,`default`,`checked_out`,`checked_out_time`,`params`,`extension_id`) values (1,'field','Text','','1.0','JoomUltra','admin@joomultra.com','http://www.joomultra.com','01 April 2015','GNU/GPL','text',1,0,'0000-00-00 00:00:00','',0);
insert  into `#__juform_plugins`(`id`,`type`,`title`,`description`,`version`,`author`,`email`,`website`,`date`,`license`,`folder`,`default`,`checked_out`,`checked_out_time`,`params`,`extension_id`) values (2,'field','Date Time','','1.0','JoomUltra','admin@joomultra.com','http://www.joomultra.com','01 April 2015','GNU/GPL','datetime',1,0,'0000-00-00 00:00:00','',0);
insert  into `#__juform_plugins`(`id`,`type`,`title`,`description`,`version`,`author`,`email`,`website`,`date`,`license`,`folder`,`default`,`checked_out`,`checked_out_time`,`params`,`extension_id`) values (3,'field','Textarea','','1.0','JoomUltra','admin@joomultra.com','http://www.joomultra.com','01 April 2015','GNU/GPL','textarea',1,0,'0000-00-00 00:00:00','',0);
insert  into `#__juform_plugins`(`id`,`type`,`title`,`description`,`version`,`author`,`email`,`website`,`date`,`license`,`folder`,`default`,`checked_out`,`checked_out_time`,`params`,`extension_id`) values (4,'field','Radio','','1.0','JoomUltra','admin@joomultra.com','http://www.joomultra.com','01 April 2015','GNU/GPL','radio',1,0,'0000-00-00 00:00:00','',0);
insert  into `#__juform_plugins`(`id`,`type`,`title`,`description`,`version`,`author`,`email`,`website`,`date`,`license`,`folder`,`default`,`checked_out`,`checked_out_time`,`params`,`extension_id`) values (5,'field','Checkboxes','','1.0','JoomUltra','admin@joomultra.com','http://www.joomultra.com','01 April 2015','GNU/GPL','checkboxes',1,0,'0000-00-00 00:00:00','',0);
insert  into `#__juform_plugins`(`id`,`type`,`title`,`description`,`version`,`author`,`email`,`website`,`date`,`license`,`folder`,`default`,`checked_out`,`checked_out_time`,`params`,`extension_id`) values (6,'field','Dropdown List','','1.0','JoomUltra','admin@joomultra.com','http://www.joomultra.com','01 April 2015','GNU/GPL','dropdownlist',1,0,'0000-00-00 00:00:00','',0);
insert  into `#__juform_plugins`(`id`,`type`,`title`,`description`,`version`,`author`,`email`,`website`,`date`,`license`,`folder`,`default`,`checked_out`,`checked_out_time`,`params`,`extension_id`) values (7,'field','Multiple Select','','1.0','JoomUltra','admin@joomultra.com','http://www.joomultra.com','01 April 2015','GNU/GPL','multipleselect',1,0,'0000-00-00 00:00:00','',0);
insert  into `#__juform_plugins`(`id`,`type`,`title`,`description`,`version`,`author`,`email`,`website`,`date`,`license`,`folder`,`default`,`checked_out`,`checked_out_time`,`params`,`extension_id`) values (8,'field','Files','','1.0','JoomUltra','admin@joomultra.com','http://www.joomultra.com','01 April 2015','GNU/GPL','files',1,0,'0000-00-00 00:00:00','',0);
insert  into `#__juform_plugins`(`id`,`type`,`title`,`description`,`version`,`author`,`email`,`website`,`date`,`license`,`folder`,`default`,`checked_out`,`checked_out_time`,`params`,`extension_id`) values (9,'field','Images','','1.0','JoomUltra','admin@joomultra.com','http://www.joomultra.com','01 April 2015','GNU/GPL','images',1,0,'0000-00-00 00:00:00','',0);
insert  into `#__juform_plugins`(`id`,`type`,`title`,`description`,`version`,`author`,`email`,`website`,`date`,`license`,`folder`,`default`,`checked_out`,`checked_out_time`,`params`,`extension_id`) values (10,'field','Media','','1.0','JoomUltra','admin@joomultra.com','http://www.joomultra.com','01 April 2015','GNU/GPL','media',1,0,'0000-00-00 00:00:00','',0);
insert  into `#__juform_plugins`(`id`,`type`,`title`,`description`,`version`,`author`,`email`,`website`,`date`,`license`,`folder`,`default`,`checked_out`,`checked_out_time`,`params`,`extension_id`) values (11,'field','Free Text','','1.0','JoomUltra','admin@joomultra.com','http://www.joomultra.com','01 April 2015','GNU/GPL','freetext',1,0,'0000-00-00 00:00:00','',0);
insert  into `#__juform_plugins`(`id`,`type`,`title`,`description`,`version`,`author`,`email`,`website`,`date`,`license`,`folder`,`default`,`checked_out`,`checked_out_time`,`params`,`extension_id`) values (12,'field','Captcha','','1.0','JoomUltra','admin@joomultra.com','http://www.joomultra.com','01 April 2015','GNU/GPL','captcha',1,0,'0000-00-00 00:00:00','',0);
insert  into `#__juform_plugins`(`id`,`type`,`title`,`description`,`version`,`author`,`email`,`website`,`date`,`license`,`folder`,`default`,`checked_out`,`checked_out_time`,`params`,`extension_id`) values (13,'field','Submit Button','','1.0','JoomUltra','admin@joomultra.com','http://www.joomultra.com','01 April 2015','GNU/GPL','submitbutton',1,0,'0000-00-00 00:00:00','',0);
insert  into `#__juform_plugins`(`id`,`type`,`title`,`description`,`version`,`author`,`email`,`website`,`date`,`license`,`folder`,`default`,`checked_out`,`checked_out_time`,`params`,`extension_id`) values (14,'field','Begin Page','','1.0','JoomUltra','admin@joomultra.com','http://www.joomultra.com','01 April 2015','GNU/GPL','beginpage',1,0,'0000-00-00 00:00:00','',0);
insert  into `#__juform_plugins`(`id`,`type`,`title`,`description`,`version`,`author`,`email`,`website`,`date`,`license`,`folder`,`default`,`checked_out`,`checked_out_time`,`params`,`extension_id`) values (15,'field','End Page','','1.0','JoomUltra','admin@joomultra.com','http://www.joomultra.com','01 April 2015','GNU/GPL','endpage',1,0,'0000-00-00 00:00:00','',0);
insert  into `#__juform_plugins`(`id`,`type`,`title`,`description`,`version`,`author`,`email`,`website`,`date`,`license`,`folder`,`default`,`checked_out`,`checked_out_time`,`params`,`extension_id`) values (16,'template','Default','Default JUForm Template','1.0','JoomUltra','admin@joomultra.com','http://www.joomultra.com','01 April 2015','GNU/GPL','default',1,0,'0000-00-00 00:00:00','',0);
insert  into `#__juform_plugins`(`id`,`type`,`title`,`description`,`version`,`author`,`email`,`website`,`date`,`license`,`folder`,`default`,`checked_out`,`checked_out_time`,`params`,`extension_id`) values (17,'template','Default - Bootstrap 2','Default JUForm Template - Bootstrap 2','1.0','JoomUltra','admin@joomultra.com','http://www.joomultra.com','01 April 2015','GNU/GPL','default_bs2',1,0,'0000-00-00 00:00:00','',0);

/*Table structure for table `#__juform_submissions` */

DROP TABLE IF EXISTS `#__juform_submissions`;

CREATE TABLE `#__juform_submissions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `form_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `platform` varchar(45) NOT NULL,
  `browser` varchar(255) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `ip_address` varchar(40) NOT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(11) unsigned NOT NULL,
  `checked_out` int(11) unsigned NOT NULL,
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `idx_formid` (`form_id`),
  KEY `idx_userid` (`user_id`),
  KEY `idx_checkout` (`checked_out`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `#__juform_submissions` */