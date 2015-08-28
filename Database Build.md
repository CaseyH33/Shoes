
/Applications/MAMP/Library/bin/mysql --host=localhost -uroot -proot

CREATE DATABASE shoes;
USE shoes;
CREATE TABLE stores (name VARCHAR(255), id serial PRIMARY KEY);
CREATE TABLE brands (brand_name VARCHAR(255), id serial PRIMARY KEY);
CREATE TABLE brands_stores (brand_id int, store_id int, id serial PRIMARY KEY);
