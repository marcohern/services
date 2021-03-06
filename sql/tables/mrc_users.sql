
DROP TABLE IF EXISTS mrc_users;

CREATE TABLE mrc_users (
	id       BIGINT       NOT NULL PRIMARY KEY AUTO_INCREMENT,
	username VARCHAR(64)  NOT NULL UNIQUE,
	password CHAR(40)     NOT NULL,
	email    VARCHAR(128) NOT NULL UNIQUE,
	role     ENUM('ADMIN','USER') NOT NULL DEFAULT 'ADMIN',
	pmode    ENUM('NATIVE','EXTENDED') NOT NULL DEFAULT 'NATIVE',

	preset   ENUM('Y','N') NOT NULL DEFAULT 'N',
	ptoken   CHAR(40)         NULL,
	ptokex   DATETIME         NULL,
	
	created  DATETIME     NOT NULL,
	updated  DATETIME         NULL
)CHARSET='utf8' COLLATE='utf8_general_ci';


