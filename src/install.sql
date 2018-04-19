CREATE TABLE IF NOT EXISTS `#__articleplus_params` (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`keyword`  varchar(32) NOT NULL ,
`description`  varchar(255) NOT NULL ,
`setting`  text NOT NULL ,
`type`  enum('text','textarea','richtext','yesno','list') NOT NULL,
`pagename`  varchar(32) NOT NULL ,
PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `#__articleplus_blocked` (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`keyword` VARCHAR(255) NOT NULL,
PRIMARY KEY (`id`)
);


INSERT IGNORE INTO `#__articleplus_params` VALUES (1, 'min_word_length', 'Minimum length for keyword', '4', 'text', 'Parameters');
INSERT IGNORE INTO `#__articleplus_params` VALUES (2, 'min_word_freq', 'Minimum frequency of keywords', '4', 'text',  'Parameters');
INSERT IGNORE INTO `#__articleplus_params` VALUES (3, 'phrases_length', 'Maximum length of phrases', '1', 'text', 'Parameters');
INSERT IGNORE INTO `#__articleplus_params` VALUES (4, 'min_words_length_phrases', 'Minimum length of words in phrases', '3', 'text', 'Parameters');
INSERT IGNORE INTO `#__articleplus_params` VALUES (5, 'min_phrase_freq', 'Minimum frequency of phrases', '4', 'text', 'Parameters');

