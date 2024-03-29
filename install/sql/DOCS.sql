CREATE DATABASE PANDA_DOCS;

########################################################################################################

CREATE TABLE PANDA_DOCS.FILE
(
	ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
	TITLE NVARCHAR(249) NOT NULL,
	UPDATER INT UNSIGNED NOT NULL,
	LAST_UPDATE DATETIME NOT NULL,

	SIZE INT UNSIGNED NOT NULL,
	CONTENT MEDIUMBLOB NOT NULL,
	P_ID INT UNSIGNED NOT NULL,
	COMP_ID INT UNSIGNED,
	WORK_PID INT UNSIGNED,
	WORK_IID INT UNSIGNED,
	DESCRIPTION TEXT,
	VERSION INT UNSIGNED NOT NULL,
	S_ID NVARCHAR(41) NOT NULL,

	PRIMARY KEY (ID),
	FOREIGN KEY (P_ID) REFERENCES PANDA_PROJ.PROJECT (ID),
	UNIQUE (TITLE, P_ID, COMP_ID, WORK_PID, WORK_IID, VERSION)
) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE INDEX TITLE_INDEX ON PANDA_DOCS.FILE (TITLE(248));
CREATE INDEX P_ID_INDEX ON PANDA_DOCS.FILE (P_ID);
CREATE INDEX COMP_ID_INDEX ON PANDA_DOCS.FILE (COMP_ID);
CREATE INDEX WORK_PID_INDEX ON PANDA_DOCS.FILE (WORK_PID);
CREATE INDEX WORK_IID_INDEX ON PANDA_DOCS.FILE (WORK_IID);
CREATE INDEX S_ID_INDEX ON PANDA_DOCS.FILE (S_ID(40));

########################################################################################################

GRANT ALL ON PANDA_DOCS.* TO adocs@'%' IDENTIFIED BY 'adocspass';
FLUSH PRIVILEGES;