
DROP TABLE IF EXISTS mrc_user_tokens;

CREATE TABLE mrc_user_tokens (
	id      BIGINT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	user_id BIGINT NOT NULL,
	token   VARCHAR(40) NOT NULL,
	active  ENUM('Y','N') DEFAULT 'N',
	created DATETIME NOT NULL,
	expires DATETIME NOT NULL
)CHARSET='utf8' COLLATE='utf8_general_ci';

