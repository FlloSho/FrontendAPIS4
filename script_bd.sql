CREATE TABLE Joueur(
   id BIGINT auto_increment,
   nom VARCHAR(30)  NOT NULL,
   prenom VARCHAR(30)  NOT NULL,
   numeroLicence BIGINT NOT NULL,
   dateNaissance DATE NOT NULL,
   taille INT NOT NULL,
   poids INT NOT NULL,
   statut VARCHAR(50)  NOT NULL,
   PRIMARY KEY(id),
   UNIQUE(numeroLicence)
);

CREATE TABLE MatchHockey(
   id BIGINT auto_increment,
   dateHeure DATETIME NOT NULL,
   nomAdversaire VARCHAR(50)  NOT NULL,
   lieu VARCHAR(50)  NOT NULL,
   resultat VARCHAR(50) ,
   PRIMARY KEY(id)
);

CREATE TABLE Utilisateur(
   id INT auto_increment,
   username VARCHAR(50)  NOT NULL,
   password VARCHAR(100)  NOT NULL,
   PRIMARY KEY(id),
   UNIQUE(username)
);

CREATE TABLE Commentaire(
   id INT auto_increment,
   commentaire VARCHAR(50) ,
   id_1 BIGINT NOT NULL,
   PRIMARY KEY(id),
   FOREIGN KEY(id_1) REFERENCES Joueur(id)
);

CREATE TABLE Participe(
   id BIGINT,
   id_1 BIGINT,
   poste VARCHAR(50)  NOT NULL,
   note INT,
   titulaire BOOLEAN NOT NULL,
   PRIMARY KEY(id, id_1),
   FOREIGN KEY(id) REFERENCES Joueur(id),
   FOREIGN KEY(id_1) REFERENCES MatchHockey(id)
);
