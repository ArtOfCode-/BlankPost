-- Written for MySQL databases only. I'm not responsible if it
-- breaks on other systems.

CREATE TABLE `Posts` (
	`PostId` INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`PostTitle` VARCHAR(250),
	`PostBody` MEDIUMTEXT NOT NULL,
	`CreationDate` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`CreationUser` VARCHAR(200) NOT NULL,
	`PostTypeId` TINYINT(1) NOT NULL,
	`ParentId` INT(11)
);

CREATE TABLE `PostTypes` (
	`Id` TINYINT(1) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`Description` VARCHAR(100) NOT NULL
);

CREATE TABLE `BlockedUsers` (
    `Id` INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `IpAddress` VARCHAR(20) NOT NULL UNIQUE,
    `Reason` VARCHAR(500) NOT NULL
);

INSERT INTO `PostTypes` (`Id`, `Description`) VALUES
	(DEFAULT, 'Post'),
	(DEFAULT, 'Comment');

CREATE VIEW `MainPosts` AS
	SELECT `PostId` AS 'ID', 
		   `PostTitle` AS 'Title', 
		   `PostBody` AS 'Content',
		   `CreationDate` AS 'Date Posted', 
		   `CreationUser` AS 'Author'
	FROM `Posts` AS `p`
	INNER JOIN `PostTypes` AS `pt`
		ON `pt`.`Id` = `p`.`PostTypeId`
	WHERE `pt`.`Description` = 'Post';

CREATE VIEW `Comments` AS
	SELECT `PostId` AS 'ID',
		   `PostBody` AS 'Content',
		   `CreationDate` AS 'Date Posted',
		   `CreationUser` AS 'Author'
	FROM `Posts` AS `p`
	INNER JOIN `PostTypes` AS `pt`
		ON `pt`.`Id` = `p`.`PostTypeId`
	WHERE `pt`.`Description` = 'Comment';

CREATE TABLE `Users` (
	`UserId` INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`Email` VARCHAR(200) NOT NULL,
	`UserName` VARCHAR(200) NOT NULL,
	`Password` VARCHAR(64) NOT NULL,
	`Salt` VARCHAR(32) NOT NULL,
	`AuthLevel` TINYINT(2) NOT NULL DEFAULT 0
);