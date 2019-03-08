ALTER TABLE `#__juform_forms`   
  ADD COLUMN `hits` INT(11) UNSIGNED DEFAULT 0  NOT NULL AFTER `access`,
  ADD COLUMN `ordering` INT(11) DEFAULT 0  NOT NULL AFTER `publish_down`;

ALTER TABLE `#__juform_fields`   
  ADD COLUMN `prefix_text_mod` VARCHAR(255) NOT NULL AFTER `php_predefined_values`,
  ADD COLUMN `suffix_text_mod` VARCHAR(255) NOT NULL AFTER `prefix_text_mod`;