CREATE TABLE `app_starter`.`user_contact_details` ( `id` INT(11) NOT NULL AUTO_INCREMENT,
`user_id` INT(11) NOT NULL,
`type` TINYINT(1) NOT NULL DEFAULT 1,
`address1` VARCHAR(25),
`address2` VARCHAR(25),
`address3` VARCHAR(25),
`city` VARCHAR(25),
`county` VARCHAR(25),
`post_code` VARCHAR(11),
`country` VARCHAR(25),
`country_code` VARCHAR(2),
`telephone` VARCHAR(15),
`mobile_telephone` VARCHAR(15),
`email` VARCHAR(50),
`date_created` DATETIME NOT NULL DEFAULT NOW(),
`date_updated` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (`id`),

CONSTRAINT chk_type CHECK(type=1 OR type=2 OR type=3),

CONSTRAINT uc_user_id_type UNIQUE(user_id, type),

CONSTRAINT fk_user_contact_details_user_accounts FOREIGN KEY(user_id)
REFERENCES user_accounts(id)
ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB;


/* test db*/
USE app_starter_test;

CREATE TABLE `app_starter_test`.`user_contact_details` ( `id` INT(11) NOT NULL AUTO_INCREMENT,
`user_id` INT(11) NOT NULL,
`type` TINYINT(1) NOT NULL DEFAULT 1,
`address1` VARCHAR(25),
`address2` VARCHAR(25),
`address3` VARCHAR(25),
`city` VARCHAR(25),
`county` VARCHAR(25),
`post_code` VARCHAR(11),
`country` VARCHAR(25),
`country_code` VARCHAR(2),
`telephone` VARCHAR(15),
`mobile_telephone` VARCHAR(15),
`email` VARCHAR(50),
`date_created` DATETIME NOT NULL DEFAULT NOW(),
`date_updated` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (`id`),

CONSTRAINT chk_type CHECK(type=1 OR type=2 OR type=3),

CONSTRAINT uc_user_id_type UNIQUE(user_id, type),

CONSTRAINT fk_user_contact_details_user_accounts FOREIGN KEY(user_id)
REFERENCES user_accounts(id)
ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB;