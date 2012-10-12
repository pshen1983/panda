CREATE DATABASE PANDA_WOMA;

##############################################################################################

CREATE TABLE PANDA_WOMA.WORKPACKAGE
(
	ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
	OWNER_ID INT UNSIGNED NOT NULL,
	CREATOR_ID INT UNSIGNED NOT NULL,

	OBJECTIVE NVARCHAR(321) NOT NULL,
	DESCRIPTION TEXT NOT NULL,

	STATUS NVARCHAR(5) NOT NULL,

	CREATION_TIME DATE NOT NULL,
	LASTUPDATED_TIME DATETIME NOT NULL,
	LASTUPDATED_USER INT UNSIGNED NOT NULL,
	DEADLINE DATE NOT NULL,

	PROJ_ID INT UNSIGNED NOT NULL,
	COMP_ID INT UNSIGNED,
	S_ID INT UNSIGNED NOT NULL,

	PRIMARY KEY (ID),
	FOREIGN KEY (OWNER_ID) REFERENCES PANDA_USER.USER (ID),
	FOREIGN KEY (CREATOR_ID) REFERENCES PANDA_USER.USER (ID),
	FOREIGN KEY (PROJ_ID) REFERENCES PANDA_PROJ.PROJECT (ID),
	FOREIGN KEY (LASTUPDATED_USER) REFERENCES PANDA_USER.USER (ID)
) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE INDEX OBJECTIVE_INDEX ON PANDA_WOMA.WORKPACKAGE (OBJECTIVE(320));
CREATE INDEX COMP_ID_INDEX ON PANDA_WOMA.WORKPACKAGE (COMP_ID);
CREATE INDEX S_ID_INDEX ON PANDA_WOMA.WORKPACKAGE (S_ID);
CREATE INDEX STATUS_INDEX ON PANDA_WOMA.WORKPACKAGE (STATUS(4));
CREATE INDEX CREATION_TIME_INDEX ON PANDA_WOMA.WORKPACKAGE (CREATION_TIME);
CREATE INDEX DEADLINE_INDEX ON PANDA_WOMA.WORKPACKAGE (DEADLINE);
CREATE INDEX LASTUPDATED_TIME_INDEX ON PANDA_WOMA.WORKPACKAGE (LASTUPDATED_TIME);

##############################################################################################

CREATE TABLE PANDA_WOMA.COMMENT_WP
(
	ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
	WORKPACKAGE_ID INT UNSIGNED NOT NULL,
	CREATOR_ID INT UNSIGNED NOT NULL,

	CONTENT TEXT NOT NULL,

	MODIFIED DATETIME NOT NULL,

	PRIMARY KEY (ID),
	FOREIGN KEY (WORKPACKAGE_ID) REFERENCES PANDA_WOMA.WORKPACKAGE (ID),
	FOREIGN KEY (CREATOR_ID) REFERENCES PANDA_USER.USER (ID)
) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

##############################################################################################

CREATE TABLE PANDA_WOMA.WORKITEM
(
	ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
	PW_ID INT UNSIGNED NOT NULL,
	OWNER_ID INT UNSIGNED NOT NULL,
	CREATOR_ID INT UNSIGNED NOT NULL,

	PROJ_ID INT UNSIGNED NOT NULL,
	COMP_ID INT UNSIGNED,
	WORKPACKAGE_ID INT UNSIGNED,
	LINKWORKPACKAGE_ID INT UNSIGNED,

	TITLE NVARCHAR(321) NOT NULL,
	DESCRIPTION TEXT,

	TYPE NVARCHAR(5) NOT NULL,
	STATUS NVARCHAR(5) NOT NULL,
	PRIORITY NVARCHAR(5) NOT NULL,

	CREATION_TIME DATE NOT NULL,
	LASTUPDATED_TIME DATETIME NOT NULL,
	LASTUPDATED_USER INT UNSIGNED NOT NULL,
	DEADLINE DATE,
	S_ID INT UNSIGNED NOT NULL,

	PRIMARY KEY (ID),
	FOREIGN KEY (PROJ_ID) REFERENCES PANDA_PROJ.PROJECT (ID),
	FOREIGN KEY (COMP_ID) REFERENCES PANDA_PROJ.PROJCOMP (ID),
	FOREIGN KEY (OWNER_ID) REFERENCES PANDA_USER.USER (ID),
	FOREIGN KEY (CREATOR_ID) REFERENCES PANDA_USER.USER (ID),
	FOREIGN KEY (LASTUPDATED_USER) REFERENCES PANDA_USER.USER (ID),
	UNIQUE (PW_ID, PROJ_ID)
) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE INDEX PW_ID_INDEX ON PANDA_WOMA.WORKITEM (PW_ID);
CREATE INDEX COMP_ID_INDEX ON PANDA_WOMA.WORKITEM (COMP_ID);
CREATE INDEX WORKPACKAGE_ID_INDEX ON PANDA_WOMA.WORKITEM (WORKPACKAGE_ID);
CREATE INDEX LINKWORKPACKAGE_ID_INDEX ON PANDA_WOMA.WORKITEM (LINKWORKPACKAGE_ID);
CREATE INDEX TITLE_INDEX ON PANDA_WOMA.WORKITEM (TITLE(320));
CREATE INDEX S_ID_INDEX ON PANDA_WOMA.WORKITEM (S_ID);
CREATE INDEX TYPE_INDEX ON PANDA_WOMA.WORKITEM (TYPE(4));
CREATE INDEX STATUS_INDEX ON PANDA_WOMA.WORKITEM (STATUS(4));
CREATE INDEX PRIORITY_INDEX ON PANDA_WOMA.WORKITEM (PRIORITY(4));
CREATE INDEX CREATION_TIME_INDEX ON PANDA_WOMA.WORKITEM (CREATION_TIME);
CREATE INDEX DEADLINE_INDEX ON PANDA_WOMA.WORKITEM (DEADLINE);
CREATE INDEX LASTUPDATED_TIME_INDEX ON PANDA_WOMA.WORKITEM (LASTUPDATED_TIME);

##############################################################################################

CREATE TABLE PANDA_WOMA.COMMENT_WI
(
	ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
	WORKITEM_ID INT UNSIGNED NOT NULL,
	CREATOR_ID INT UNSIGNED NOT NULL,

	CONTENT TEXT NOT NULL,

	MODIFIED DATETIME NOT NULL,

	PRIMARY KEY (ID),
	FOREIGN KEY (WORKITEM_ID) REFERENCES PANDA_WOMA.WORKITEM (ID),
	FOREIGN KEY (CREATOR_ID) REFERENCES PANDA_USER.USER (ID)
) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

##############################################################################################

CREATE TABLE PANDA_WOMA.SUBSCRIPTION
(
	ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
	PROJ_ID INT UNSIGNED NOT NULL,
	WORKITEM_ID INT UNSIGNED NOT NULL,
	USER_ID INT UNSIGNED NOT NULL,

	PRIMARY KEY (ID),
	FOREIGN KEY (PROJ_ID) REFERENCES PANDA_PROJ.PROJECT (ID),
	FOREIGN KEY (WORKITEM_ID) REFERENCES PANDA_WOMA.WORKITEM (ID),
	FOREIGN KEY (USER_ID) REFERENCES PANDA_USER.USER (ID),
	UNIQUE (WORKITEM_ID, USER_ID)
) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

##############################################################################################

CREATE TABLE PANDA_WOMA.DEPENDENCY
(
	ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
	INDEPENDENT_ID INT UNSIGNED NOT NULL,
	DEPENDENT_ID INT UNSIGNED NOT NULL,
	COMMENT TINYTEXT,

	PRIMARY KEY (ID),
	FOREIGN KEY (INDEPENDENT_ID) REFERENCES PANDA_WOMA.WORKITEM (ID),
	FOREIGN KEY (DEPENDENT_ID) REFERENCES PANDA_WOMA.WORKITEM (ID),
	CONSTRAINT DEPENDENCY CHECK (INDEPENDENT_ID<>DEPENDENT_ID),
	UNIQUE (INDEPENDENT_ID, DEPENDENT_ID)
) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

##############################################################################################

GRANT ALL ON PANDA_WOMA.* TO awoma IDENTIFIED BY 'awomapass';
FLUSH PRIVILEGES;