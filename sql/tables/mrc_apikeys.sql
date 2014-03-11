
DROP TABLE IF EXISTS mrc_apikeys;

CREATE TABLE mrc_apikeys (
	id      BIGINT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	user_id BIGINT NOT NULL,
	apikey  CHAR(40) NOT NULL,
	acvite  ENUM('Y','N') NOT NULL DEFAULT 'Y',
	created DATETIME NOT NULL,
	deactivated DATETIME NULL

)CHARSET='utf8' COLLATE='utf8_general_ci';

