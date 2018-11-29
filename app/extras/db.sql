CREATE DATABASE iprinter_db;
use iprinter_db;


CREATE TABLE user(
	user_id 	INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	username	VARCHAR(20) NOT NULL UNIQUE,
	password VARCHAR(100) NOT NULL
);


CREATE TABLE oauth_access(
	id 				INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	refresh_token  VARCHAR(255) NOT NULL,
	token				VARCHAR(255) NOT NULL,
	token_expires  INT NOT NULL,
	
	printer_id		VARCHAR(255),
	printer_name	VARCHAR(255),
	
	date_register 	TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	date_update		TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	
	status				VARCHAR(20) NOT NULL DEFAULT 'ON',
	
	fk_user			INT NOT NULL UNIQUE,
	FOREIGN KEY (fk_user) REFERENCES user(user_id) ON UPDATE CASCADE ON DELETE CASCADE
);


INSERT INTO user(username, password) VALUES
('carlos', 	md5('123456')),
('jesus', 	md5('123456')),
('alex',	 	md5('123456'));


INSERT INTO google_access(token, token_expires, refresh_token, fk_user) 
VALUES ('asdasdasd', 3600 , asdadsdadas , 1 )