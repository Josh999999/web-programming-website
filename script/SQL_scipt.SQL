##SQL - web programming project - CREATE / INSERT Script:


##DROP ALL TABLES in a DATABASE:
SELECT CONCAT('DROP TABLE IF EXISTS `', table_name, '`;')
FROM information_schema.tables
WHERE table_schema = 's5411715';
##copy AND paste the results of this and run it.

##The result is this:
DROP TABLE IF EXISTS `access_level`;
DROP TABLE IF EXISTS `course`;
DROP TABLE IF EXISTS `customers`;
DROP TABLE IF EXISTS `product_types`;
DROP TABLE IF EXISTS `role`;
DROP TABLE IF EXISTS `task`;
DROP TABLE IF EXISTS `task_course`;
DROP TABLE IF EXISTS `task_type`;
DROP TABLE IF EXISTS `user_course`;
DROP TABLE IF EXISTS `user_type`;
DROP TABLE IF EXISTS `users`;


##CREATE DATABASE - Can not use on BU DB:
##CREATE DATABASE IF NOT EXISTS web_programming;

##SELECT DATABASE:
USE s5411715;


##DROP TABLES if they already exist in the database:
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS order_groups;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS customers;
DROP TABLE IF EXISTS product_types;
DROP TABLE IF EXISTS user_type;

##Declare CURDATE():
SET @current_date1 := CURDATE();

##CREATE TABLES:
CREATE TABLE user_type(
	user_type_id INT,
	name VARCHAR(50) NOT NULL,
	access_type INT NOT NULL,
	CONSTRAINT user_types_pk PRIMARY KEY (user_type_id)
);

CREATE TABLE customers (
	user_id INT AUTO_INCREMENT,
	username VARCHAR(50) NOT NULL,
	password VARCHAR(500) NOT NULL,
	first_name VARCHAR(50) NOT NULL,
	last_name VARCHAR(50) NOT NULL,
	phone VARCHAR(12) NOT NULL,
	email VARCHAR(50) NOT NULL,
	address VARCHAR(50),
	post_code VARCHAR(9) NOT NULL,
	country VARCHAR(20) NOT NULL,
	gender INT,
	dob DATE NOT NULL,
	user_type_id INT NOT NULL,
	CONSTRAINT check_age CHECK (DATEDIFF(dob, "06/11/2022") >= 18),
	CONSTRAINT check_email CHECK (email LIKE '%_@_%.___%'),
	CONSTRAINT check_phone CHECK (phone LIKE '_____ ______'),
	CONSTRAINT check_password CHECK (LENGTH(password) >= 8),
	CONSTRAINT customers_pk PRIMARY KEY (user_id),
	CONSTRAINT check_user_type_id CHECK (0 < user_type_id < 3),
	CONSTRAINT user_type_id_fk FOREIGN KEY (user_type_id) REFERENCES user_type(user_type_id)
);


##SET VARIABLE to check against:
##The IDs of these item names are the same as the indexes they would have in a python / java standard array:
##SET @product_types_arr := ("guitar", "amplifiers", "strings", "picks", "parts", "book", "stand", "bag", "cable", "strap");

CREATE TABLE product_types (
	product_type_id INT AUTO_INCREMENT,
	name VARCHAR(30),
	CONSTRAINT product_types_pk PRIMARY KEY (product_type_id)
);


CREATE TABLE products (
	product_id INT AUTO_INCREMENT,
	name VARCHAR(30) NOT NULL,
	description VARCHAR(250) NOT NULL,
	price DECIMAL(8, 2) NOT NULL,
	date_listed DATETIME NOT NULL,
	image_reference VARCHAR(200) NOT NULL,
	product_type_id INT,
	user_id INT,
	quantity INT NOT NULL,
	CONSTRAINT products_pk PRIMARY KEY (product_id),
	CONSTRAINT products_customers_fk FOREIGN KEY (user_id) REFERENCES customers(user_id) ON DELETE SET NULL,
	CONSTRAINT products_product_types_fk FOREIGN KEY (product_type_id) REFERENCES product_types(product_type_id) ON DELETE SET NULL
);


CREATE TABLE order_groups (
	order_group_id INT AUTO_INCREMENT,
	date_ordered DATE NOT NULL,
	user_id INT,
	CONSTRAINT order_groups_pk PRIMARY KEY (order_group_id),
	CONSTRAINT order_groups_customers_fk FOREIGN KEY (user_id) REFERENCES customers(user_id) ON DELETE SET NULL
);


CREATE TABLE orders (
	order_group_id INT AUTO_INCREMENT,
	quantity INT NOT NULL,
	product_id INT,
	CONSTRAINT orders_pk PRIMARY KEY (order_group_id, product_id),
	CONSTRAINT orders_order_groups_fk FOREIGN KEY (order_group_id) REFERENCES order_groups(order_group_id),
	CONSTRAINT orders_products_fk FOREIGN KEY (product_id) REFERENCES products(product_id)
);


##INSERT script for user_type:
INSERT INTO user_type (user_type_id, name, access_type) VALUES(0, "unregistered user", access_type=0);
INSERT INTO user_type (user_type_id, name, access_type) VALUES(1, "Registered user", access_type=1);
INSERT INTO user_type (user_type_id, name, access_type) VALUES(2, "Admin", access_type=2);

##INSERT script for the user:
INSERT INTO customers (username, password, first_name, last_name, phone, email, address, post_code, country, gender, dob, user_type_id) VALUES("Joshua", "Joshua100#", "Joshua", "Morgan", "07807 098076", "JJMorgan2003@gmail.com", "10 Sandy Lane", "BH21 2NF", "England", 1, "2003-03-15", 2);
INSERT INTO customers (username, password, first_name, last_name, phone, email, address, post_code, country, gender, dob, user_type_id) VALUES("David", "David100#", "Joshua", "Morgan", "07807 095676", "DDWhalley2000@gmail.com", "11 Sandy Lane", "BH21 2NF", "England", 1, "2001-09-17", 1);
INSERT INTO customers (username, password, first_name, last_name, phone, email, address, post_code, country, gender, dob, user_type_id) VALUES("James", "James100#", "Joshua", "Morgan", "07807 098876", "JKSmith2001@gmail.com", "15 Sunny Lane", "BH21 2NF", "England", 1, "2000-12-03", 1);
INSERT INTO customers (username, password, first_name, last_name, phone, email, address, post_code, country, gender, dob, user_type_id) VALUES("Alex", "Alex100#", "Joshua", "Morgan", "07807 034076", "ARKeylly2003@gmail.com", "21 Sandy Lane", "BH21 2NF", "England", 0, "1996-01-27", 1);

##INSERT script for product_types , To create the closed values:
INSERT INTO product_types (product_type_id, name) VALUES(1, "guitar");
INSERT INTO product_types (product_type_id, name) VALUES(2, "amplifiers");
INSERT INTO product_types (product_type_id, name) VALUES(3, "strings");
INSERT INTO product_types (product_type_id, name) VALUES(4, "picks");
INSERT INTO product_types (product_type_id, name) VALUES(5, "parts");
INSERT INTO product_types (product_type_id, name) VALUES(6, "book");
INSERT INTO product_types (product_type_id, name) VALUES(7, "stand");
INSERT INTO product_types (product_type_id, name) VALUES(8, "bag");
INSERT INTO product_types (product_type_id, name) VALUES(9, "cable");
INSERT INTO product_types (product_type_id, name) VALUES(10, "strap");

##INSERT script1 for the products:
INSERT INTO products (name, description, price, date_listed, image_reference, product_type_id, user_id, quantity) VALUES("Guitar1", "14 year old Acoustic guitar. Base made from birtch wood, and strings all new", 256.98, "2022-05-25", "prod1.jpg", 1, 1, 5);
INSERT INTO products (name, description, price, date_listed, image_reference, product_type_id, user_id, quantity) VALUES("Guitar2", "5 year old electric guitar. Well made, strings need replacing. (comes with working cable not with and amp)", 300.99, "2021-07-29", "prod2.jpg", 1, 1, 9);
INSERT INTO products (name, description, price, date_listed, image_reference, product_type_id, user_id, quantity) VALUES("Guitar3", "10 year old Acoustic guitar. Base made from oak wood, and strings all new", 224.45, "2009-05-01", "prod3.jpg", 1, 1, 6);
INSERT INTO products (name, description, price, date_listed, image_reference, product_type_id, user_id, quantity) VALUES("Guitar4", "Sleek black Acoustic guiter, 34 inch, good condition", 450.00, "2015-07-25", "prod4.jpg", 1, 1, 4);
INSERT INTO products (name, description, price, date_listed, image_reference, product_type_id, user_id, quantity) VALUES("Guitar5", "Rare and strange type of guitar, probibly for collectors (found in old storage unit)", 156.99, "2003-03-31", "prod5.jpg", 1, 1, 9);
INSERT INTO products (name, description, price, date_listed, image_reference, product_type_id, user_id, quantity) VALUES("Guitar6", "Acoustic guitar, Carbon,fiber,body, 44mm nut width, 648mm, Matt,finish", 945.66, "2022-06-15", "prod6.jpg", 1, 1, 11);
INSERT INTO products (name, description, price, date_listed, image_reference, product_type_id, user_id, quantity) VALUES("Guitar7", "Black acoustic guitar, 50mm, oak body , Matt,finish", 189.95, "2018-11-14", "prod7.jpg", 1, 1, 12);
INSERT INTO products (name, description, price, date_listed, image_reference, product_type_id, user_id, quantity) VALUES("Guitar8", "Traditional wooden Acoustic guitar , 6 years old , great condition", 255.68, "2022-05-25", "prod8.jpg", 1, 1, 14);

##INSERT script2 for the products:
INSERT INTO products (name, description, price, date_listed, image_reference, product_type_id, user_id, quantity) VALUES("Ammplifier1", "TweedToneV 5 watt value electric guitar ammplifier", 256.98, "2022-05-25", "prod9.jpg", 2, 1, 5);
INSERT INTO products (name, description, price, date_listed, image_reference, product_type_id, user_id, quantity) VALUES("Ammplifier2", "Donner Electric Guitar Amplifier 10 Watt Classical Guitar AMP DEA,1", 300.99, "2021-07-29", "prod10.jpg", 2, 1, 6);
INSERT INTO products (name, description, price, date_listed, image_reference, product_type_id, user_id, quantity) VALUES("Ammplifier3", "ROLAND JC,120 JAZZ CHORUS GUITAR AMPLIFIER", 224.45, "2009-05-01", "prod11.jpg", 2, 1, 7);

##INSERT script3 for the products:
INSERT INTO products (name, description, price, date_listed, image_reference, product_type_id, user_id, quantity) VALUES("Book1", "Accoutstic guitars, the most complete value guide on acoustic guitars", 56.99, "2003-03-31", "prod12.png", 6, 1, 8);
INSERT INTO products (name, description, price, date_listed, image_reference, product_type_id, user_id, quantity) VALUES("Strap1", "brown leather electric guitar strap , Supports up to 30kg", 25.66, "2022-06-15", "prod13.png", 10, 1, 9);
INSERT INTO products (name, description, price, date_listed, image_reference, product_type_id, user_id, quantity) VALUES("Case1", "Black (felt interior) electirc guitar case , can support any guitar 60mm X 20mm", 89.95, "2018-11-14", "prod14.png", 8, 1, 12);


