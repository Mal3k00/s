CREATE DATABASE COWORKING_PROJECKT;

-- Tabella Utenti
CREATE TABLE `utenti` (
  `id_utente` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `cognome` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  PRIMARY KEY (`id_utente`)
);

-- Tabella Aree Coworking
CREATE TABLE `aree_coworking` (
  `id_area_coworking` int NOT NULL AUTO_INCREMENT, 
  `id_utente` int NOT NULL,
  `nome_azienda` varchar(100) NOT NULL,
  `indirizzo` varchar(100) NOT NULL,
  `nome_area_coworking` varchar(100) NOT NULL,
  `descrizione` text,
  PRIMARY KEY (`id_area_coworking`),
  FOREIGN KEY (`id_utente`) REFERENCES `utenti`(`id_utente`)
);

-- Tabella Prenotazioni
CREATE TABLE `prenotazioni` (
  `id_prenotazione` int NOT NULL AUTO_INCREMENT,
  `id_area_coworking` int NOT NULL,
  `data` date NOT NULL,
  PRIMARY KEY (`id_prenotazione`),
  FOREIGN KEY (`id_area_coworking`) REFERENCES `aree_coworking`(`id_area_coworking`)
);

-- Tabella Prenotazioni
CREATE TABLE `prenotazioni` (
  `id_prenotazione` int NOT NULL AUTO_INCREMENT,
  `id_area_coworking` int NOT NULL,
  `id_utente` int NOT NULL,  -- Aggiungi il campo id_utente
  `data` date NOT NULL,
  PRIMARY KEY (`id_prenotazione`),
  FOREIGN KEY (`id_area_coworking`) REFERENCES `aree_coworking`(`id_area_coworking`),
  FOREIGN KEY (`id_utente`) REFERENCES `utenti`(`id_utente`)  -- Aggiungi la chiave esterna per id_utente
);




