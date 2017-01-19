CREATE TABLE `user_other` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `curin_australia` INT(10) NULL,
  `inter_studentvet` INT(10) NULL,
  `exemption_sir` INT(10) NULL,
  `like_apply_usi` INT(10) NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


ALTER TABLE `user_other` ADD CONSTRAINT `user_other_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);