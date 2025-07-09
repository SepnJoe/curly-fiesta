-- Datenbank erstellen (optional)
CREATE DATABASE IF NOT EXISTS testdb;
USE testdb;

-- Tabelle: Benutzer
CREATE TABLE IF NOT EXISTS Benutzer
(
    ID       INT AUTO_INCREMENT PRIMARY KEY,
    `E-Mail` VARCHAR(255) NOT NULL UNIQUE,
    Passwort VARCHAR(255) NOT NULL
);

-- Tabelle: Land
CREATE TABLE IF NOT EXISTS Land
(
    ID       INT AUTO_INCREMENT PRIMARY KEY,
    Landname VARCHAR(255) NOT NULL
);

-- Tabelle: Ort
CREATE TABLE IF NOT EXISTS Ort
(
    ID       INT AUTO_INCREMENT PRIMARY KEY,
    plz      VARCHAR(20)  NOT NULL,
    Ortsname VARCHAR(255) NOT NULL,
    land_id  INT          NOT NULL,
    FOREIGN KEY (land_id) REFERENCES Land (ID)
);

-- Tabelle: Anschrift
CREATE TABLE IF NOT EXISTS Anschrift
(
    ID         INT AUTO_INCREMENT PRIMARY KEY,
    Strasse    VARCHAR(255) NOT NULL,
    Hausnummer VARCHAR(50)  NOT NULL,
    ort_id     INT          NOT NULL,
    FOREIGN KEY (ort_id) REFERENCES Ort (ID)
);


-- Tabelle: Person
CREATE TABLE IF NOT EXISTS Person
(
    ID            INT AUTO_INCREMENT PRIMARY KEY,
    BenutzerID    INT          NOT NULL,
    Anrede        VARCHAR(10),
    Vorname       VARCHAR(100) NOT NULL,
    Nachname      VARCHAR(100) NOT NULL,
    Geburtstag    DATE         NOT NULL,
    Telefonnummer VARCHAR(20),
    ProfilBild    VARCHAR(255),
    Anschrift_id  INT          NOT NULL,
    FOREIGN KEY (BenutzerID) REFERENCES Benutzer (ID),
    FOREIGN KEY (Anschrift_id) REFERENCES Anschrift (ID)
);
