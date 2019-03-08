ALTER TABLE `#__juform_fields_actions`  
  ENGINE=MYISAM;

ALTER TABLE `#__juform_fields_conditions`  
  ENGINE=MYISAM;

ALTER TABLE `#__juform_submissions`  
  ENGINE=MYISAM;

ALTER TABLE `#__juform_emails`   
  ADD COLUMN `send_mail_condition` VARCHAR(2) NOT NULL AFTER `language`;

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