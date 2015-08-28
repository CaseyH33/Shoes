# Shoes and Where to Find Them

##### A site to list shoes brands and stores

#### By Casey Heitz

## Description

This application allows a user to input both stores and shoe brands.  Users are allowed to add a brand to a certain store, and add a store to a certain brand.  A store's information can  be edited, and the store can be deleted.  Also, each store can be clicked on, and a list of the associated brands will be shown. When clicking on brands, associated stores will be listed.

## Setup
* If building database, follow these instructions in terminal (otherwise import the zipped database file):

    * To access MySQL:
        * /Applications/MAMP/Library/bin/mysql --host=localhost -uroot -proot
    * In MySQL:
        * CREATE DATABASE shoes;
        * USE shoes;
        * CREATE TABLE stores (name VARCHAR(255), phone_number VARCHAR(255), address VARCHAR(255), id serial PRIMARY KEY);
        * CREATE TABLE brands (brand_name VARCHAR(255), id serial PRIMARY KEY);
        * CREATE TABLE brands_stores (brand_id int, store_id int, id serial PRIMARY KEY);

* To run webpage:
    * Run composer install in Terminal from the project root folder.
    * Start the PHP server from Terminal in the /web folder.
    * Open a web browser and navigate to "localhost:8000".


## Technologies Used

PHP, PHPUnit, Silex, Twig, MySQL.

### Legal

Copyright (c) 2015 Casey Heitz

This software is licensed under the MIT license.

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
