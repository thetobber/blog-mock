-- Drop schema and user (when testing this script)
DROP SCHEMA IF EXISTS `blockmock`;
DROP USER IF EXISTS 'blockmock'@'localhost';

-- Create the schema
CREATE SCHEMA `blockmock`
    CHARACTER SET = 'utf8mb4'
    COLLATE 'utf8mb4_unicode_ci';

-- Create new user only accessible locally
CREATE USER 'blockmock'@'localhost'
    IDENTIFIED BY 'nhQrQQzf7C6mTybsm47Hy4ae';

-- Grant database user execute so only procedures can be used
GRANT EXECUTE ON blockmock.* TO 'blockmock'@'localhost';
--GRANT ALL ON blockmock.* TO 'blockmock'@'localhost';

USE `blockmock`;

-- User table
CREATE TABLE `user` (
    `id`              BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `role`            TINYINT UNSIGNED NOT NULL,
    `username`        VARCHAR(255) NOT NULL,
    `email`           VARCHAR(255) NOT NULL,
    `password`        BINARY(60) NOT NULL,
    `created`         DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (`id`),
    UNIQUE INDEX (`username`) USING HASH
);

-- User_log table for logging sign in attempts
CREATE TABLE `user_log` (
    `id`              BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id`         BIGINT UNSIGNED NOT NULL,
    `created`         DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (`id`),
    FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
);
