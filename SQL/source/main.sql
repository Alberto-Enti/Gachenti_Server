CREATE DATABASE IF NOT EXISTS gachenti;
USE gachenti;

CREATE TABLE IF NOT EXISTS user_types (
    id_user_type INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
    type VARCHAR(16) NOT NULL UNIQUE
);

INSERT INTO user_types (type) VALUES("admin"), ("alumno"), ("profesor");

CREATE TABLE IF NOT EXISTS users (
    id_user INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
    name VARCHAR(24) NOT NULL,
    surname VARCHAR(24) NOT NULL,
    username VARCHAR(16) NOT NULL UNIQUE,
    email VARCHAR(32) NOT NULL UNIQUE,
    password CHAR(32) NOT NULL,
    birthdate DATE NOT NULL,
    funds DECIMAL(8,2) DEFAULT 0,
    registered DATETIME DEFAULT CURRENT_TIMESTAMP,
    id_user_type INT UNSIGNED NOT NULL,
    FOREIGN KEY (id_user_type) REFERENCES user_types(id_user_type)
);

INSERT INTO users (name, surname, username, email, password, birthdate, funds, registered, id_user_type)
VALUES (
    'Admin',
    'admin',
    'admin',
    'admin@gachenti.com',
    '21232f297a57a5a743894a0e4a801fc3',
    '2024-11-12',
    9999.99,
    '2024-11-12 13:25:42',
    1
);

CREATE TABLE IF NOT EXISTS card_types (
    id_card_type INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
    type VARCHAR(16) NOT NULL UNIQUE,
    abbr VARCHAR(4) NOT NULL UNIQUE,
    description TEXT DEFAULT "",
    color CHAR(6) DEFAULT "777777"
);

CREATE TABLE IF NOT EXISTS card_rarities (
    id_card_rarity INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
    rarity VARCHAR(16) NOT NULL UNIQUE,
    abbr VARCHAR(4) NOT NULL UNIQUE,
    description TEXT DEFAULT "",
    probability INT DEFAULT 10
);

CREATE TABLE IF NOT EXISTS card_templates (
    id_card_template INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
    card VARCHAR(32) NOT NULL,
    initial_price DECIMAL(6,2) NOT NULL,
    description TEXT DEFAULT "",
    image VARCHAR(32) DEFAULT "base.png",
    id_card_type INT UNSIGNED NOT NULL,
    id_card_rarity INT UNSIGNED NOT NULL,
    FOREIGN KEY (id_card_type) REFERENCES card_types(id_card_type) ON DELETE RESTRICT,
    FOREIGN KEY (id_card_rarity) REFERENCES card_rarities(id_card_rarity) ON DELETE RESTRICT 
);

CREATE TABLE IF NOT EXISTS cards (
    id_card INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
    price DECIMAL(6,2) NOT NULL,
    discount INT DEFAULT 0,
    on_sale BOOLEAN NOT NULL,
    state INT NOT NULL,
    creation DATETIME NOT NULL,
    id_card_template INT UNSIGNED NOT NULL,
    FOREIGN KEY (id_card_template) REFERENCES card_templates(id_card_template)
);

CREATE TABLE IF NOT EXISTS users_cards (
    id_user_card INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
    id_user INT UNSIGNED NOT NULL,
    id_card INT UNSIGNED NOT NULL,
    FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE CASCADE,
    FOREIGN KEY (id_card) REFERENCES cards(id_card) ON DELETE RESTRICT
);

/*
DOC;
Es importante utilizar on delete cascade pora evitar datos redundantes que puedan llegar a causar errores. 
En el caso de hacer una query de una relación entre usuarios y cartas, si un usuario es eliminado, si no se utilizara cascade, la query podría dar problemas y no reflejar la realidad.
Por otro lado, tampoco queremos que al hacer una query de relación, en el caso de que se haya eliminado una carta que se haya comprado, la relación se elimine, 
Si bien en nuestro caso tampoco es muy relevante saber las transacciones de otros usuarios, en bdd comerciales, las transacciones DEBEN existir aunque el producto ya no exista 
(Y con usuarios también pasa esto, pero esto ya es otro tema; NO Se tendría que eliminar el usuario sino desactivarlo y borrar datos personales como nombre, fechas, emails, etc... 
pero el registro de que ha habido un usuario tiene que existir legamente siempre que haya una transaccion)
*/
