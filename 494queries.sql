CREATE TABLE login (
userid int NOT NULL AUTO_INCREMENT,
username varchar(20) NOT NULL,
password varchar(100) NOT NULL,
UNIQUE (username),
PRIMARY KEY (userid)
) ENGINE = InnoDB;