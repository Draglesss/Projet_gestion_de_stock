--@conn Projet PHP
--@block creation article:
CREATE TABLE article(
    ID_article INTEGER  NOT NULL,
    Nom VARCHAR(60) NOT NULL,
    Description VARCHAR(100) NOT NULL,
    Nombre_en_stock INTEGER NOT NULL,
    Image VARCHAR(100) NOT NULL,
    PRIMARY KEY (ID_article)
);
--@block desc article:
DESC article;
--@block alter :
ALTER TABLE article
   FOREIGN KEY (ID_categorie) REFERENCES categorie(ID_categorie) ON DELETE CASCADE;
   FOREIGN KEY (ID_fournisseur) REFERENCES fournisseur(ID_fournisseur) ON DELETE CASCADE;
--@block creation categorie
CREATE TABLE categorie(
    ID_categorie INTEGER NOT NULL,
    Nom VARCHAR(60) NOT NULL,
    Description VARCHAR(100) NOT NULL,
    PRIMARY KEY (ID_categorie)
);
--@block creation fournisseur
CREATE TABLE fournisseur(
    ID_fournisseur INTEGER NOT NULL,
    Nom VARCHAR(60) NOT NULL,
    Prenom VARCHAR(60) NOT NULL,
    CIN VARCHAR(10) NOT NULL,
    Adresse VARCHAR(50) NOT NULL,
    Telephone VARCHAR(50) NOT NULL,
    Email VARCHAR(50) NOT NULL,
    PRIMARY KEY (ID_fournisseur)
);
