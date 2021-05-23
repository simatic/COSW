BEGIN TRANSACTION;
CREATE TABLE IF NOT EXISTS "Users" (
	"id"	INTEGER NOT NULL,
	"first_name"	VARCHAR(50) NOT NULL,
	"last_name"	VARCHAR(50) NOT NULL,
	"email"	VARCHAR(255) NOT NULL,
	"roles"	CLOB NOT NULL,
	"type"	VARCHAR(255) NOT NULL,
	"password"	VARCHAR(255) DEFAULT NULL,
	"username"	VARCHAR(30) DEFAULT NULL,
	PRIMARY KEY("id" AUTOINCREMENT)
);
CREATE TABLE IF NOT EXISTS "account_request" (
	"id"	INTEGER NOT NULL,
	"first_name"	VARCHAR(50) NOT NULL COLLATE BINARY,
	"last_name"	VARCHAR(50) NOT NULL COLLATE BINARY,
	"email"	VARCHAR(255) NOT NULL COLLATE BINARY,
	"status"	VARCHAR(255) NOT NULL DEFAULT 'PENDING',
	PRIMARY KEY("id" AUTOINCREMENT)
);
INSERT INTO "Users" ("id","first_name","last_name","email","roles","type","password","username") VALUES (1,'Gibril','Gunder','gibril.gunder@telecom-sudparis.eu','["ROLE_ADMIN"]','admin','$argon2id$v=19$m=65536,t=4,p=1$SWZjc3h5N2VlSEhpR0FhMg$YzWvqpFOwS2ebtIOcBkdgYKnkCD/XbJBnSy3pBI1W3E',NULL);
INSERT INTO "Users" ("id","first_name","last_name","email","roles","type","password","username") VALUES (2,'Michel','Simatic','michel.simatic@telecom-sudparis.eu','["ROLE_CREATOR"]','creator','$argon2id$v=19$m=65536,t=4,p=1$dGUvMjVhNXJNaVk5dUFxcg$Rd1xjawBLtY2GbdNxT1mjZiR7WHkrqGY5EF68vJWoTM',NULL);
INSERT INTO "Users" ("id","first_name","last_name","email","roles","type","password","username") VALUES (7,'John','Doe','john.doe@gmail.com','["ROLE_USER"]','creator','$argon2id$v=19$m=65536,t=4,p=1$aDlFMkdhN1IvUW9YUjhJcA$xO7gBGxpers0D/ppTD3t3MrddJAvhzQaxQOTR5iiMtA',NULL);
INSERT INTO "Users" ("id","first_name","last_name","email","roles","type","password","username") VALUES (9,'Hello','World','hello.world@gmail.com','{"0":"ROLE_USER","2":"ROLE_CREATOR"}','creator','$argon2id$v=19$m=65536,t=4,p=1$VVRjcUF0cFBJYXJHdEpsRg$vdaD8mMOCjFUvmuhBT1aKPQUObKlAJWQJ1+Q/RZRe+0',NULL);
INSERT INTO "Users" ("id","first_name","last_name","email","roles","type","password","username") VALUES (10,'Zaki','Biroum','zaki.biroum@telecom-sudparis.eu','{"0":"ROLE_USER","1":"ROLE_ADMIN"}','admin','$argon2id$v=19$m=65536,t=4,p=1$WW1JUmZraHQ4a3huZ1h5bA$uweXy9doHQKoTDn4Flne2VjZLHqoLPgVx1L9yotS728',NULL);
INSERT INTO "Users" ("id","first_name","last_name","email","roles","type","password","username") VALUES (11,'Khalil Mehdi','Meziou','khalil.meziou@telecom-sudparis.eu','{"0":"ROLE_USER","1":"ROLE_ADMIN"}','admin','$argon2id$v=19$m=65536,t=4,p=1$UGJzYkhyajRxYmVENGs2bQ$1dD52WNy7+RJBcouaAnVSQgo1Q7qKA4HP4bf+xG3yQA',NULL);
INSERT INTO "Users" ("id","first_name","last_name","email","roles","type","password","username") VALUES (12,'Maxime','Verchain','maxime.verchain@telecom-sudparis.eu','{"0":"ROLE_USER","1":"ROLE_ADMIN"}','admin','$argon2id$v=19$m=65536,t=4,p=1$RG5tVjk3UVhqT28yWGxRbw$DYNFBDJwuHBU1xc8obK0wMhfPEpktEsl27l1s2BaTOc',NULL);
INSERT INTO "Users" ("id","first_name","last_name","email","roles","type","password","username") VALUES (13,'a','b','a.b@hello.com','{"0":"ROLE_USER","2":"ROLE_CREATOR"}','creator','$argon2id$v=19$m=65536,t=4,p=1$bVM4cHZlVWZZb1Q4N3pBdg$f0wbACFFZqLhjTV1jkMFNpaHx8kvELFw2HWAFa5XShY',NULL);
INSERT INTO "account_request" ("id","first_name","last_name","email","status") VALUES (1,'Albert','Einstein','albert.einstein@gmail.com','PENDING');
INSERT INTO "account_request" ("id","first_name","last_name","email","status") VALUES (9,'Jack','O''Lantern','jack.olantern@gmail.com','VALIDATED');
CREATE UNIQUE INDEX IF NOT EXISTS "UNIQ_D5428AEDE7927C74" ON "Users" (
	"email"
);
CREATE UNIQUE INDEX IF NOT EXISTS "UNIQ_F2BC9BD7E7927C74" ON "account_request" (
	"email"
);
COMMIT;
