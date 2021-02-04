CREATE DATABASE app_starter;

USE app_starter;

CREATE TABLE `app_starter`.`user_accounts` ( `id` INT(11) NOT NULL AUTO_INCREMENT ,
`firstname` VARCHAR(50) NOT NULL ,
`lastname` VARCHAR(50) NOT NULL ,
`username` VARCHAR(50) NOT NULL ,
`email` VARCHAR(50) NOT NULL ,
`password` VARCHAR(255) NOT NULL ,
`date_created` DATETIME NOT NULL DEFAULT NOW(),
`date_updated` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (`id`)) ENGINE = InnoDB;

INSERT INTO user_accounts (firstname, lastname, username, email, password, date_created)
VALUES 
('Dan', 'Major', 'dan.major', 'dan.major@test.com', 'pass1', now()),
('Jeff', 'Crystal', 'jeff.crystal', 'jeff.crystal@test.com', 'pass2', now()),
('Carol', 'Hastings', 'carol.hastings', 'carol.hastings@test.com', 'pass3', now()),
('Mark', 'Christmas', 'mark.christmas', 'mark.christmas@test.com', 'pass4', now());

/*test db*/
CREATE DATABASE app_starter_test;

USE app_starter_test;

CREATE TABLE `app_starter_test`.`user_accounts` ( `id` INT(11) NOT NULL AUTO_INCREMENT ,
`firstname` VARCHAR(50) NOT NULL ,
`lastname` VARCHAR(50) NOT NULL ,
`username` VARCHAR(50) NOT NULL ,
`email` VARCHAR(50) NOT NULL ,
`password` VARCHAR(255) NOT NULL ,
`date_created` DATETIME NOT NULL DEFAULT NOW(),
`date_updated` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (`id`)) ENGINE = InnoDB;