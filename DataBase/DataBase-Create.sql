CREATE DATABASE movie_pass;

USE movie_pass;

CREATE TABLE `provincia` (
	`id` SMALLINT(2) NOT NULL,
	`provincia_nombre` VARCHAR(50) NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

CREATE TABLE `ciudad` (
	`id` INT(4) NOT NULL,
	`ciudad_nombre` VARCHAR(60) NOT NULL,
	`cp` INT(4) NOT NULL,
	`provincia_id` SMALLINT(2) NOT NULL,
	PRIMARY KEY (`id`), KEY `cp` (`cp`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

CREATE TABLE movies(
	id_movie INT NOT NULL,
	title VARCHAR(50),
	length INT,
	synopsis TEXT,
	poster_url VARCHAR(50),
	video_url VARCHAR(40),
	release_date DATE,
	CONSTRAINT PRIMARY KEY(id_movie));

CREATE TABLE genres(
	id_genre INT NOT NULL,
	genre_name VARCHAR(30),
	CONSTRAINT PRIMARY KEY (id_genre));

CREATE TABLE genres_x_movies(
	id_gxm INT NOT NULL AUTO_INCREMENT,
	id_genre INT NOT NULL,
	id_movie INT NOT NULL,
	CONSTRAINT PRIMARY KEY(id_gxm),
	CONSTRAINT fk_genre FOREIGN KEY(id_genre) REFERENCES genres(id_genre),    
	CONSTRAINT fk_movie FOREIGN KEY(id_movie) REFERENCES movies(id_movie));

CREATE TABLE cinemas(
	id_cinema INT NOT NULL,
	name_cinema VARCHAR(40),
	id_province SMALLINT,
	id_city INT,
	id_user INT,
	address VARCHAR(40),
	CONSTRAINT pk_cinemas PRIMARY KEY(id_cinema),
	CONSTRAINT pk_cinemas_province FOREIGN KEY(id_province) REFERENCES provincia(id),
	CONSTRAINT pk_cinemas_city FOREIGN KEY(id_city) REFERENCES ciudad(id))CONSTRAINT pk_cinemas_city FOREIGN KEY(id_city) REFERENCES ciudad(id),
	CONSTRAINT fk_id_user foreign key(id_user) references users(id_user) on delete cascade on update cascade);

CREATE TABLE rooms(
	id_room INT NOT NULL,
	id_cinema INT NOT NULL,
	descript VARCHAR(80),
	capacity INT NOT NULL,
	ticket_price FLOAT NOT NULL,
	CONSTRAINT PRIMARY KEY (id_room),
	CONSTRAINT fk_id_cinema FOREIGN KEY (id_cinema) REFERENCES cinemas(id_cinema)ON DELETE CASCADE ON UPDATE CASCADE);

CREATE TABLE projections(
	id_proj INT NOT NULL,
	id_room INT NOT NULL,
	id_movie INT NOT NULL,
	proj_date DATE,
	proj_time TIME,
	CONSTRAINT PRIMARY KEY (id_proj),
	CONSTRAINT fk_id_room FOREIGN KEY (id_room) REFERENCES rooms(id_room) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT fk_id_movie FOREIGN KEY (id_movie) REFERENCES movies(id_movie));
    
CREATE TABLE users(
	id_user INT NOT NULL,
	email VARCHAR(50) UNIQUE,
	pass VARCHAR(12),
	first_name VARCHAR(20),
	last_name VARCHAR(20),
	dni INT NOT NULL,
	user_type INT NOT NULL,
	role_description VARCHAR(50),
	CONSTRAINT PRIMARY KEY (id_user));

CREATE TABLE IF NOT EXISTS tarjeta(
	id_tarjeta INT AUTO_INCREMENT,
	doc_type VARCHAR(10) NOT NULL,
	doc_number VARCHAR(20) NOT NULL,
	transaction_amount FLOAT NOT NULL,
	payment_method_id VARCHAR(30) NOT NULL,
	token VARCHAR(50) NOT NULL,
	fecha TIMESTAMP DEFAULT current_timestamp,
	CONSTRAINT pk_compra PRIMARY KEY (id_tarjeta));

CREATE TABLE IF NOT EXISTS entrada(
	id_entrada INT AUTO_INCREMENT,
	nro_entrada INT NOT NULL,
	CONSTRAINT pk_entrada PRIMARY KEY(id_entrada));

CREATE TABLE IF NOT EXISTS compra(
	id_compra INT AUTO_INCREMENT,
	id_user INT NOT NULL,
	id_tarjeta INT NOT NULL,
	fecha timestamp DEFAULT current_timestamp,
	descuento FLOAT,
	cant_entradas INT NOT NULL,
	total INT,
	CONSTRAINT pk_compra PRIMARY KEY (id_compra),
	CONSTRAINT fk_id_userCompra FOREIGN KEY (id_user) REFERENCES users (id_user),
	CONSTRAINT fk_id_tarjeta FOREIGN KEY (id_tarjeta) REFERENCES tarjeta (id_tarjeta));

CREATE TABLE IF NOT EXISTS entrada_x_compra(
	id_entradaxcompra INT AUTO_INCREMENT,
	id_compra INT NOT NULL,
	id_entrada INT NOT NULL,
	CONSTRAINT pk_entradaxcompra PRIMARY KEY(id_entradaxcompra),
	CONSTRAINT fk_id_compra FOREIGN KEY (id_compra) REFERENCES compra (id_compra),
	CONSTRAINT fk_id_entradaCompra FOREIGN KEY (id_entrada) REFERENCES entrada (id_entrada));

CREATE TABLE IF NOT EXISTS entrada_x_funcion(
	id_entradaxfuncion INT AUTO_INCREMENT,
	id_entrada INT NOT NULL,
	id_funcion INT NOT NULL,
	CONSTRAINT pk_entradaxfuncion PRIMARY KEY (id_entradaxfuncion),
	CONSTRAINT fk_id_entrada FOREIGN KEY (id_entrada) REFERENCES entrada (id_entrada),
	CONSTRAINT fk_id_funcion FOREIGN KEY (id_funcion) REFERENCES projections (id_proj));

INSERT INTO genres(id_genre,genre_name) VALUES (28,"Action"),(12,"Adventure"),(16,"Animation"),(35,"Comedy"),(80,"Crime"),(99,"Documentary"),(18,"Drama"),(10751,"Family"),
						(14,"Fantasy"),(36,"History"),(27,"Horror"),(10402,"Music"),(9648,"Mystery"),(10749,"Romance"),(878,"Science Fiction"),
						(10770,"TV Movie"),(53,"Thriller"),(10752,"War"),(37,"Western");

INSERT INTO users (id_user,email,pass,first_name,last_name,dni,user_type,role_description) VALUES (1,"nahuelflores@gmail.com","1999","Nahuel","Flores","123456",3,"Admin");
		
