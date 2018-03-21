DROP TABLE IF EXISTS users;
CREATE TABLE users (
	id INT AUTO_INCREMENT PRIMARY KEY,
	fname VARCHAR(16) NOT NULL,
	lname VARCHAR(16) NOT NULL,
	username VARCHAR(32) NOT NULL UNIQUE,
	passwd VARCHAR(76) NOT NULL,
	email VARCHAR(64) DEFAULT NULL
);

DROP TABLE IF EXISTS products;
CREATE TABLE products (
	id INT AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(16) NOT NULL,
	type VARCHAR(16) NOT NULL,
	description TEXT DEFAULT NULL,
	img VARCHAR(16) NOT NULL
);

DROP TABLE IF EXISTS requests;
CREATE TABLE requests (
	id INT AUTO_INCREMENT PRIMARY KEY,
	id_product INT NOT NULL,
	id_buyer INT NOT NULL,
	id_seller INT DEFAULT NULL,
	quantity INT DEFAULT 1
);

DROP TABLE IF EXISTS events;
CREATE TABLE events (
	id INT AUTO_INCREMENT PRIMARY KEY,
	id_manager INT NOT NULL,
	event_date DATE NOT NULL,
	title VARCHAR(32) NOT NULL,
	description VARCHAR(128) NOT NULL
);

INSERT INTO products (name, type, img, description)
VALUES	('firewood', 	'resource', 'firewood.png',		'Keep your house warm.'),
		('cobble', 		'resource', 'cobble.png', 		'Always usefull for path and such.'),
		('dirt', 		'resource', 'dirt.png', 		'Your plants will love this.'),
		('shovel', 		'tool', 	'shovel.png', 		'Dig dig dig.'),
		('pick', 		'tool', 	'pick.png', 		'For intensive digging.'),
		('pitchfork', 	'tool', 	'pitchfork.png', 	'Move your lawn.'),
		('transport', 	'service',	'transport.png', 	'Travelling together.'),
		('babysitting', 'service', 	'babysitting.png', 	'Put an eye on those kids.'),
		('vet', 		'service', 	'vet.png', 			'Taking care of your puppies.');
		