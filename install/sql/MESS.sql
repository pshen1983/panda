CREATE DATABASE PANDA_MESS;

########################################################################################################

CREATE TABLE PANDA_MESS.MESSAGE
(
	ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
	TITLE NVARCHAR(321) NOT NULL,

	OWNER_ID INT UNSIGNED NOT NULL,
	FROM_ID INT UNSIGNED NOT NULL,

	BODY TEXT,

	CREATE_TIME DATETIME NOT NULL,
	IS_READ ENUM('N','Y'),

	PRIMARY KEY (ID),
	FOREIGN KEY (OWNER_ID) REFERENCES PANDA_USER.USER (ID),
	FOREIGN KEY (FROM_ID) REFERENCES PANDA_USER.USER (ID)
) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE INDEX TITLE_INDEX ON PANDA_MESS.MESSAGE (TITLE(320));
CREATE INDEX IS_READ_INDEX ON PANDA_MESS.MESSAGE (IS_READ);
CREATE INDEX CREATE_TIME_INDEX ON PANDA_MESS.MESSAGE (CREATE_TIME);

########################################################################################################

CREATE TABLE PANDA_MESS.NOTE
(
	ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
	USER_ID INT UNSIGNED NOT NULL,
	TITLE NVARCHAR(321) NOT NULL,

	DESCRIPTION TEXT,
	CREATE_TIME DATETIME NOT NULL,
	DONE ENUM('N', 'Y') NOT NULL,
	DONE_TIME DATETIME,

	PRIMARY KEY (ID),
	FOREIGN KEY (USER_ID) REFERENCES PANDA_USER.USER (ID)
) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE INDEX DONE_INDEX ON PANDA_MESS.NOTE (DONE);
CREATE INDEX CREATE_TIME_INDEX ON PANDA_MESS.NOTE (CREATE_TIME);
CREATE INDEX DONE_TIME_INDEX ON PANDA_MESS.NOTE (DONE_TIME);

########################################################################################################

CREATE TABLE PANDA_MESS.FEEDBACK
(
	ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
	FROM_EMAIL NVARCHAR(41) NOT NULL,
	BODY TEXT NOT NULL,
	CREATE_TIME DATETIME,

	PRIMARY KEY (ID)
) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

########################################################################################################

GRANT ALL ON PANDA_MESS.* TO amess@'%' IDENTIFIED BY 'amesspass';
FLUSH PRIVILEGES;