CREATE TABLE `categories`
(
	`id` INT(11) AUTO_INCREMENT PRIMARY KEY,
	`title` VARCHAR(255) NOT NULL
)

CREATE TABLE `users`
(
	`id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`name` VARCHAR(255) NOT NULL
)

CREATE TABLE `posts`
(
	`id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`content` VARCHAR(243) NOT NULL,
	`category_id` INT(11),
	`created_by` INT(11),
	`created_at` INT(11) NOT NULL
)

CREATE INDEX `i-posts-created_by` ON posts(created_by)
CREATE INDEX `i-posts-category_id` ON posts(category_id)

CREATE TABLE `favorites`
(
	`user_id` INT(11) NOT NULL,
	`post_id` INT(11) NOT NULL,
	`created_at` INT(11) NOT NULL
)


CREATE UNIQUE INDEX `i-favorites-user_id-post_id` ON favorites(user_id, post_id)