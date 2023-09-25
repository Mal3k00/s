CREATE DATABASE IF NOT EXISTS esercizio_2;
CREATE TABLE tipi (
		id int primary key auto_increment,
        tipo_problema varchar(40)
		);
        
CREATE TABLE tecnici(
id int primary key auto_increment,
nome varchar(40),
telefono varchar(30),
email varchar(30),
passwovrd varchar(32)
);

CREATE TABLE clienti(
id int primary key auto_increment,
regione_sociale varchar(60),
indirizzo varchar(30),
telefono varchar(30),
email varchar(30),
password varchar(32),
referente varchar(40)
);

CREATE TABLE TICKET(
ID int primary key  auto_increment,
problema text,
data_apertura date,
data_chiusura date,
stato int(1) check(stato=0 or stato=1),
id_cliente int,
id_tipo int,
id_tecnico int,
foreign key(id_cliente) references clienti(id),
foreign key(id_tecnico) references tecnici(id)
);