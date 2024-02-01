<?php

define('SQLITE_DB', 'test.db');

$pdo = new PDO('sqlite:' . SQLITE_DB);

$sqlScript = <<<EOF
CREATE TABLE IF NOT EXISTS Album (
    id_Album          VARCHAR(42) NOT NULL,
    titre_Album       VARCHAR(42),
    genre_Album       VARCHAR(42),
    annee_Sortie      VARCHAR(42),
    img_Album         VARCHAR(42),
    compositeur_Album VARCHAR(42),
    PRIMARY KEY (id_Album)
);

CREATE TABLE IF NOT EXISTS Appartenir (
    id_Genre VARCHAR(42) NOT NULL,
    id_Album VARCHAR(42) NOT NULL,
    PRIMARY KEY (id_Genre, id_Album),
    FOREIGN KEY (id_Album) REFERENCES Album (id_Album),
    FOREIGN KEY (id_Genre) REFERENCES Genre (id_Genre)
);

CREATE TABLE IF NOT EXISTS Artistes (
    id_Artistes  VARCHAR(42) NOT NULL,
    nom_Artistes VARCHAR(42),
    img_Artistes VARCHAR(42),
    PRIMARY KEY (id_Artistes)
);

CREATE TABLE IF NOT EXISTS Avoir (
    id_Playlist    VARCHAR(42) NOT NULL,
    id_Utilisateur VARCHAR(42) NOT NULL,
    PRIMARY KEY (id_Playlist, id_Utilisateur),
    FOREIGN KEY (id_Utilisateur) REFERENCES Utilisateur (id_Utilisateur),
    FOREIGN KEY (id_Playlist) REFERENCES Playlist (id_Playlist)
);

CREATE TABLE IF NOT EXISTS Composer (
    id_Musique  VARCHAR(42) NOT NULL,
    id_Artistes VARCHAR(42) NOT NULL,
    PRIMARY KEY (id_Musique, id_Artistes),
    FOREIGN KEY (id_Artistes) REFERENCES Artistes (id_Artistes),
    FOREIGN KEY (id_Musique) REFERENCES Musique (id_Musique)
);

CREATE TABLE IF NOT EXISTS Contenir (
    id_Album   VARCHAR(42) NOT NULL,
    id_Musique VARCHAR(42) NOT NULL,
    PRIMARY KEY (id_Album, id_Musique),
    FOREIGN KEY (id_Album) REFERENCES Album (id_Album),
    FOREIGN KEY (id_Musique) REFERENCES Musique (id_Musique)
);

CREATE TABLE IF NOT EXISTS Creer (
    id_Artistes VARCHAR(42) NOT NULL,
    id_Album    VARCHAR(42) NOT NULL,
    PRIMARY KEY (id_Artistes, id_Album),
    FOREIGN KEY (id_Artistes) REFERENCES Artistes (id_Artistes),
    FOREIGN KEY (id_Album) REFERENCES Album (id_Album)
);

CREATE TABLE IF NOT EXISTS Genre (
    id_Genre  VARCHAR(42) NOT NULL,
    nom_Genre VARCHAR(42),
    PRIMARY KEY (id_Genre)
);

CREATE TABLE IF NOT EXISTS Interpreter (
    id_Musique  VARCHAR(42) NOT NULL,
    id_Artistes VARCHAR(42) NOT NULL,
    PRIMARY KEY (id_Musique, id_Artistes),
    FOREIGN KEY (id_Artistes) REFERENCES Artistes (id_Artistes),
    FOREIGN KEY (id_Musique) REFERENCES Musique (id_Musique)
);

CREATE TABLE IF NOT EXISTS Musique (
    id_Musique           VARCHAR(42) NOT NULL,
    nom_Musique          VARCHAR(42),
    genre_Musique        VARCHAR(42),
    interprete_Musique   VARCHAR(42),
    Compositeur_Musique  VARCHAR(42),
    annee_Sortie_Musique VARCHAR(42),
    PRIMARY KEY (id_Musique)
);

CREATE TABLE IF NOT EXISTS NOTE (
    id_Note          VARCHAR(42) NOT NULL,
    id_Utilisateur_1 VARCHAR(42),
    id_Album         VARCHAR(42),
    note             VARCHAR(42),
    id_Utilisateur_2 VARCHAR(42) NOT NULL,
    PRIMARY KEY (id_Note),
    FOREIGN KEY (id_Album) REFERENCES Album (id_Album),
    FOREIGN KEY (id_Utilisateur_2) REFERENCES Utilisateur (id_Utilisateur)
);

CREATE TABLE IF NOT EXISTS Noter (
    id_Utilisateur VARCHAR(42) NOT NULL,
    id_Album       VARCHAR(42) NOT NULL,
    note           VARCHAR(42),
    PRIMARY KEY (id_Utilisateur, id_Album),
    FOREIGN KEY (id_Album) REFERENCES Album (id_Album),
    FOREIGN KEY (id_Utilisateur) REFERENCES Utilisateur (id_Utilisateur)
);

CREATE TABLE IF NOT EXISTS Playlist (
    id_Playlist  VARCHAR(42) NOT NULL,
    nom_Playlist VARCHAR(42),
    PRIMARY KEY (id_Playlist)
);

CREATE TABLE IF NOT EXISTS Renfermer (
    id_Playlist VARCHAR(42) NOT NULL,
    id_Musique  VARCHAR(42) NOT NULL,
    PRIMARY KEY (id_Playlist, id_Musique),
    FOREIGN KEY (id_Playlist) REFERENCES Playlist (id_Playlist),
    FOREIGN KEY (id_Musique) REFERENCES Musique (id_Musique)
);

CREATE TABLE IF NOT EXISTS Utilisateur (
    id_Utilisateur  VARCHAR(42) NOT NULL,
    nom_Utilisateur VARCHAR(42),
    mdp_Utilisateur VARCHAR(42),
    img_Utilisateur VARCHAR(42),
    PRIMARY KEY (id_Utilisateur)
);

ALTER TABLE Appartenir ADD FOREIGN KEY (id_Album) REFERENCES Album (id_Album);
ALTER TABLE Appartenir ADD FOREIGN KEY (id_Genre) REFERENCES Genre (id_Genre);

ALTER TABLE Avoir ADD FOREIGN KEY (id_Utilisateur) REFERENCES Utilisateur (id_Utilisateur);
ALTER TABLE Avoir ADD FOREIGN KEY (id_Playlist) REFERENCES Playlist (id_Playlist);

ALTER TABLE Composer ADD FOREIGN KEY (id_Artistes) REFERENCES Artistes (id_Artistes);
ALTER TABLE Composer ADD FOREIGN KEY (id_Musique) REFERENCES Musique (id_Musique);

ALTER TABLE Contenir ADD FOREIGN KEY (id_Musique) REFERENCES Musique (id_Musique);
ALTER TABLE Contenir ADD FOREIGN KEY (id_Album) REFERENCES Album (id

EOF;

if ($sqlScript) {
    try {
        $pdo->exec($sqlScript);
        echo 'Database setup successfully.' . PHP_EOL;
    } catch (PDOException $e) {
        var_dump($e->getMessage());
    }
}