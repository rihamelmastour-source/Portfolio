-- ===========================================================
-- GESTDEP
-- Gestion des Déplacements Professionnels
-- Version Finale
-- MySQL 8+
-- ===========================================================

CREATE DATABASE IF NOT EXISTS gestdep
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE gestdep;

-- ===========================================================
-- TABLE ROLES
-- ===========================================================

CREATE TABLE roles (

    id INT AUTO_INCREMENT PRIMARY KEY,

    nom VARCHAR(50) NOT NULL UNIQUE,

    description VARCHAR(255),

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

);

INSERT INTO roles(nom,description) VALUES

('Administrateur','Gestion complète'),

('Responsable','Validation des déplacements'),

('Employe','Création des demandes');

-- ===========================================================
-- TABLE DEPARTEMENTS
-- ===========================================================

CREATE TABLE departements(

id INT AUTO_INCREMENT PRIMARY KEY,

nom VARCHAR(120) NOT NULL UNIQUE,

description VARCHAR(255),

created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

);

INSERT INTO departements(nom) VALUES

('Direction'),

('Administration'),

('Informatique'),

('Finance'),

('Ressources Humaines'),

('Commercial'),

('Logistique');

-- ===========================================================
-- TABLE POSTES
-- ===========================================================

CREATE TABLE postes(

id INT AUTO_INCREMENT PRIMARY KEY,

nom VARCHAR(120) UNIQUE,

description VARCHAR(255)

);

INSERT INTO postes(nom) VALUES

('Administrateur'),

('Responsable'),

('Employé'),

('Technicien'),

('Comptable');

-- ===========================================================
-- TABLE TRANSPORTS
-- ===========================================================

CREATE TABLE transports(

id INT AUTO_INCREMENT PRIMARY KEY,

nom VARCHAR(100) UNIQUE

);

INSERT INTO transports(nom) VALUES

('Voiture'),

('Taxi'),

('Train'),

('Bus'),

('Avion'),

('Moto');

-- ===========================================================
-- TABLE ETATS
-- ===========================================================

CREATE TABLE etats(

id INT AUTO_INCREMENT PRIMARY KEY,

nom VARCHAR(100),

couleur VARCHAR(30),

ordre_affichage INT

);

INSERT INTO etats(

nom,

couleur,

ordre_affichage

)

VALUES

('En attente','#f39c12',1),

('Validé Responsable','#3498db',2),

('Validé','#27ae60',3),

('Refusé','#e74c3c',4),

('Annulé','#95a5a6',5);

-- ===========================================================
-- TABLE UTILISATEURS
-- ===========================================================

CREATE TABLE utilisateurs(

id INT AUTO_INCREMENT PRIMARY KEY,

role_id INT NOT NULL,

departement_id INT NOT NULL,

poste_id INT NOT NULL,

nom VARCHAR(100) NOT NULL,

prenom VARCHAR(100) NOT NULL,

email VARCHAR(150) UNIQUE NOT NULL,

telephone VARCHAR(30),

matricule VARCHAR(30) UNIQUE,

photo VARCHAR(255) DEFAULT 'avatar.png',

signature VARCHAR(255),

password VARCHAR(255) NOT NULL,

actif TINYINT(1) DEFAULT 1,

created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

updated_at TIMESTAMP NULL,

FOREIGN KEY(role_id)

REFERENCES roles(id),

FOREIGN KEY(departement_id)

REFERENCES departements(id),

FOREIGN KEY(poste_id)

REFERENCES postes(id)

);

-- ===========================================================
-- TABLE VILLES
-- ===========================================================

CREATE TABLE villes(

id INT AUTO_INCREMENT PRIMARY KEY,

nom VARCHAR(120) UNIQUE

);

INSERT INTO villes(nom)

VALUES

('Rabat'),

('Salé'),

('Temara'),

('Casablanca'),

('Tanger'),

('Marrakech'),

('Agadir'),

('Meknès'),

('Fès'),

('Oujda');

-- ===========================================================
-- TABLE DEPLACEMENTS
-- ===========================================================

CREATE TABLE deplacements(

id INT AUTO_INCREMENT PRIMARY KEY,

numero VARCHAR(30) UNIQUE,

utilisateur_id INT NOT NULL,

ville_depart INT NOT NULL,

ville_arrivee INT NOT NULL,

transport_id INT NOT NULL,

etat_id INT NOT NULL,

objet VARCHAR(255) NOT NULL,

description TEXT,

date_depart DATE,

heure_depart TIME,

date_retour DATE,

heure_retour TIME,

distance DECIMAL(10,2),

cout_estime DECIMAL(10,2),

avance DECIMAL(10,2),

created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

updated_at TIMESTAMP NULL,

FOREIGN KEY(utilisateur_id)

REFERENCES utilisateurs(id),

FOREIGN KEY(ville_depart)

REFERENCES villes(id),

FOREIGN KEY(ville_arrivee)

REFERENCES villes(id),

FOREIGN KEY(transport_id)

REFERENCES transports(id),

FOREIGN KEY(etat_id)

REFERENCES etats(id)

);
-- ===========================================================
-- TABLE WORKFLOW_VALIDATION
-- ===========================================================

CREATE TABLE workflow_validation (

    id INT AUTO_INCREMENT PRIMARY KEY,

    deplacement_id INT NOT NULL,

    valide_par INT NOT NULL,

    etat_avant INT NOT NULL,

    etat_apres INT NOT NULL,

    commentaire TEXT,

    date_validation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (deplacement_id)
        REFERENCES deplacements(id)
        ON DELETE CASCADE,

    FOREIGN KEY (valide_par)
        REFERENCES utilisateurs(id),

    FOREIGN KEY (etat_avant)
        REFERENCES etats(id),

    FOREIGN KEY (etat_apres)
        REFERENCES etats(id)

);

-- ===========================================================
-- TABLE PIECES_JOINTES
-- ===========================================================

CREATE TABLE pieces_jointes (

    id INT AUTO_INCREMENT PRIMARY KEY,

    deplacement_id INT NOT NULL,

    nom_original VARCHAR(255) NOT NULL,

    nom_stockage VARCHAR(255) NOT NULL,

    extension VARCHAR(10) NOT NULL,

    type_mime VARCHAR(150) NOT NULL,

    taille BIGINT NOT NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (deplacement_id)
        REFERENCES deplacements(id)
        ON DELETE CASCADE

);

-- ===========================================================
-- TABLE HISTORIQUE
-- ===========================================================

CREATE TABLE historique (

    id INT AUTO_INCREMENT PRIMARY KEY,

    utilisateur_id INT NOT NULL,

    action VARCHAR(150) NOT NULL,

    table_concernee VARCHAR(100),

    element_id INT,

    details TEXT,

    adresse_ip VARCHAR(50),

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (utilisateur_id)
        REFERENCES utilisateurs(id)

);

-- ===========================================================
-- TABLE NOTIFICATIONS
-- ===========================================================

CREATE TABLE notifications (

    id INT AUTO_INCREMENT PRIMARY KEY,

    utilisateur_id INT NOT NULL,

    type VARCHAR(50) NOT NULL,

    titre VARCHAR(255) NOT NULL,

    message TEXT NOT NULL,

    url VARCHAR(255),

    lu TINYINT(1) DEFAULT 0,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (utilisateur_id)
        REFERENCES utilisateurs(id)

);

-- ===========================================================
-- TABLE PARAMETRES
-- ===========================================================

CREATE TABLE parametres (

    id INT AUTO_INCREMENT PRIMARY KEY,

    societe VARCHAR(150) NOT NULL,

    adresse TEXT,

    telephone VARCHAR(50),

    email VARCHAR(150),

    logo VARCHAR(255),

    couleur_principale VARCHAR(20),

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

);

INSERT INTO parametres (

    societe,
    adresse,
    telephone,
    email,
    logo,
    couleur_principale

)

VALUES (

    'ISICOD',

    'Temara',

    '',

    '',

    'logo.png',

    '#0F4C81'

);

-- ===========================================================
-- TABLE LOGS_CONNEXION
-- ===========================================================

CREATE TABLE logs_connexion (

    id INT AUTO_INCREMENT PRIMARY KEY,

    utilisateur_id INT NOT NULL,

    date_connexion DATETIME NOT NULL,

    adresse_ip VARCHAR(50),

    navigateur TEXT,

    FOREIGN KEY (utilisateur_id)
        REFERENCES utilisateurs(id)

);

-- ===========================================================
-- INDEX
-- ===========================================================

CREATE INDEX idx_utilisateur_email
ON utilisateurs(email);

CREATE INDEX idx_utilisateur_matricule
ON utilisateurs(matricule);

CREATE INDEX idx_deplacement_numero
ON deplacements(numero);

CREATE INDEX idx_deplacement_etat
ON deplacements(etat_id);

CREATE INDEX idx_notification_utilisateur
ON notifications(utilisateur_id);

CREATE INDEX idx_historique_utilisateur
ON historique(utilisateur_id);
-- ===========================================================
-- ADMINISTRATEUR PAR DEFAUT
-- Email : admin@gestdep.com
-- Mot de passe : admin123
-- ===========================================================

INSERT INTO utilisateurs (

    role_id,
    departement_id,
    poste_id,
    nom,
    prenom,
    email,
    telephone,
    matricule,
    photo,
    signature,
    password,
    actif

)

VALUES (

    1,
    1,
    1,
    'Admin',
    'GESTDEP',
    'admin@gestdep.com',
    '',
    'ADM001',
    'avatar.png',
    '',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    1

);

-- ===========================================================
-- DONNEES D'EXEMPLE
-- ===========================================================

INSERT INTO deplacements (

    numero,
    utilisateur_id,
    ville_depart,
    ville_arrivee,
    transport_id,
    etat_id,
    objet,
    description,
    date_depart,
    heure_depart,
    date_retour,
    heure_retour,
    distance,
    cout_estime,
    avance

)

VALUES (

    'DEP-2026-00001',

    1,

    1,

    2,

    1,

    1,

    'Réunion de travail',

    'Déplacement professionnel',

    '2026-07-01',

    '08:00:00',

    '2026-07-01',

    '17:30:00',

    25,

    150,

    100

);

-- ===========================================================
-- VUE : LISTE COMPLETE DES DEPLACEMENTS
-- ===========================================================

CREATE VIEW vue_deplacements AS

SELECT

d.id,

d.numero,

u.nom,

u.prenom,

vd.nom AS ville_depart,

va.nom AS ville_arrivee,

t.nom AS transport,

e.nom AS etat,

d.objet,

d.date_depart,

d.date_retour,

d.distance,

d.cout_estime,

d.avance

FROM deplacements d

INNER JOIN utilisateurs u

ON d.utilisateur_id=u.id

INNER JOIN villes vd

ON d.ville_depart=vd.id

INNER JOIN villes va

ON d.ville_arrivee=va.id

INNER JOIN transports t

ON d.transport_id=t.id

INNER JOIN etats e

ON d.etat_id=e.id;

-- ===========================================================
-- PROCEDURE : NUMERO AUTOMATIQUE
-- ===========================================================

DELIMITER $$

CREATE PROCEDURE GenererNumeroDeplacement(

OUT numero_genere VARCHAR(30)

)

BEGIN

DECLARE dernier INT;

SELECT IFNULL(MAX(id),0)+1

INTO dernier

FROM deplacements;

SET numero_genere = CONCAT(

'DEP-',

YEAR(CURDATE()),

'-',

LPAD(dernier,5,'0')

);

END $$

DELIMITER ;

-- ===========================================================
-- FIN
-- ===========================================================

COMMIT;