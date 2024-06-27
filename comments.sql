-- comments table --
CREATE TABLE IF NOT EXISTS `comments`(
    `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `comment` TEXT NOT NULL,
    `registered_at` timestamp NOT NULL DEFAULT CURRENT_TIME
);




-- 
-- 
-- 
-- privilege_id and `user_id` on `role` table
ALTER TABLE `comments`,
ADD COLUMN `article_id` INT NOT NULL,
ADD COLUMN `user_id` INT NOT NULL,
ADD CONSTRAINT `privilege_auth` FOREIGN KEY (`privilege_id`) REFERENCES `admin`(`id`) ON DELETE CASCADE,
ADD CONSTRAINT `user_auth` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE;
-- 
-- 
-- 










