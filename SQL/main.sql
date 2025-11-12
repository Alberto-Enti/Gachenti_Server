CREATE DATABASE IF NOT EXISTS gachenti;
USE gachenti;

CREATE TABLE IF NOT EXISTS user_types (
    id_user_type INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
    type VARCHAR(16) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS users (
    id_user INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
    name VARCHAR(24) NOT NULL,
    surname VARCHAR(24) NOT NULL,
    username VARCHAR(16) NOT NULL UNIQUE,
    email VARCHAR(32) NOT NULL UNIQUE,
    password CHAR(32) NOT NULL,
    birthdate DATE NOT NULL,
    funds DECIMAL(8,2) NOT NULL,
    registered DATETIME NOT NULL,
    id_user_type INT UNSIGNED NOT NULL,
    FOREIGN KEY (id_user_type) REFERENCES user_types(id_user_type)
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
    FOREIGN KEY (id_card_type) REFERENCES card_types(id_card_type),
    FOREIGN KEY (id_card_rarity) REFERENCES card_rarities(id_card_rarity)
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
    FOREIGN KEY (id_user) REFERENCES users(id_user),
    FOREIGN KEY (id_card) REFERENCES cards(id_card)
);
