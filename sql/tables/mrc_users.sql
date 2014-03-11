
DROP TABLE IF EXISTS mrc_users;

CREATE TABLE mrc_users (
	id       BIGINT       NOT NULL PRIMARY KEY AUTO_INCREMENT,
	username VARCHAR(64)  NOT NULL UNIQUE,
	password CHAR(40)     NOT NULL,
	s1       CHAR(10)     NOT NULL,
	s2       CHAR(10)     NOT NULL,
	email    VARCHAR(256) NOT NULL UNIQUE,
	role     ENUM('ADMIN','USER') NOT NULL DEFAULT 'ADMIN',
	created  DATETIME     NOT NULL,
	updated  DATETIME         NULL
)CHARSET='utf8' COLLATE='utf8_general_ci';

--UQI[lc3gUg~3
