BEGIN TRANSACTION;

-- Table "Users"

DROP TABLE IF EXISTS "Users"
CREATE TABLE IF NOT EXISTS "Users" (
	"id"	INTEGER NOT NULL,
	"first_name"	VARCHAR(50) NOT NULL,
	"last_name"	VARCHAR(50) NOT NULL,
	"email"	VARCHAR(255) UNIQUE NOT NULL,
	"roles"	CLOB NOT NULL,
	"type"	VARCHAR(255) NOT NULL,
	"password"	VARCHAR(255) DEFAULT NULL,
	"username"	VARCHAR(30) DEFAULT NULL,
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

-- Table "account_request"

DROP TABLE IF EXISTS "account_request"
CREATE TABLE IF NOT EXISTS "account_request" (
	"id"	INTEGER NOT NULL,
	"first_name"	VARCHAR(50) NOT NULL,
	"last_name"	VARCHAR(50) NOT NULL,
	"email"	VARCHAR(255) UNIQUE NOT NULL,
	"status"	VARCHAR(255) NOT NULL DEFAULT 'PENDING',
	PRIMARY KEY("id" AUTOINCREMENT)
);

INSERT INTO "account_request" ("id","first_name","last_name","email","status") VALUES (1,'Albert','Einstein','albert.einstein@gmail.com','PENDING');
INSERT INTO "account_request" ("id","first_name","last_name","email","status") VALUES (9,'Jack','O''Lantern','jack.olantern@gmail.com','VALIDATED');


-- Contraintes

CREATE UNIQUE INDEX IF NOT EXISTS "UNIQ_D5428AEDE7927C74" ON "Users" (
	"email"
);
CREATE UNIQUE INDEX IF NOT EXISTS "UNIQ_F2BC9BD7E7927C74" ON "account_request" (
	"email"
);

-- Table "commentaire"

DROP TABLE IF EXISTS "commentaire";
CREATE TABLE IF NOT EXISTS "commentaire" (
  "id" INTEGER NOT NULL,
  "soutenance_id" INTEGER NOT NULL,
  "auteur" VARCHAR(255) NOT NULL,
  "contenu" TEXT NOT NULL,
  "note" REAL NOT NULL,
  PRIMARY KEY ("id" AUTOINCREMENT),
  FOREIGN KEY("soutenance_id") REFERENCES "soutenance"("id")
);

-- Table "evaluation"

DROP TABLE IF EXISTS "evaluation";
CREATE TABLE IF NOT EXISTS "evaluation" (
  "id" INT NOT NULL,
  "soutenance_id" INT DEFAULT NULL,
  "user_id" INT DEFAULT NULL,
  "note" REAL DEFAULT NULL,
  "item_id" INT NOT NULL,
  PRIMARY KEY ("id" AUTOINCREMENT),
  FOREIGN KEY("soutenance_id") REFERENCES "soutenance"("id"),
  FOREIGN KEY("user_id") REFERENCES "Users"("id"),
  FOREIGN KEY("item_id") REFERENCES "item"("id")
);

-- Table "eval_item"

DROP TABLE IF EXISTS "eval_item";
CREATE TABLE IF NOT EXISTS "eval_item" (
  "id" INT NOT NULL,
  "soutenance_id" INT NOT NULL,
  "user_id" INT DEFAULT NULL,
  "item_id" INT NOT NULL,
  "note" REAL NOT NULL,
  PRIMARY KEY ("id" AUTOINCREMENT),
  FOREIGN KEY("item_id") REFERENCES "item"("id"),
  FOREIGN KEY("soutenance_id") REFERENCES "soutenance"("id"),
  FOREIGN KEY("user_id") REFERENCES "Users"("id")
);

INSERT INTO "eval_item" ("id", "soutenance_id", "user_id", "item_id", "note") VALUES (1, 6, 11, 12, 2);

-- Table "fiche_evaluation"

DROP TABLE IF EXISTS "fiche_evaluation";
CREATE TABLE IF NOT EXISTS "fiche_evaluation" (
  "id" INT NOT NULL,
  "evaluateur_id" INT DEFAULT NULL,
  "soutenance_id" INT DEFAULT NULL,
  "note_final" REAL NOT NULL,
  "ponderation" REAL NOT NULL,
  "nom" VARCHAR(255)  NOT NULL,
  PRIMARY KEY ("id" AUTOINCREMENT),
  FOREIGN KEY("evaluateur_id") REFERENCES "Users"("id"),
  FOREIGN KEY("soutenance_id") REFERENCES "soutenance"("id")
);

INSERT INTO "fiche_evaluation" ("id", "evaluateur_id", "soutenance_id", "note_final", "ponderation", "nom") VALUES (1, 11, 1, 0, 1, 'Fiche 1');

-- Table "item"

DROP TABLE IF EXISTS "item";
CREATE TABLE IF NOT EXISTS "item" (
  "id" INT NOT NULL,
  "rubrique_id" INT DEFAULT NULL,
  "nom" VARCHAR(255)  NOT NULL,
  "note" REAL NOT NULL,
  PRIMARY KEY ("id" AUTOINCREMENT),
);

INSERT INTO "item" ("id", "rubrique_id", "nom", "note") VALUES
(1, 1, "Qualité", 20),
(2, 4, "Qualité intrinsèque de la conceptualisation finition de l\'obje l’appli", 5),
(3, 4, 'Est-ce que l’objet et l’appli répondent à la problématique?', 5),
(4, 4, 'Originalité de l’objet l’appli', 5),
(5, 4, "Facilité d’utilisation de l\'objet de l’appli", 5),
(6, 6, 'Fond', 10),
(7, 6, 'Forme', 10),
(8, 2, 'Pitch', 20),
(10, 3, 'vidéo', 20),
(11, 7, 'item1', 10),
(12, 7, 'item2', 10),
(13, 8, 'LOL1', 5),
(14, 8, 'LOL2', 5),
(15, 9, 'LOL1', 5),
(16, 9, 'LOL2', 5),
(17, 10, 'LOL1', 5),
(18, 10, 'LOL2', 5),
(19, 13, 'haha', 10),
(20, 13, 'lul', 10),
(21, 14, 'iteeems', 20),
(22, 15, 'iteeems', 10),
(23, 15, 'tezst', 10);

-- Table "modele"

DROP TABLE IF EXISTS "modele";
CREATE TABLE IF NOT EXISTS "modele" (
  "id" INT NOT NULL,
  "name" VARCHAR(255)  NOT NULL,
  PRIMARY KEY ("id" AUTOINCREMENT)
);

INSERT INTO "modele" ("id", "name") VALUES
(1, 'Classique'),
(2, 'Iot'),
(3, 'Modele_test'),
(4, 'Hello'),
(5, 'Modele_test7'),
(6, 'Modele_test4'),
(7, 'teste'),
(8, 'testeee'),
(9, 'eeeeeeee'),
(10, 'Modele_testde'),
(11, 'Modele_test8'),
(12, 'Modele_test8'),
(13, 'Modele_test8222'),
(14, 'Modele_test8222'),
(15, 'Modele_test_final'),
(16, 'modeletoto'),
(17, 'Modèle 1'),
(20, 'modelcsv20'),
(21, 'modelcsv20'),
(22, 'csv'),
(23, 'mdele'),
(24, 'amaaaaan'),
(25, 'trah');

-- Table "modele_item"

DROP TABLE IF EXISTS "modele_item";
CREATE TABLE IF NOT EXISTS "modele_item" (
  "modele_id" INT NOT NULL,
  "item_id" INT NOT NULL,
  PRIMARY KEY ("modele_id", "item_id"),
  FOREIGN KEY("modele_id") REFERENCES "modele"("id"),
  FOREIGN KEY("item_id") REFERENCES "item"("id")
);

INSERT INTO "modele_item" ("modele_id", "item_id") VALUES
(13, 2),
(13, 3),
(13, 4),
(13, 5),
(13, 6),
(13, 7),
(14, 2),
(14, 3),
(14, 4),
(14, 5),
(14, 6),
(14, 7),
(15, 2),
(15, 3),
(15, 4),
(15, 5),
(15, 6),
(15, 7),
(16, 2),
(16, 3),
(16, 4),
(16, 5),
(16, 6),
(16, 7),
(16, 10),
(17, 2),
(17, 3),
(17, 4),
(17, 5),
(17, 11),
(17, 12),
(22, 2),
(22, 3),
(22, 4),
(22, 5),
(22, 6),
(22, 7),
(23, 1),
(23, 8),
(23, 10),
(24, 2),
(24, 3),
(24, 4),
(24, 5),
(24, 10);

-- Table "modele_rubrique"

DROP TABLE IF EXISTS "modele_rubrique";
CREATE TABLE IF NOT EXISTS "modele_rubrique" (
  "modele_id" INT NOT NULL,
  "rubrique_id" INT NOT NULL,
  PRIMARY KEY ("modele_id", "rubrique_id"),
  FOREIGN KEY("modele_id") REFERENCES "modele"("id"),
  FOREIGN KEY("rubrique_id") REFERENCES "rubrique"("id")
);

INSERT INTO "modele_rubrique" ("modele_id", "rubrique_id") VALUES
(1, 1),
(1, 2),
(1, 3),
(2, 1),
(2, 4),
(2, 6),
(3, 1),
(3, 2),
(3, 4),
(4, 4),
(4, 6),
(5, 4),
(5, 6),
(6, 4),
(6, 6),
(7, 4),
(7, 6),
(8, 4),
(9, 4),
(10, 3),
(10, 4),
(10, 6),
(11, 3),
(11, 4),
(11, 6),
(12, 3),
(12, 4),
(12, 6),
(13, 4),
(13, 6),
(14, 4),
(14, 6),
(15, 4),
(15, 6),
(16, 3),
(16, 4),
(16, 6),
(17, 4),
(17, 7),
(20, 11),
(21, 12),
(22, 4),
(22, 6),
(23, 1),
(23, 2),
(23, 3),
(23, 12),
(24, 3),
(24, 4),
(25, 2),
(25, 3);

-- Table "rubrique"

DROP TABLE IF EXISTS "rubrique";
CREATE TABLE IF NOT EXISTS "rubrique" (
  "id" INT NOT NULL,
  "commentaire" TEXT NOT NULL,
  "nom" VARCHAR(255)  NOT NULL,
  PRIMARY KEY ("id", AUTOINCREMENT)
);

INSERT INTO "rubrique" ("id", "commentaire", "nom") VALUES
(1, '', 'Code'),
(2, '', 'Pitch'),
(3, '', 'Vidéo'),
(4, '', 'Objet connecté'),
(6, '', 'Présentation oral'),
(7, '', 'Rubrique'),
(8, '', 'LOOl'),
(9, '', 'LOOl'),
(10, '', 'LOOl'),
(11, '', 'rubrique111'),
(12, '', 'rubrique111'),
(13, '', 'LOOL'),
(14, '', 'HAHAAHHAHAHA'),
(15, '', 'HAHAAHHAHAHAHEHEHEHEHEH');

-- Table "session"

DROP TABLE IF EXISTS "session";
CREATE TABLE IF NOT EXISTS "session" (
  "id" INT NOT NULL,
  "date" TEXT NOT NULL,
  "nom" VARCHAR(255) NOT NULL,
  PRIMARY KEY ("id" AUTOINCREMENT)
);

INSERT INTO "session" ("id", "date", "nom") VALUES (1, '2016-01-01 00:00:00', 'Session du 05/05/2021');

-- Table "soutenance"

DROP TABLE IF EXISTS "soutenance";
CREATE TABLE IF NOT EXISTS "soutenance" (
  "id" INT NOT NULL,
  "session_id" INT DEFAULT NULL,
  "titre" VARCHAR(255)  NOT NULL,
  "description" TEXT  NOT NULL,
  "image" VARCHAR(255)  NOT NULL,
  "date_soutenance" TEXT NOT NULL,
  "note" REAL NOT NULL,
  "modele_id" INT NOT NULL,
  PRIMARY KEY ("id" AUTOINCREMENT),
  FOREIGN KEY("session_id") REFERENCES "session"("id"),
  FOREIGN KEY("modele_id") REFERENCES "modele"("id")
);

INSERT INTO "soutenance" ("id", "session_id", "titre", "description", "image", "date_soutenance", "note", "modele_id") VALUES
(1, 1, 'Soutenance test', 'Soutenance', 'http://www.science-du-numerique.fr/wp-content/uploads/2019/02/url2-768x618.jpg', '2016-01-01 00:00:00', 0, 1),
(2, 1, 'Soutenance test 2', 'Test', 'http://www.science-du-numerique.fr/wp-content/uploads/2019/02/url2-768x618.jpg', '2016-01-01 00:00:00', 0, 11),
(3, 1, 'Soutenance test 25', 'dd', 'http://www.science-du-numerique.fr/wp-content/uploads/2019/02/url2-768x618.jpg', '2016-01-01 00:00:00', 0, 15),
(4, 1, 'Soutenance test', 'dd', 'http://www.science-du-numerique.fr/wp-content/uploads/2019/02/url2-768x618.jpg', '2016-01-01 00:00:00', 0, 15),
(5, 1, 'Soutenance test 1000', 'bla bla', 'http://www.science-du-numerique.fr/wp-content/uploads/2019/02/url2-768x618.jpg', '2016-01-01 00:00:00', 0, 16),
(6, 1, 'Soutenance', 'Description', 'http://www.science-du-numerique.fr/wp-content/uploads/2019/02/url2-768x618.jpg', '2016-01-01 00:00:00', 0, 17);

-- Table "upload"

DROP TABLE IF EXISTS "upload";
CREATE TABLE IF NOT EXISTS "upload" (
  "id" INT NOT NULL,
  "name" VARCHAR(255)  NOT NULL,
  PRIMARY KEY ("id" AUTOINCREMENT)
);