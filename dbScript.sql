CREATE DATABASE `kassakaappi` /*!40100 DEFAULT CHARACTER SET utf8 */;

CREATE TABLE `account` (
  `account_id` int(11) NOT NULL AUTO_INCREMENT,
  `balance` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`account_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

CREATE TABLE `session` (
  `account_id` int(11) NOT NULL,
  `originator` varchar(45) NOT NULL,
  `session` varchar(45) NOT NULL,
  `valid` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`account_id`,`originator`),
  UNIQUE KEY `session_UNIQUE` (`session`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(45) NOT NULL,
  `lastname` varchar(45) NOT NULL,
  `passwordsalt` varchar(45) NOT NULL,
  `loginname` varchar(45) NOT NULL,
  `passwordhash` varchar(45) NOT NULL,
  `accountid` int(11) NOT NULL,
  `salt` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `loginname` (`loginname`),
  KEY `account_id` (`accountid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8


CREATE TABLE `transaction` (
  `transaction_id` int(11) NOT NULL AUTO_INCREMENT,
  `account` int(11) NOT NULL,
  `target` int(11) NOT NULL,
  `reference` int(11) NOT NULL,
  `amount` float NOT NULL,
  `description` varchar(45) NOT NULL DEFAULT '',
  `done` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`transaction_id`),
  UNIQUE KEY `transaction_id_UNIQUE` (`transaction_id`),
  KEY `fk_account` (`account`),
  CONSTRAINT `fk_account` FOREIGN KEY (`account`) REFERENCES `account` (`account_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;