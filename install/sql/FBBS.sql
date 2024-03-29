CREATE DATABASE PANDA_FBBS;

########################################################################################################

CREATE TABLE PANDA_FBBS.FORUM_SECTION
(
	ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
	SID INT UNSIGNED NOT NULL,
	TITLE NVARCHAR(42) NOT NULL,
	LANGUAGE NVARCHAR(3) NOT NULL,
	DESCRIPTION NVARCHAR(256) NOT NULL,

	PRIMARY KEY (ID)
) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE INDEX TITLE_INDEX ON PANDA_FBBS.FORUM_SECTION (TITLE(41));
CREATE INDEX LANGUAGE_INDEX ON PANDA_FBBS.FORUM_SECTION (LANGUAGE(2));

########################################################################################################

CREATE TABLE PANDA_FBBS.FORUM_THREAD
(
	ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
	SID INT UNSIGNED NOT NULL,
	TITLE NVARCHAR(42) NOT NULL,
	CREATOR INT UNSIGNED NOT NULL,
	VCOUNT INT UNSIGNED NOT NULL,
	CTIME DATETIME NOT NULL,
	LREP INT UNSIGNED NOT NULL,
	LTIME DATETIME NOT NULL,
	TOP ENUM('N','Y') NOT NULL,

	PRIMARY KEY (ID),
	FOREIGN KEY (CREATOR) REFERENCES PANDA_USER.USER (ID),
	FOREIGN KEY (LREP) REFERENCES PANDA_USER.USER (ID)
) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE INDEX SID_INDEX ON PANDA_FBBS.FORUM_THREAD (SID);
CREATE INDEX TITLE_INDEX ON PANDA_FBBS.FORUM_THREAD (TITLE(41));
CREATE INDEX LTIME_INDEX ON PANDA_FBBS.FORUM_THREAD (LTIME);
CREATE INDEX TOP_INDEX ON PANDA_FBBS.FORUM_THREAD (TOP);

########################################################################################################

CREATE TABLE PANDA_FBBS.FORUM_MESSAGE
(
	ID INT NOT NULL AUTO_INCREMENT,
	SID INT UNSIGNED NOT NULL,
	TID INT UNSIGNED NOT NULL,
	REPLY INT UNSIGNED,
	BODY TEXT NOT NULL,
	CREATOR INT UNSIGNED NOT NULL,
	CTIME DATETIME NOT NULL,

	PRIMARY KEY (ID),
	FOREIGN KEY (TID) REFERENCES PANDA_FBBS.FORUM_THREAD (ID)
) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE INDEX SID_INDEX ON PANDA_FBBS.FORUM_MESSAGE (SID);
CREATE INDEX CTIME_INDEX ON PANDA_FBBS.FORUM_MESSAGE (CTIME);

########################################################################################################

GRANT ALL ON PANDA_FBBS.* TO afbbs@'%' IDENTIFIED BY 'afbbspass';
FLUSH PRIVILEGES;

USE PANDA_FBBS;

INSERT INTO FORUM_SECTION (SID, TITLE, LANGUAGE, DESCRIPTION) VALUES (1, 'News and Announcements', 'en', 'News and announcements');
INSERT INTO FORUM_SECTION (SID, TITLE, LANGUAGE, DESCRIPTION) VALUES (1, '新闻公告', 'zh', 'ProjNote 的新闻与公告');
INSERT INTO FORUM_SECTION (SID, TITLE, LANGUAGE, DESCRIPTION) VALUES (2, 'General', 'en', 'General discussion');
INSERT INTO FORUM_SECTION (SID, TITLE, LANGUAGE, DESCRIPTION) VALUES (2, '分享讨论', 'zh', '分享与讨论');
INSERT INTO FORUM_SECTION (SID, TITLE, LANGUAGE, DESCRIPTION) VALUES (3, 'ProjNote Support', 'en', 'Support');
INSERT INTO FORUM_SECTION (SID, TITLE, LANGUAGE, DESCRIPTION) VALUES (3, '技术问答', 'zh', '技术问答与支持');
INSERT INTO FORUM_SECTION (SID, TITLE, LANGUAGE, DESCRIPTION) VALUES (4, 'Site Feedback', 'en', 'Provide feedback and comments on ProjNote');
INSERT INTO FORUM_SECTION (SID, TITLE, LANGUAGE, DESCRIPTION) VALUES (4, '意见建议', 'zh', '请提出你的建议和意见');