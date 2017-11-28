-- Downlaod timezones https://dev.mysql.com/downloads/timezones.html

-- Drop schema and user (when testing this script)
DROP SCHEMA IF EXISTS `blogmock`;
DROP USER IF EXISTS 'blogmock'@'localhost';
DROP USER IF EXISTS 'blogmock_app'@'localhost';

-- Delete all procedures associated with the blogmock schema (for testing)
DELETE FROM `mysql`.`proc` WHERE `db` = 'blogmock' AND `type` = 'PROCEDURE';

-- Create the schema
CREATE SCHEMA `blogmock`
    CHARACTER SET = 'utf8mb4'
    COLLATE 'utf8mb4_unicode_ci';

USE `blogmock`;

-- Create new user for managing the database
CREATE USER 'blogmock'@'localhost'
    IDENTIFIED BY '5JvZfqpHn6JEpytA';

-- Create new user for the application to call procedures
CREATE USER 'blogmock_app'@'localhost'
    IDENTIFIED BY 'PQXQ25sSUNKy83H4';

-- Grant all privileges
GRANT ALL ON blogmock.* TO 'blogmock'@'localhost';

-- Grant only execute privilege to run procedures
GRANT EXECUTE ON blogmock.* TO 'blogmock_app'@'localhost';

-- User table
CREATE TABLE `user` (
    `id`              BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `role`            TINYINT UNSIGNED NOT NULL,
    `username`        VARCHAR(191) NOT NULL,
    `email`           VARCHAR(191) NOT NULL,
    `password`        BINARY(60) NOT NULL,
    `created`         DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (`id`),
    UNIQUE INDEX (`username`) USING HASH
);

-- User token table for "remember me" functionality
CREATE TABLE `user_token` (
    `id`       BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id`  BIGINT UNSIGNED NOT NULL,
    `selector` CHAR(12) NOT NULL,
    `token`    BINARY(32) NOT NULL,
    `expire`   DATETIME NOT NULL,

    PRIMARY KEY (`id`),
    UNIQUE INDEX (`selector`) USING HASH,
    FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
);

-- User_log table for logging sign in attempts
CREATE TABLE `user_log` (
    `id`              BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id`         BIGINT UNSIGNED NOT NULL,
    `created`         DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (`id`),
    FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
);

DELIMITER //

-- Create user procedure
CREATE DEFINER = 'blogmock'@'localhost' PROCEDURE createUser
(
    IN inRole         TINYINT UNSIGNED,
    IN inUsername     VARCHAR(191),
    IN inEmail        VARCHAR(191),
    IN inPassword     BINARY(60)
)
BEGIN
    INSERT INTO `user` (`role`, `username`, `email`, `password`) VALUES
        (inRole, inUsername, inEmail, inPassword);
END//

-- Read user procedure
CREATE DEFINER = 'blogmock'@'localhost' PROCEDURE readUser
(
    IN inId           BIGINT UNSIGNED
)
BEGIN
    SELECT * FROM `user` WHERE `id` = inId;
END//

-- Read user by username procedure
CREATE DEFINER = 'blogmock'@'localhost' PROCEDURE readUserByName
(
    IN inUsername     VARCHAR(191)
)
BEGIN
    SELECT * FROM `user` WHERE `username` = inUsername;
END//

-- Update user procedure
CREATE DEFINER = 'blogmock'@'localhost' PROCEDURE updateUser
(
    IN inId           BIGINT UNSIGNED,
    IN inRole         TINYINT UNSIGNED,
    IN inEmail        VARCHAR(191),
    IN inPassword     BINARY(60)
)
BEGIN
    UPDATE `user` SET
        `email` = inEmail,
        `password` = inPassword
        WHERE `id` = inId;
END//

-- Delete user procedure
CREATE DEFINER = 'blogmock'@'localhost' PROCEDURE deleteUser
(
    IN inId           BIGINT UNSIGNED
)
BEGIN
    DELETE FROM `user` WHERE `id` = inId;
END//

DELIMITER ;
