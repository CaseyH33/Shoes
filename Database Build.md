
/Applications/MAMP/Library/bin/mysql --host=localhost -uroot -proot

CREATE DATABASE shoes;
USE shoes;
CREATE TABLE stores (name VARCHAR(255), id serial PRIMARY KEY);
