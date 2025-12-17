CREATE DATABASE assad_bd;
USE assad_bd;
CREATE TABLE utilisateur (
    id_usr INT AUTO_INCREMENT PRIMARY KEY,
    nom_usr VARCHAR(255) NOT NULL,
    email_usr VARCHAR(255) NOT NULL UNIQUE,
    role_usr VARCHAR(50) NOT NULL,
    motdepasse_hash VARCHAR(255) NOT NULL
);
CREATE TABLE habitatt (
    id_hab INT AUTO_INCREMENT PRIMARY KEY,
    nom_hab VARCHAR(255) NOT NULL,
    typeclimat VARCHAR(255),
    description_hab TEXT,
    zonezoo VARCHAR(255)
);
CREATE TABLE visite_guidee (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    dateheure DATETIME,
    langue VARCHAR(50),
    capacite_max INT,
    duree INT, 
    prix DECIMAL(10, 2),
    statut VARCHAR(50),
    id_utilisateur INT,
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateur(id_usr)
);

CREATE TABLE etapesvisite (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titreetape VARCHAR(255),
    descriptionetape TEXT,
    ordreetape INT,
    id_visite INT,
    FOREIGN KEY (id_visite) REFERENCES visite_guidee(id) 
);
CREATE TABLE reservations (
    id_res INT AUTO_INCREMENT PRIMARY KEY,
    nbpersonnes INT,
    datereservation DATETIME DEFAULT CURRENT_TIMESTAMP,
    id_visite INT,
    id_utilisateur INT,
    FOREIGN KEY (id_visite) REFERENCES visite_guidee(id) ,
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateur(id_usr) 
);
CREATE TABLE commentaires (
    id_cmt INT AUTO_INCREMENT PRIMARY KEY,
    note INT,
    texte TEXT,
    date_commentaire DATETIME DEFAULT CURRENT_TIMESTAMP,
    id_visite INT,
    id_utilisateur INT,
    FOREIGN KEY (id_visite) REFERENCES visite_guidee(id),
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateur(id_usr)
);
CREATE TABLE animal (
    id_al INT AUTO_INCREMENT PRIMARY KEY,
    nom_al VARCHAR(255) NOT NULL,
    espece VARCHAR(255),
    alimentation VARCHAR(255),
    image VARCHAR(255),
    paysorigine VARCHAR(255),
    descriptioncourte TEXT,
    id_habitat INT,
    FOREIGN KEY (id_habitat) REFERENCES habitatt(id_hab) 
);