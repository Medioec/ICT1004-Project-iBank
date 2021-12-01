-- MySQL Script generated by MySQL Workbench
-- Mon Nov 29 17:55:54 2021
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema double_o4_bank_v2
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema double_o4_bank_v2
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `double_o4_bank_v2` DEFAULT CHARACTER SET utf8 ;
USE `double_o4_bank_v2` ;

-- -----------------------------------------------------
-- Table `double_o4_bank_v2`.`bank_account`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `double_o4_bank_v2`.`bank_account` (
  `account_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` VARCHAR(15) NOT NULL,
  `balance` FLOAT(15,2) NOT NULL,
  PRIMARY KEY (`account_id`),
  UNIQUE INDEX `account_id_UNIQUE` (`account_id` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `double_o4_bank_v2`.`customer_credentials`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `double_o4_bank_v2`.`customer_credentials` (
  `customer_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_username` VARCHAR(30) NOT NULL,
  `password_hash` VARCHAR(60) NOT NULL,
  `otp` CHAR(6) NOT NULL,
  `password_token` CHAR(32) NOT NULL,
  `active` TINYINT(1) NOT NULL,
  PRIMARY KEY (`customer_id`),
  UNIQUE INDEX `customer_id_UNIQUE` (`customer_id` ASC) VISIBLE,
  UNIQUE INDEX `customer_username_UNIQUE` (`customer_username` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `double_o4_bank_v2`.`user_data`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `double_o4_bank_v2`.`user_data` (
  `customer_id` INT UNSIGNED NOT NULL,
  `first_name` VARCHAR(45) NULL DEFAULT NULL,
  `last_name` VARCHAR(45) NOT NULL,
  `full_name` VARCHAR(150) NOT NULL,
  `street1` VARCHAR(100) NOT NULL,
  `street2` VARCHAR(100) NOT NULL,
  `postal` CHAR(6) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `phone` VARCHAR(20) NOT NULL,
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) VISIBLE,
  INDEX `customer_id3_idx` (`customer_id` ASC) VISIBLE,
  UNIQUE INDEX `customer_id_UNIQUE` (`customer_id` ASC) VISIBLE,
  CONSTRAINT `customer_id3`
    FOREIGN KEY (`customer_id`)
    REFERENCES `double_o4_bank_v2`.`customer_credentials` (`customer_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `double_o4_bank_v2`.`transaction_data`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `double_o4_bank_v2`.`transaction_data` (
  `transaction_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `credit_id` INT NOT NULL,
  `debit_id` INT NOT NULL,
  `amount` DECIMAL(12,2) NOT NULL,
  `type` VARCHAR(5) NOT NULL,
  `timestamp` TIMESTAMP NOT NULL,
  PRIMARY KEY (`transaction_id`),
  UNIQUE INDEX `transaction_id_UNIQUE` (`transaction_id` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `double_o4_bank_v2`.`staff_credentials`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `double_o4_bank_v2`.`staff_credentials` (
  `staff_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `staff_username` VARCHAR(30) NOT NULL,
  `full_name` VARCHAR(150) NOT NULL,
  `password_hash` VARCHAR(60) NOT NULL,
  `otp` CHAR(6) NOT NULL,
  `position` VARCHAR(10) NOT NULL,
  `active` TINYINT(1) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`staff_id`),
  UNIQUE INDEX `staff_id_UNIQUE` (`staff_id` ASC) VISIBLE,
  UNIQUE INDEX `staff_username_UNIQUE` (`staff_username` ASC) VISIBLE,
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `double_o4_bank_v2`.`sensitive_info`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `double_o4_bank_v2`.`sensitive_info` (
  `customer_id` INT UNSIGNED NOT NULL,
  `ic_number` CHAR(9) NOT NULL,
  `gender` VARCHAR(6) NOT NULL,
  `date_of_birth` DATE NOT NULL,
  INDEX `customer_id_idx` (`customer_id` ASC) INVISIBLE,
  UNIQUE INDEX `customer_id_UNIQUE` (`customer_id` ASC) VISIBLE,
  UNIQUE INDEX `ic_number_UNIQUE` (`ic_number` ASC) VISIBLE,
  CONSTRAINT `customer_id2`
    FOREIGN KEY (`customer_id`)
    REFERENCES `double_o4_bank_v2`.`customer_credentials` (`customer_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `double_o4_bank_v2`.`log`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `double_o4_bank_v2`.`log` (
  `log_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` VARCHAR(45) NOT NULL,
  `category` VARCHAR(20) NOT NULL,
  `description` VARCHAR(45) NOT NULL,
  `user_performed` VARCHAR(45) NOT NULL,
  `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted` TINYINT(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`log_id`),
  UNIQUE INDEX `log_id_UNIQUE` (`log_id` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `double_o4_bank_v2`.`bank_accounts_ref`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `double_o4_bank_v2`.`bank_accounts_ref` (
  `customer_id` INT UNSIGNED NOT NULL,
  `account_id` INT UNSIGNED NOT NULL,
  INDEX `customer_id_idx` (`customer_id` ASC) VISIBLE,
  INDEX `account_id_idx` (`account_id` ASC) VISIBLE,
  CONSTRAINT `customer_id`
    FOREIGN KEY (`customer_id`)
    REFERENCES `double_o4_bank_v2`.`customer_credentials` (`customer_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `account_id`
    FOREIGN KEY (`account_id`)
    REFERENCES `double_o4_bank_v2`.`bank_account` (`account_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `double_o4_bank_v2`.`bank_account`
-- -----------------------------------------------------
START TRANSACTION;
USE `double_o4_bank_v2`;
INSERT INTO `double_o4_bank_v2`.`bank_account` (`account_id`, `type`, `balance`) VALUES (1, 'Savings', 500.00);
INSERT INTO `double_o4_bank_v2`.`bank_account` (`account_id`, `type`, `balance`) VALUES (2, 'Checking', 200.00);
INSERT INTO `double_o4_bank_v2`.`bank_account` (`account_id`, `type`, `balance`) VALUES (3, 'Savings', 9876543488.00);
INSERT INTO `double_o4_bank_v2`.`bank_account` (`account_id`, `type`, `balance`) VALUES (4, 'Savings', 570.00);
INSERT INTO `double_o4_bank_v2`.`bank_account` (`account_id`, `type`, `balance`) VALUES (5, 'Checking', 264.00);

COMMIT;


-- -----------------------------------------------------
-- Data for table `double_o4_bank_v2`.`customer_credentials`
-- -----------------------------------------------------
START TRANSACTION;
USE `double_o4_bank_v2`;
INSERT INTO `double_o4_bank_v2`.`customer_credentials` (`customer_id`, `customer_username`, `password_hash`, `otp`, `password_token`, `active`) VALUES (1, 'john', '$2a$12$MgHV3CQy.7i2E76do/3NduwYpFwad1hRVpmP8EfFwGidKsInI/sla', '978764', '0', 1);
INSERT INTO `double_o4_bank_v2`.`customer_credentials` (`customer_id`, `customer_username`, `password_hash`, `otp`, `password_token`, `active`) VALUES (2, 'jane', '$2a$12$MgHV3CQy.7i2E76do/3NduwYpFwad1hRVpmP8EfFwGidKsInI/sla', '978764', '0', 1);
INSERT INTO `double_o4_bank_v2`.`customer_credentials` (`customer_id`, `customer_username`, `password_hash`, `otp`, `password_token`, `active`) VALUES (3, 'jack', '$2a$12$MgHV3CQy.7i2E76do/3NduwYpFwad1hRVpmP8EfFwGidKsInI/sla', '978764', '0', 1);
INSERT INTO `double_o4_bank_v2`.`customer_credentials` (`customer_id`, `customer_username`, `password_hash`, `otp`, `password_token`, `active`) VALUES (4, 'mike', '$2a$12$MgHV3CQy.7i2E76do/3NduwYpFwad1hRVpmP8EfFwGidKsInI/sla', '978764', '0', 0);

COMMIT;


-- -----------------------------------------------------
-- Data for table `double_o4_bank_v2`.`user_data`
-- -----------------------------------------------------
START TRANSACTION;
USE `double_o4_bank_v2`;
INSERT INTO `double_o4_bank_v2`.`user_data` (`customer_id`, `first_name`, `last_name`, `full_name`, `street1`, `street2`, `postal`, `email`, `phone`) VALUES (1, 'John', 'Doe', 'John Doe', 'Simei Street 0', '', '520000', 'swap6recaptcha@gmail.com', '98765432');
INSERT INTO `double_o4_bank_v2`.`user_data` (`customer_id`, `first_name`, `last_name`, `full_name`, `street1`, `street2`, `postal`, `email`, `phone`) VALUES (2, 'Jane', 'Doe', 'Jane Doe', 'Simei Street 1', 'Blk 2', '520020', 'swap6recaptcha1@gmail.com', '98765431');
INSERT INTO `double_o4_bank_v2`.`user_data` (`customer_id`, `first_name`, `last_name`, `full_name`, `street1`, `street2`, `postal`, `email`, `phone`) VALUES (3, 'Jack', 'Ma', 'Jack Ma Yun', '1 Cove Ave', '', '098537', 'swap6recaptcha2@gmail.com', '88888888');
INSERT INTO `double_o4_bank_v2`.`user_data` (`customer_id`, `first_name`, `last_name`, `full_name`, `street1`, `street2`, `postal`, `email`, `phone`) VALUES (4, 'Michael', 'Jackson', 'Michael Joseph Jackson', '2 Cove Ave', '', '098538', 'swap6recaptcha3@gmail.com', '99999999');

COMMIT;


-- -----------------------------------------------------
-- Data for table `double_o4_bank_v2`.`transaction_data`
-- -----------------------------------------------------
START TRANSACTION;
USE `double_o4_bank_v2`;
INSERT INTO `double_o4_bank_v2`.`transaction_data` (`transaction_id`, `credit_id`, `debit_id`, `amount`, `type`, `timestamp`) VALUES (1, 4, 3, 1000.00, 'CHQ', '2021-08-11 11:23:55');
INSERT INTO `double_o4_bank_v2`.`transaction_data` (`transaction_id`, `credit_id`, `debit_id`, `amount`, `type`, `timestamp`) VALUES (2, 2, 1, 50.00, 'OTRF', '2021-11-11 11:23:55');
INSERT INTO `double_o4_bank_v2`.`transaction_data` (`transaction_id`, `credit_id`, `debit_id`, `amount`, `type`, `timestamp`) VALUES (3, 4, 1, 100.00, 'OTRF', '2021-10-11 11:23:55');
INSERT INTO `double_o4_bank_v2`.`transaction_data` (`transaction_id`, `credit_id`, `debit_id`, `amount`, `type`, `timestamp`) VALUES (4, 4, 1, 200.00, 'OTRF', '2021-12-11 11:23:55');
INSERT INTO `double_o4_bank_v2`.`transaction_data` (`transaction_id`, `credit_id`, `debit_id`, `amount`, `type`, `timestamp`) VALUES (5, 4, 2, 200.00, 'OTRF', '2020-11-11 11:23:55');
INSERT INTO `double_o4_bank_v2`.`transaction_data` (`transaction_id`, `credit_id`, `debit_id`, `amount`, `type`, `timestamp`) VALUES (6, 3, 4, 1000.00, 'CHQ', '2021-07-11 11:23:55');
INSERT INTO `double_o4_bank_v2`.`transaction_data` (`transaction_id`, `credit_id`, `debit_id`, `amount`, `type`, `timestamp`) VALUES (7, 3, 4, 400.00, 'CHQ', '2021-06-24 11:23:55');
INSERT INTO `double_o4_bank_v2`.`transaction_data` (`transaction_id`, `credit_id`, `debit_id`, `amount`, `type`, `timestamp`) VALUES (9, 5, 4, 264.00, 'OTRF', '2021-11-24 18:26:10');
INSERT INTO `double_o4_bank_v2`.`transaction_data` (`transaction_id`, `credit_id`, `debit_id`, `amount`, `type`, `timestamp`) VALUES (10, 3, 1, 650.00, 'OTRF', '2021-09-24 18:26:10');
INSERT INTO `double_o4_bank_v2`.`transaction_data` (`transaction_id`, `credit_id`, `debit_id`, `amount`, `type`, `timestamp`) VALUES (12, 4, 4, 133.00, 'OTRF', '2021-11-24 19:25:24');
INSERT INTO `double_o4_bank_v2`.`transaction_data` (`transaction_id`, `credit_id`, `debit_id`, `amount`, `type`, `timestamp`) VALUES (13, 1, 4, 400.00, 'OTRF', '2021-11-24 19:30:05');

COMMIT;


-- -----------------------------------------------------
-- Data for table `double_o4_bank_v2`.`sensitive_info`
-- -----------------------------------------------------
START TRANSACTION;
USE `double_o4_bank_v2`;
INSERT INTO `double_o4_bank_v2`.`sensitive_info` (`customer_id`, `ic_number`, `gender`, `date_of_birth`) VALUES (1, 'S0101010A', 'Male', '1900-11-11');
INSERT INTO `double_o4_bank_v2`.`sensitive_info` (`customer_id`, `ic_number`, `gender`, `date_of_birth`) VALUES (2, 'S1212121A', 'Female', '1901-11-11');
INSERT INTO `double_o4_bank_v2`.`sensitive_info` (`customer_id`, `ic_number`, `gender`, `date_of_birth`) VALUES (3, 'S2323232A', 'Male', '1950-11-11');
INSERT INTO `double_o4_bank_v2`.`sensitive_info` (`customer_id`, `ic_number`, `gender`, `date_of_birth`) VALUES (4, 'S9876543A', 'Male', '1950-08-03');

COMMIT;


-- -----------------------------------------------------
-- Data for table `double_o4_bank_v2`.`log`
-- -----------------------------------------------------
START TRANSACTION;
USE `double_o4_bank_v2`;
INSERT INTO `double_o4_bank_v2`.`log` (`log_id`, `type`, `category`, `description`, `user_performed`, `timestamp`, `deleted`) VALUES (1, 'SYSTEM', 'INFO', ' FAILED LOGIN - CUSTOMER', 'john', '2021-11-18 02:28:05', 0);
INSERT INTO `double_o4_bank_v2`.`log` (`log_id`, `type`, `category`, `description`, `user_performed`, `timestamp`, `deleted`) VALUES (2, 'SYSTEM', 'INFO', 'LOGIN - CUSTOMER', 'john', '2021-11-18 02:29:26', 0);
INSERT INTO `double_o4_bank_v2`.`log` (`log_id`, `type`, `category`, `description`, `user_performed`, `timestamp`, `deleted`) VALUES (3, 'SYSTEM', 'INFO', 'LOGIN - CUSTOMER', 'john', '2021-11-18 03:15:47', 0);
INSERT INTO `double_o4_bank_v2`.`log` (`log_id`, `type`, `category`, `description`, `user_performed`, `timestamp`, `deleted`) VALUES (4, 'SYSTEM', 'INFO', 'LOGIN - CUSTOMER', 'john', '2021-11-18 03:16:47', 0);
INSERT INTO `double_o4_bank_v2`.`log` (`log_id`, `type`, `category`, `description`, `user_performed`, `timestamp`, `deleted`) VALUES (5, 'SYSTEM', 'INFO', 'LOGIN - CUSTOMER', 'john', '2021-11-18 03:17:08', 0);
INSERT INTO `double_o4_bank_v2`.`log` (`log_id`, `type`, `category`, `description`, `user_performed`, `timestamp`, `deleted`) VALUES (6, 'SYSTEM', 'INFO', 'LOGIN - CUSTOMER', 'john', '2021-11-18 03:18:48', 0);
INSERT INTO `double_o4_bank_v2`.`log` (`log_id`, `type`, `category`, `description`, `user_performed`, `timestamp`, `deleted`) VALUES (7, 'SYSTEM', 'INFO', 'LOGIN - CUSTOMER', 'john', '2021-11-18 08:54:01', 0);
INSERT INTO `double_o4_bank_v2`.`log` (`log_id`, `type`, `category`, `description`, `user_performed`, `timestamp`, `deleted`) VALUES (8, 'SYSTEM', 'INFO', 'LOGIN - CUSTOMER', 'john', '2021-11-18 11:42:00', 0);
INSERT INTO `double_o4_bank_v2`.`log` (`log_id`, `type`, `category`, `description`, `user_performed`, `timestamp`, `deleted`) VALUES (9, 'SYSTEM', 'INFO', 'LOGIN - CUSTOMER', 'john', '2021-11-18 11:43:53', 0);
INSERT INTO `double_o4_bank_v2`.`log` (`log_id`, `type`, `category`, `description`, `user_performed`, `timestamp`, `deleted`) VALUES (10, 'SYSTEM', 'INFO', 'LOGIN - CUSTOMER', 'john', '2021-11-18 11:45:05', 0);
INSERT INTO `double_o4_bank_v2`.`log` (`log_id`, `type`, `category`, `description`, `user_performed`, `timestamp`, `deleted`) VALUES (11, 'SYSTEM', 'INFO', 'LOGIN - CUSTOMER', 'john', '2021-11-18 11:47:41', 0);
INSERT INTO `double_o4_bank_v2`.`log` (`log_id`, `type`, `category`, `description`, `user_performed`, `timestamp`, `deleted`) VALUES (12, 'SYSTEM', 'INFO', 'LOGIN - CUSTOMER', 'john', '2021-11-18 11:49:14', 0);
INSERT INTO `double_o4_bank_v2`.`log` (`log_id`, `type`, `category`, `description`, `user_performed`, `timestamp`, `deleted`) VALUES (13, 'SYSTEM', 'INFO', 'LOGIN - CUSTOMER', 'john', '2021-11-18 11:54:29', 0);
INSERT INTO `double_o4_bank_v2`.`log` (`log_id`, `type`, `category`, `description`, `user_performed`, `timestamp`, `deleted`) VALUES (14, 'SYSTEM', 'INFO', ' FAILED LOGIN - CUSTOMER (reCaptcha)', 'john', '2021-11-18 11:57:55', 0);
INSERT INTO `double_o4_bank_v2`.`log` (`log_id`, `type`, `category`, `description`, `user_performed`, `timestamp`, `deleted`) VALUES (15, 'SYSTEM', 'INFO', ' FAILED LOGIN - CUSTOMER (reCaptcha)', 'john', '2021-11-18 12:00:44', 0);
INSERT INTO `double_o4_bank_v2`.`log` (`log_id`, `type`, `category`, `description`, `user_performed`, `timestamp`, `deleted`) VALUES (16, 'SYSTEM', 'INFO', 'LOGIN - CUSTOMER', 'john', '2021-11-18 12:02:16', 0);
INSERT INTO `double_o4_bank_v2`.`log` (`log_id`, `type`, `category`, `description`, `user_performed`, `timestamp`, `deleted`) VALUES (17, 'SYSTEM', 'INFO', 'LOGIN - CUSTOMER', 'john', '2021-11-18 12:03:57', 0);
INSERT INTO `double_o4_bank_v2`.`log` (`log_id`, `type`, `category`, `description`, `user_performed`, `timestamp`, `deleted`) VALUES (18, 'SYSTEM', 'INFO', 'LOGIN - CUSTOMER', 'john', '2021-11-18 12:04:34', 0);
INSERT INTO `double_o4_bank_v2`.`log` (`log_id`, `type`, `category`, `description`, `user_performed`, `timestamp`, `deleted`) VALUES (19, 'SYSTEM', 'INFO', 'LOGIN - CUSTOMER', 'john', '2021-11-18 12:09:03', 0);
INSERT INTO `double_o4_bank_v2`.`log` (`log_id`, `type`, `category`, `description`, `user_performed`, `timestamp`, `deleted`) VALUES (20, 'SYSTEM', 'INFO', 'LOGIN - CUSTOMER', 'john', '2021-11-18 12:17:12', 0);
INSERT INTO `double_o4_bank_v2`.`log` (`log_id`, `type`, `category`, `description`, `user_performed`, `timestamp`, `deleted`) VALUES (21, 'SYSTEM', 'INFO', 'LOGIN - CUSTOMER', 'john', '2021-11-18 12:17:34', 0);
INSERT INTO `double_o4_bank_v2`.`log` (`log_id`, `type`, `category`, `description`, `user_performed`, `timestamp`, `deleted`) VALUES (22, 'SYSTEM', 'INFO', ' FAILED LOGIN - CUSTOMER', '-EMPTY FIELD-', '2021-11-18 12:23:20', 0);
INSERT INTO `double_o4_bank_v2`.`log` (`log_id`, `type`, `category`, `description`, `user_performed`, `timestamp`, `deleted`) VALUES (23, 'SYSTEM', 'INFO', 'LOGIN - CUSTOMER', 'john', '2021-11-18 12:27:23', 0);
INSERT INTO `double_o4_bank_v2`.`log` (`log_id`, `type`, `category`, `description`, `user_performed`, `timestamp`, `deleted`) VALUES (24, 'SYSTEM', 'INFO', 'LOGIN - CUSTOMER', 'john', '2021-11-18 12:28:31', 0);
INSERT INTO `double_o4_bank_v2`.`log` (`log_id`, `type`, `category`, `description`, `user_performed`, `timestamp`, `deleted`) VALUES (25, 'SYSTEM', 'INFO', 'LOGIN - CUSTOMER', 'john', '2021-11-18 12:29:13', 0);
INSERT INTO `double_o4_bank_v2`.`log` (`log_id`, `type`, `category`, `description`, `user_performed`, `timestamp`, `deleted`) VALUES (26, 'SYSTEM', 'INFO', ' FAILED LOGIN - CUSTOMER (reCaptcha)', 'john', '2021-11-18 12:31:04', 0);
INSERT INTO `double_o4_bank_v2`.`log` (`log_id`, `type`, `category`, `description`, `user_performed`, `timestamp`, `deleted`) VALUES (27, 'SYSTEM', 'INFO', ' FAILED LOGIN - CUSTOMER (reCaptcha)', 'john', '2021-11-18 12:32:22', 0);
INSERT INTO `double_o4_bank_v2`.`log` (`log_id`, `type`, `category`, `description`, `user_performed`, `timestamp`, `deleted`) VALUES (28, 'SYSTEM', 'INFO', ' FAILED LOGIN - CUSTOMER', '-EMPTY FIELD-', '2021-11-18 12:50:54', 0);

COMMIT;


-- -----------------------------------------------------
-- Data for table `double_o4_bank_v2`.`bank_accounts_ref`
-- -----------------------------------------------------
START TRANSACTION;
USE `double_o4_bank_v2`;
INSERT INTO `double_o4_bank_v2`.`bank_accounts_ref` (`customer_id`, `account_id`) VALUES (1, 1);
INSERT INTO `double_o4_bank_v2`.`bank_accounts_ref` (`customer_id`, `account_id`) VALUES (2, 1);
INSERT INTO `double_o4_bank_v2`.`bank_accounts_ref` (`customer_id`, `account_id`) VALUES (2, 2);
INSERT INTO `double_o4_bank_v2`.`bank_accounts_ref` (`customer_id`, `account_id`) VALUES (3, 3);
INSERT INTO `double_o4_bank_v2`.`bank_accounts_ref` (`customer_id`, `account_id`) VALUES (4, 4);
INSERT INTO `double_o4_bank_v2`.`bank_accounts_ref` (`customer_id`, `account_id`) VALUES (2, 4);
INSERT INTO `double_o4_bank_v2`.`bank_accounts_ref` (`customer_id`, `account_id`) VALUES (1, 2);
INSERT INTO `double_o4_bank_v2`.`bank_accounts_ref` (`customer_id`, `account_id`) VALUES (1, 4);
INSERT INTO `double_o4_bank_v2`.`bank_accounts_ref` (`customer_id`, `account_id`) VALUES (1, 5);

COMMIT;

