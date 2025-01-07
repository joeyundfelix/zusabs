CREATE TABLE IF NOT EXISTS "guestbook" (
	"id"	INTEGER NOT NULL,
	"user_id"	int(11) NOT NULL,
	"first_name"	text NOT NULL,
	"last_name"	text NOT NULL,
	"text"	text NOT NULL,
	"time"	text NOT NULL,
	PRIMARY KEY("id" AUTOINCREMENT)
);

CREATE TABLE IF NOT EXISTS "user" (
	"user_id"	INTEGER NOT NULL,
	"user_first_name"	text NOT NULL,
	"user_last_name"	text NOT NULL,
	"user_email"	text NOT NULL,
	"user_password"	text NOT NULL,
	PRIMARY KEY("user_id" AUTOINCREMENT)
);

CREATE TABLE IF NOT EXISTS "zusabs" (
	"id"	INTEGER NOT NULL,
	"user_id"	int(11) NOT NULL,
	"first_name"	text NOT NULL,
	"last_name"	text NOT NULL,
	"auswahl"	int(11) NOT NULL,
	PRIMARY KEY("id" AUTOINCREMENT)
);

INSERT INTO user VALUES(1,'Demo','Mustermensch','demo@example.org','demopassword');
