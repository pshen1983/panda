CREATE DATABASE PANDA_PROJ;

########################################################################################################

CREATE TABLE PANDA_PROJ.PROJECT
(
	ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
	TITLE NVARCHAR(249) NOT NULL,
	CREATOR INT UNSIGNED NOT NULL,
	OWNER INT UNSIGNED NOT NULL, 
	DESCRIPTION TEXT,
	STATUS NVARCHAR(5) NOT NULL,
	CREATE_DATE DATE NOT NULL,
	END_DATE DATE,
	S_ID INT UNSIGNED NOT NULL,

	PRIMARY KEY (ID),
	FOREIGN KEY (CREATOR) REFERENCES PANDA_USER.USER (ID),
	FOREIGN KEY (OWNER) REFERENCES PANDA_USER.USER (ID),
	UNIQUE (TITLE, CREATOR)
) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE INDEX TITLE_INDEX ON PANDA_PROJ.PROJECT (TITLE(248));
CREATE INDEX S_ID_INDEX ON PANDA_PROJ.PROJECT (S_ID);
CREATE INDEX STATUS_INDEX ON PANDA_PROJ.PROJECT (STATUS(4));

########################################################################################################

CREATE TABLE PANDA_PROJ.RELATION
(
	ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
	U_ID INT UNSIGNED NOT NULL,
	P_ID INT UNSIGNED NOT NULL,
	ROLE NVARCHAR(5) NOT NULL,

	PRIMARY KEY (ID),
	FOREIGN KEY (U_ID) REFERENCES PANDA_USER.USER (ID),
	FOREIGN KEY (P_ID) REFERENCES PANDA_PROJ.PROJECT (ID),
	UNIQUE (U_ID, P_ID)
) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE INDEX ROLE_INDEX ON PANDA_PROJ.RELATION (ROLE(4));

########################################################################################################

CREATE TABLE PANDA_PROJ.PROJCOMP
(
	ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
	CREATOR INT UNSIGNED NOT NULL,
	OWNER INT UNSIGNED NOT NULL,
	TITLE NVARCHAR(249) NOT NULL,
	DESCRIPTION TEXT,
	STATUS NVARCHAR(5) NOT NULL,
	CREATE_DATE DATE NOT NULL,
	LASTUPDATE_DATE DATETIME NOT NULL,
	LASTUPDATE_USER INT UNSIGNED NOT NULL, 
	END_DATE DATE,
	P_ID INT UNSIGNED NOT NULL,
	S_ID INT UNSIGNED NOT NULL,
	IS_MILESTONE ENUM('N','Y'),

	PRIMARY KEY (ID),
	FOREIGN KEY (CREATOR) REFERENCES PANDA_USER.USER (ID),
	FOREIGN KEY (OWNER) REFERENCES PANDA_USER.USER (ID),
	FOREIGN KEY (P_ID) REFERENCES PANDA_PROJ.PROJECT (ID),
	FOREIGN KEY (LASTUPDATE_USER) REFERENCES PANDA_USER.USER (ID),
	UNIQUE (TITLE, P_ID)
) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE INDEX TITLE_INDEX ON PANDA_PROJ.PROJCOMP (TITLE(248));
CREATE INDEX IS_MILESTONE_INDEX ON PANDA_PROJ.PROJCOMP (IS_MILESTONE);
CREATE INDEX S_ID_INDEX ON PANDA_PROJ.PROJCOMP (S_ID);
CREATE INDEX STATUS_INDEX ON PANDA_PROJ.PROJCOMP (STATUS(4));

########################################################################################################

CREATE TABLE PANDA_PROJ.PROJCOMM
(
	ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
	CREATOR INT UNSIGNED NOT NULL,
	CONTENT TEXT,
	MODIFIED DATE NOT NULL,
	P_ID INT UNSIGNED NOT NULL,

	PRIMARY KEY (ID),
	FOREIGN KEY (CREATOR) REFERENCES PANDA_USER.USER (ID),
	FOREIGN KEY (P_ID) REFERENCES PANDA_PROJ.PROJECT (ID)
) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

########################################################################################################

CREATE TABLE PANDA_PROJ.COMPCOMM
(
	ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
	CREATOR INT UNSIGNED NOT NULL,
	CONTENT TEXT,
	MODIFIED DATE NOT NULL,
	COMP_ID INT UNSIGNED NOT NULL,

	PRIMARY KEY (ID),
	FOREIGN KEY (CREATOR) REFERENCES PANDA_USER.USER (ID),
	FOREIGN KEY (COMP_ID) REFERENCES PANDA_PROJ.PROJCOMP (ID)
) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

########################################################################################################

GRANT ALL ON PANDA_PROJ.* TO aproj@'%' IDENTIFIED BY 'aprojpass';
FLUSH PRIVILEGES;