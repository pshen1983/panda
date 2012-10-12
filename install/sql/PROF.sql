CREATE DATABASE PANDA_PROF;

########################################################################################################

CREATE TABLE PANDA_PROF.PROFILE
(
	ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
	U_ID INT UNSIGNED NOT NULL,
	MESSAGE NVARCHAR(249),
	LOCATION NVARCHAR(249),
	B_YEAR INT,
	B_MONTH INT,
	B_DAY INT,
	INTERESTS TEXT,

	PRIMARY KEY (ID),
	FOREIGN KEY (U_ID) REFERENCES PANDA_USER.USER (ID)
) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

########################################################################################################

CREATE TABLE PANDA_PROF.EDUCATION
(
	ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
	U_ID INT UNSIGNED NOT NULL,
	TYPE NVARCHAR(5) NOT NULL,
	SCHOOL NVARCHAR(249) NOT NULL,
	DEPARTMENT NVARCHAR(249) NOT NULL,
	YEAR_START INT UNSIGNED NOT NULL,
	YEAR_END INT UNSIGNED NOT NULL,

	PRIMARY KEY (ID),
	FOREIGN KEY (U_ID) REFERENCES PANDA_USER.USER (ID)
) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

########################################################################################################

CREATE TABLE PANDA_PROF.EMPLOYMENT
(
	ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
	U_ID INT UNSIGNED NOT NULL,
	COMPANY NVARCHAR(249) NOT NULL,
	TITLE NVARCHAR(249) NOT NULL,
	LOCATION NVARCHAR(249) NOT NULL,
	YEAR_START INT UNSIGNED NOT NULL,
	YEAR_END INT UNSIGNED NOT NULL,

	PRIMARY KEY (ID),
	FOREIGN KEY (U_ID) REFERENCES PANDA_USER.USER (ID)
) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

########################################################################################################

GRANT ALL ON PANDA_PROF.* TO aprof@'%' IDENTIFIED BY 'aprofpass';
FLUSH PRIVILEGES;