SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(25) NOT NULL,
  `email` varchar(50) NOT NULL,
  `profile_path` varchar(50) NOT NULL DEFAULT 'default_profile.png',
  `password` varchar(50) NOT NULL,
  `trn_date` datetime NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `expenses` (
  `expense_id` int(20) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `expense` int(20) NOT NULL,
  `expensedate` varchar(15) NOT NULL,
  `expensecategory` varchar(50) NOT NULL,
  PRIMARY KEY (`expense_id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `Budget` (
  `budget_id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT(11) NOT NULL,
  `month` INT NOT NULL,
  `year` INT NOT NULL,
  `budget_amount` DECIMAL(10, 2) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  UNIQUE (`user_id`, `month`, `year`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `income` (
  `income_id` int(20) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `income_amount` decimal(10,2) NOT NULL,
  `income_date` date NOT NULL,
  PRIMARY KEY (`income_id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
