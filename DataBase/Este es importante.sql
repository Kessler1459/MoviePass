use movie_pass;

create table if not exists tarjeta(
	id_tarjeta int auto_increment,
    doc_type varchar(10) not null,
    doc_number varchar(20) not null,
    transaction_amount float not null,
    payment_method_id varchar(30) not null,
    token varchar(50) not null,
    fecha timestamp default current_timestamp,
    constraint pk_compra primary key (id_tarjeta)
);
create table if not exists entrada(
	id_entrada int auto_increment,
    nro_entrada int not null,
    constraint pk_entrada primary key(id_entrada)
);

CREATE TABLE IF NOT EXISTS compra(
	id_compra INT auto_increment,
	id_user INT not null,
	id_tarjeta INT not null,
	fecha timestamp default current_timestamp,
	descuento float,
	cant_entradas int not null,
	total int,
	constraint pk_compra primary key (id_compra),
	constraint fk_id_user foreign key (id_user) references users (id_user),
	constraint fk_id_tarjeta foreign key (id_tarjeta) references tarjetas (tarjeta_number)
);

Create table if not exists entrada_x_compra(
	id_entradaxcompra int auto_increment,
    id_compra int not null,
    id_entrada int not null,
    constraint pk_entradaxcompra primary key(id_entradaxcompra),
    constraint fk_id_compra foreign key(id_compra)references compras (id_compra),
    constraint fk_id_entrada foreign key (id_entrada) references entradas (id_entradas)
);
create table if not exists entrada_x_funcion(
	id_entradaxfuncion int auto_increment,
    id_entrada int not null,
    id_funcion int not null,
);