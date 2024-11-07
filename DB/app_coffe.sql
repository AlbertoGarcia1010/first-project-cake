
CREATE DATABASE app_coffe;

USE app_coffe;

-- app_coffe.roles definition

CREATE TABLE `roles` (
  `rol_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` varchar(150) DEFAULT NULL,
  `is_visible` tinyint(2) DEFAULT 1,
  `id_status` tinyint(2) DEFAULT NULL,
  `date_create` datetime DEFAULT NULL,
  `date_update` datetime DEFAULT NULL,
  PRIMARY KEY (`rol_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;


-- app_coffe.users definition

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `rol_id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `first_last_name` varchar(50) DEFAULT NULL,
  `second_last_name` varchar(50) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `login_user` varchar(20) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `id_status` tinyint(2) DEFAULT NULL,
  `date_create` datetime DEFAULT NULL,
  `date_update` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;