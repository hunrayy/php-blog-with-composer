-- database creation --

-- CREATE DATABASE `blog_db`;


-- role table --
CREATE TABLE IF NOT EXISTS `role`(
    `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `type` VARCHAR(100)  NOT NULL,
    `privilege_id` VARCHAR(200),
    `updated_at` timestamp DEFAULT CURRENT_TIME
);
-- insert into role's table --
INSERT INTO `role` (`type`, `privilege_id`) VALUES ('super-admin', '["1", "2", "3", "4", "5"]');
INTO `role` (`type`, `privilege_id`) VALUES ('author-admin', '["1", "2"]');
INSERT INTO `role` (`type`, `privilege_id`) VALUES ('user', null);

-- users' table --
CREATE TABLE IF NOT EXISTS `users`(
    `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `firstname` VARCHAR(200) NOT NULL,
    `lastname` VARCHAR(200) NOT NULL,
    `email` VARCHAR(200) UNIQUE NOT NULL ,
    `password` VARCHAR(200) NOT NULL,
    `role_id` INT,
    `status` TINYINT NOT NULL,
    `registered_at` timestamp NOT NULL DEFAULT CURRENT_TIME,
    CONSTRAINT `role_auth` FOREIGN KEY (`role_id`) REFERENCES `role`(`id`) ON DELETE CASCADE
);


-- privilege table -- 
CREATE TABLE IF NOT EXISTS `privilege`(
    `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `action` VARCHAR(200) NOT NULL,
    `registered_at` timestamp NOT NULL DEFAULT CURRENT_TIME
);
-- insert into privilege's table --
INSERT INTO `privilege` (`action`) VALUES ('can-create-blog'), ('can-update-blog'), ('can-delete-blog'), ('can-create-admin'), ('can-delete-user');


-- categories table -- 
CREATE TABLE IF NOT EXISTS `category`(
    `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `category` VARCHAR(200) NOT NULL,
    `registered_at` timestamp DEFAULT CURRENT_TIME
);
-- insert into category's table --
INSERT INTO `category` (`category`) VALUES ('sports'), ('politics'), ('science'), ('entertainment'), ('crime'), ('education'), ('culture'), ('business'), ('general');


-- articles table -- 
CREATE TABLE IF NOT EXISTS `articles`(
    `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `title` TEXT NOT NULL,
    `content` LONGTEXT NOT NULL,
    `category_id` INT NOT NULL,
    `user_id(author)` INT NOT NULL,
    `registered_at` timestamp NOT NULL DEFAULT CURRENT_TIME,
    `user_id(editor)` INT,
    `updated_at` timestamp DEFAULT CURRENT_TIME,
    CONSTRAINT `category_auth` FOREIGN KEY (`category_id`) REFERENCES `category`(`id`) ON DELETE CASCADE,
    CONSTRAINT `author_auth` FOREIGN KEY (`user_id(author)`) REFERENCES `users`(`id`) ON DELETE CASCADE,
    CONSTRAINT `editor_auth` FOREIGN KEY (`user_id(editor)`) REFERENCES `users`(`id`) ON DELETE CASCADE
);











-- FOREIGN KEY CONSTRAINTS --
-- role_id on `users` table
-- ALTER TABLE `users`,
-- ADD 

-- -- `user_id` and `category_id` on `articles` table
-- ALTER TABLE `articles`,
-- ADD 
