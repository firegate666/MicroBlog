CREATE TABLE Blog (
	id INTEGER PRIMARY KEY,
	title text
);

CREATE TABLE Post (
	id INTEGER PRIMARY KEY,
	blogId INTEGER NOT NULL,
	content text
);

CREATE TABLE Comment (
	id INTEGER PRIMARY KEY,
	postId INTEGER NOT NULL,
	content text
);
