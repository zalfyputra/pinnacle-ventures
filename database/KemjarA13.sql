-- SQL statements to create the tables and insert data

-- Drop the tables if they already exist
DROP TABLE IF EXISTS `users`;

-- Create the users table
CREATE TABLE `users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(20) NOT NULL UNIQUE,
  `password` VARCHAR(65) NOT NULL,
  PRIMARY KEY (`id`)
);

-- Insert two users into the users table with MD5 hashed passwords
INSERT INTO `users` (`username`, `password`)
VALUES
  ('user1', MD5('password')),
  ('user2', MD5('12345678'));