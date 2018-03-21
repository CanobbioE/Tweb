INSERT INTO users (fname, lname, username, passwd)
VALUES 	('aaaa', 'aaaa', 'aaaaaaaa', '1'),
		('bbbb', 'bbbb', 'bbbbbbbb', '2'),
		('cccc', 'cccc', 'cccccccc', '3'),
		('dddd', 'dddd', 'dddddddd', '4'),
		('eeee', 'eeee', 'eeeeeeee', '5'),
		('ffff', 'ffff', 'ffffffff', '6'),
		('aaaa', 'aaaa', 'beta', 	 '7');

INSERT INTO events (id_manager, event_date, title, description)
VALUES 	(1, '2017-01-30', 'Onions gathering', 'Come pick up your own onion!' ),
		(1, '2017-02-02', 'Carrot gathering', 'Come pick up your own carrot!' ),
		(1, '2017-03-30', 'Parrot gathering', 'Come pick up your own parrot!' ),
		(1, '2017-04-30', 'Kraken gathering', 'Come pick up your own kraken!' ),
		(1, '2017-05-30', 'Pancakes gathering', 'Come pick up your own pancake!' ),
		(1, '2017-06-30', 'Pantyhoses gathering', 'Come pick up your own pantyhose!' ),
		(1, '2017-07-30', 'Fantasy gathering', 'Maybe you need some ideas for descriptions...' );

INSERT INTO requests (id_product, id_buyer, quantity)
VALUES 	('1', '1', '12'),
		('2', '1', '11'),
		('8', '2', '1'),
		('7', '2', '1'),
		('5', '3', '111'),
		('5', '7', '111');