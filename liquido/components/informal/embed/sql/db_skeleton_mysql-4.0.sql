CREATE TABLE `entryform` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `position` smallint(5) unsigned NOT NULL default '0',
  `type` smallint(5) unsigned NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `name_short` varchar(30) NOT NULL default '',
  `mandatory` enum('N','Y') NOT NULL default 'N',
  `public` enum('Y','N') NOT NULL default 'Y',
  `test_email` enum('N','Y') NOT NULL default 'N',
  `options` text NOT NULL,
  UNIQUE KEY `id` (`id`)
) TYPE=MyISAM ;

CREATE TABLE `entryform_settings` (
  `id` smallint(4) unsigned NOT NULL auto_increment,
  `form_name` varchar(255) NOT NULL default '',
  `form_email` enum('N','Y') NOT NULL default 'N',
  `form_email_address` varchar(255) NOT NULL default '',
  `form_submit_label` varchar(255) NOT NULL default '',
  `thank_you_message` varchar(255) NOT NULL default '',
  `thank_you_url` varchar(255) NOT NULL default '',
  UNIQUE KEY `id` (`id`)
) TYPE=MyISAM ;

INSERT INTO `entryform_settings` VALUES (1, 'RPL_DATABASE_NAME', 'N', 'RPL_DATABASE_EMAIL', 'Submit Application', 'Thank you for filling out our form!', 'http://informal.benn.org/');

CREATE TABLE `form_element_types` (
  `id` tinyint(4) unsigned NOT NULL auto_increment,
  `name` varchar(30) NOT NULL default '',
  `long_name` varchar(100) NOT NULL default '',
  `with_value` enum('Y','N') NOT NULL default 'Y',
  `html` text NOT NULL,
  `options` text NOT NULL,
  `sql` text NOT NULL,
  UNIQUE KEY `id` (`id`)
) TYPE=MyISAM ;

INSERT INTO `form_element_types` VALUES (1, 'design_text', 'Text paragraph', 'N', '<p>\r\nRPL_TEXT\r\n</p>\r\n', '<options>\r\n<headline></headline>\r\n<text></text>\r\n</options>', '');
INSERT INTO `form_element_types` VALUES (2, 'text', 'Textfield (1 line)', 'Y', '<p>\r\nRPL_name RPL_star<br />\r\n<input type="text" name="RPL_element_name" size="RPL_size" maxlength="RPL_maxlength" value="RPL_value" class="inputText">\r\n</p>\r\n', '<options>\r\n<size>20</size>\r\n<maxlength>20</maxlength>\r\n</options>\r\n', 'ALTER TABLE `submissions` ADD `elementRPL_entry_form_id` VARCHAR( 255 ) NOT NULL ;');
INSERT INTO `form_element_types` VALUES (3, 'textarea', 'Textfield (several lines)', 'Y', '<p>\r\nRPL_name RPL_star<br />\r\n<textarea name="RPL_element_name" cols="RPL_cols" rows="RPL_rows" class="inputText">RPL_value</textarea>\r\n</p>\r\n', '<options>\r\n<cols>30</cols>\r\n<rows>4</rows>\r\n</options>\r\n', 'ALTER TABLE `submissions` ADD `elementRPL_entry_form_id` TEXT NOT NULL');
INSERT INTO `form_element_types` VALUES (4, 'radio', 'Radio button set', 'Y', '<p>\r\nRPL_name RPL_star<br />\r\nRPL_radio_buttons\r\n</p>\r\n', '<options>\r\n<option>Option2</option>\r\n<option>Option1</option>\r\n<selected>1</selected>\r\n</options>\r\n', 'ALTER TABLE `submissions` ADD `elementRPL_entry_form_id` VARCHAR( 255 ) NOT NULL');

CREATE TABLE `lists` (
  `id` tinyint(5) unsigned NOT NULL auto_increment,
  `name` varchar(100) NOT NULL default '',
  `elements_to_hide` text NOT NULL,
  `show_actions` enum('Y','N') NOT NULL default 'Y',
  `show_only_mandatory` enum('N','Y') NOT NULL default 'N',
  `show_timestamp` enum('Y','N') NOT NULL default 'Y',
  `show_line_numbering` enum('Y','N') NOT NULL default 'Y',
  UNIQUE KEY `id` (`id`)
) TYPE=MyISAM ;

INSERT INTO `lists` VALUES (1, 'The Big List (Show all fields)', '<elements>\r\n<el></el>\r\n</elements>\r\n', 'Y', 'N', 'Y', 'Y');
INSERT INTO `lists` VALUES (2, 'The Small List (Show only mandatory fields)', '<elements>\r\n</elements>\r\n', 'Y', 'Y', 'N', 'N');

CREATE TABLE `submissions` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `last_edit` timestamp NOT NULL ,
  `timestamp` timestamp NOT NULL default '0000-00-00 00:00:00',
  UNIQUE KEY `id` (`id`)
) TYPE=MyISAM ;
