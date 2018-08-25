
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- combo
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `combo`;

CREATE TABLE `combo`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `price` DOUBLE(7,2) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- combo_food
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `combo_food`;

CREATE TABLE `combo_food`
(
    `combo_id` INTEGER NOT NULL,
    `food_id` INTEGER NOT NULL,
    PRIMARY KEY (`combo_id`,`food_id`),
    INDEX `food_id` (`food_id`),
    CONSTRAINT `combo_food_ibfk_1`
        FOREIGN KEY (`combo_id`)
        REFERENCES `combo` (`id`),
    CONSTRAINT `combo_food_ibfk_2`
        FOREIGN KEY (`food_id`)
        REFERENCES `food` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- combo_request
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `combo_request`;

CREATE TABLE `combo_request`
(
    `combo_id` INTEGER NOT NULL,
    `request_id` INTEGER NOT NULL,
    PRIMARY KEY (`combo_id`,`request_id`),
    INDEX `request_id` (`request_id`),
    CONSTRAINT `combo_request_ibfk_1`
        FOREIGN KEY (`combo_id`)
        REFERENCES `combo` (`id`),
    CONSTRAINT `combo_request_ibfk_2`
        FOREIGN KEY (`request_id`)
        REFERENCES `request` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- food
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `food`;

CREATE TABLE `food`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` CHAR(32) NOT NULL,
    `price` DOUBLE(7,2) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- request
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `request`;

CREATE TABLE `request`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `person_name` CHAR(32) NOT NULL,
    `special_id` CHAR(4) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- request_food
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `request_food`;

CREATE TABLE `request_food`
(
    `request_id` INTEGER NOT NULL,
    `food_id` INTEGER NOT NULL,
    PRIMARY KEY (`request_id`,`food_id`),
    INDEX `food_id` (`food_id`),
    CONSTRAINT `request_food_ibfk_1`
        FOREIGN KEY (`request_id`)
        REFERENCES `request` (`id`),
    CONSTRAINT `request_food_ibfk_2`
        FOREIGN KEY (`food_id`)
        REFERENCES `food` (`id`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
