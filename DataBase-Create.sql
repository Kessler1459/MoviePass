CREATE DATABASE movie_pass;

USE movie_pass;

CREATE TABLE cinemas(
	id_cinema INT NOT NULL,
	name_cinema VARCHAR(40),
	id_province SMALLINT,
	id_city INT,
	address VARCHAR(40),
	CONSTRAINT pk_cinemas PRIMARY KEY(id_cinema),
	CONSTRAINT pk_cinemas_province FOREIGN KEY(id_province) REFERENCES provincia(id),
	CONSTRAINT pk_cinemas_city FOREIGN KEY(id_city) REFERENCES ciudad(id));

CREATE TABLE movies(
	id_movie INT NOT NULL,
	title VARCHAR(50),
	LENGTH INT,
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
	id_gxm INT NOT NULL,
	id_genre INT NOT NULL,
	id_movie INT NOT NULL,
	CONSTRAINT PRIMARY KEY(id_gxm),
	CONSTRAINT fk_genre FOREIGN KEY(id_genre) REFERENCES genres(id_genre),
	CONSTRAINT fk_movie FOREIGN KEY(id_movie) REFERENCES movies(id_movie));

CREATE TABLE rooms(
	id_room INT NOT NULL,
	id_cinema INT NOT NULL,
	descript VARCHAR(80),
	capacity INT NOT NULL,
	ticket_price FLOAT NOT NULL,
	CONSTRAINT PRIMARY KEY (id_room),
	CONSTRAINT fk_id_cinema FOREIGN KEY (id_cinema) REFERENCES cinemas(id_cinema));
    
CREATE TABLE projections(
	id_proj INT NOT NULL,
	id_room INT NOT NULL,
	id_movie INT NOT NULL,
	proj_date DATE,
	proj_time TIME,
	CONSTRAINT PRIMARY KEY (id_proj),
	CONSTRAINT fk_id_room FOREIGN KEY (id_room) REFERENCES rooms(id_room),
	CONSTRAINT fk_id_movie FOREIGN KEY (id_movie) REFERENCES movies(id_movie));
