drop table if exists users;
CREATE TABLE users (
    username VARCHAR(50) PRIMARY KEY,
    password VARCHAR(100) NOT NULL);
INSERT INTO users(username,password) VALUES ('waph-team31',md5('Pa$$w0rd'));

