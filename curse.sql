CREATE TABLE `space_achiv` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`country` BOOLEAN NOT NULL,
	`people` INT(11) NOT NULL,
	`achiv_name` varchar(255) NOT NULL,
	`date` DATE NOT NULL,
	`text` varchar(255) NOT NULL,
	`type_app` INT(1) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `people` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`initials` varchar(255) NOT NULL,
	`surename` varchar(255) NOT NULL,
	`name` varchar(255) NOT NULL,
	`last_name` varchar(255) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `app_types` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`type` varchar(255) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `users` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`nick_name` varchar(255) NOT NULL,
	`role` INT(1) NOT NULL,
	`role_raise` INT(1) NOT NULL,
	`email` varchar(255) NOT NULL,
	`password` varchar(255) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `roles` (
	`id` INT(1) NOT NULL AUTO_INCREMENT,
	`role_name` varchar(30) NOT NULL,
	PRIMARY KEY (`id`)
);

ALTER TABLE `space_achiv` ADD CONSTRAINT `space_achiv_fk0` FOREIGN KEY (`people`) REFERENCES `people`(`id`);

ALTER TABLE `space_achiv` ADD CONSTRAINT `space_achiv_fk1` FOREIGN KEY (`type_app`) REFERENCES `app_types`(`id`);

ALTER TABLE `users` ADD CONSTRAINT `users_fk0` FOREIGN KEY (`role`) REFERENCES `roles`(`id`);

ALTER TABLE `users` ADD CONSTRAINT `users_fk1` FOREIGN KEY (`role_raise`) REFERENCES `roles`(`id`);






