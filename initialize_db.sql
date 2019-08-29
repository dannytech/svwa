USE svwa;

CREATE TABLE Users (
    id int NOT NULL AUTO_INCREMENT,
    username varchar(32) NOT NULL,
    passhash varchar(32),
    salt varchar(8),
    PRIMARY KEY (id)
);

INSERT INTO Users (username, passhash, salt) VALUES
    ("admin", "3c3f4d315377b5e37f2bb326f56fc883", ""), -- VULNERABILITY: No salt. Password is svwawillneverbehacked.
    ("test", "3625588380958ea4dafc356fe53e1cc5", "1e44");

CREATE TABLE Flags (
    id varchar(32) NOT NULL,
    flag varchar(255) NOT NULL,
    points int NOT NULL,
    PRIMARY KEY (flag)
);
