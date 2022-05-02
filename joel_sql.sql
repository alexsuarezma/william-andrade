create table clientes(
	id int(255) NOT NULL AUTO_INCREMENT,
    cedula varchar(13),
	nombres varchar(100),
	apellidos varchar(100),
	email varchar(100),
	direccion varchar(100),
	telefono varchar(10),
	celular varchar(10),
    tipo_cliente varchar(20),
	created_at datetime DEFAULT NULL,
	updated_at datetime DEFAULT NULL,
	PRIMARY KEY (`id`)
);
#alter table empleados add column salario decimal(10,2);
#alter table empleados add column actividad varchar(100);
create table empleados(
	id int(255) NOT NULL AUTO_INCREMENT,
    cedula varchar(13),
	nombres varchar(100),
	apellidos varchar(100),
    salario decimal(10,2),
    actividad varchar(100),
	email varchar(100),
	direccion varchar(100),
    fecha_ingreso datetime,
	created_at datetime DEFAULT NULL,
	updated_at datetime DEFAULT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE tipos_gastos (
  id int(255) NOT NULL AUTO_INCREMENT,
  descripcion varchar(150) DEFAULT NULL,
  created_at datetime DEFAULT NULL,
  updated_at datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
#drop table sector_lotes;

CREATE TABLE sector_lotes (
  id int(255) NOT NULL AUTO_INCREMENT,
  descripcion varchar(150) DEFAULT NULL,
  data varchar(2), #	'SC' SECTOR; 'LT' LOTE
  codigo_padre int(255), # SI ES DATA='LT' EL CODIGO_PADRE ES AL SECTOR QUE PERTENECE 
  hectareas_area decimal(10,2),
  dualidad_mes varchar(7),
  vigencia tinyint(1), # 1 = VIGENTE; 0detalles_gastos = NO VIGENTE
  created_at datetime DEFAULT NULL,
  updated_at datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
#alter table productos add column tipo_producto varchar(1);

create table productos(
	id int(255) NOT NULL AUTO_INCREMENT,
    descripcion varchar(100),
	tipo_inventario varchar(1), # SI ES tipo_inventario='1' ES PRODUCTO; SI tipo_inventario='2' ES SERVICIO
    tipo_producto varchar(1), # SI ES tipo_producto='1' ES GASTO; SI tipo_producto='2' ES VENTA
    stock decimal(10,2) DEFAULT 0,
	costo decimal(10,2) DEFAULT 0,
    precio_unitario decimal(10,2) DEFAULT 0,
	unidad_medida varchar(10),
    factor decimal(10,2),
    tipo_gasto_id int(255),
	created_at datetime DEFAULT NULL,
	updated_at datetime DEFAULT NULL,
	PRIMARY KEY (`id`),
    KEY fk_productos_tipos_gastos (tipo_gasto_id),
	CONSTRAINT fk_productos_tipos_gastos FOREIGN KEY (tipo_gasto_id) REFERENCES tipos_gastos (id)
);
#drop table detalles_gastos;
#drop table gastos;
create table gastos(
	id int(255) NOT NULL AUTO_INCREMENT,
    comentario varchar(100),
    fecha_documento datetime,
    sector_lote_id int(255),
	total_gasto decimal(10,2),
    user_registro_id bigint(20) unsigned NOT NULL,
    anulado tinyint(1) DEFAULT 0, # 1 = ANULADO; 0 = NO ANULADO
    comentario_anulacion varchar(100),
    user_anula_id bigint(20) unsigned null,
	created_at datetime DEFAULT NULL,
	updated_at datetime DEFAULT NULL,
	PRIMARY KEY (`id`),
    KEY fk_gastos_sector_lotes (sector_lote_id),
	CONSTRAINT fk_gastos_sector_lotes FOREIGN KEY (sector_lote_id) REFERENCES sector_lotes (id),
    CONSTRAINT fk_gastos_users FOREIGN KEY (user_registro_id) REFERENCES users (id)
    #CONSTRAINT fk_gastos_users_anula FOREIGN KEY (user_anula_id) REFERENCES users (id)
);

create table detalles_gastos(
	secuencia int(255),
    gasto_id int(255),
    sector_lote_id int(255),
	producto_id int(255),
    cantidad decimal(10,2),
    hectareas_aplicado decimal(10,2),
	costo decimal(10,2),
	unidad_medida varchar(10),
    factor decimal(10,2),
    total decimal(10,2),
	created_at datetime DEFAULT NULL,
	updated_at datetime DEFAULT NULL,
    KEY fk_detalles_gastos_sector_lotes (sector_lote_id),
	CONSTRAINT fk_detalles_gastos_sector_lotes FOREIGN KEY (sector_lote_id) REFERENCES sector_lotes (id),
    KEY fk_detalles_gastos_productos (producto_id),
	CONSTRAINT fk_detalles_gastos_productos FOREIGN KEY (producto_id) REFERENCES productos (id),
    CONSTRAINT fk_detalles_gastos_gastos FOREIGN KEY (gasto_id) REFERENCES gastos (id)
);
#drop table detalle_produccion;
#drop table produccion;
create table produccion(
	id int(255) NOT NULL AUTO_INCREMENT,
    comentario varchar(100),
    fecha_documento datetime,
    sector_lote_id int(255),
	total_produccion decimal(10,2),
    user_registro_id bigint(20) unsigned NOT NULL,
    anulado tinyint(1) DEFAULT 0, # 1 = ANULADO; 0 = NO ANULADO
    comentario_anulacion varchar(100),
    user_anula_id bigint(20) unsigned null,
	created_at datetime DEFAULT NULL,
	updated_at datetime DEFAULT NULL,
	PRIMARY KEY (`id`),
	CONSTRAINT fk_produccion_sector_lotes FOREIGN KEY (sector_lote_id) REFERENCES sector_lotes (id),
    CONSTRAINT fk_produccion_users FOREIGN KEY (user_registro_id) REFERENCES users (id),
    CONSTRAINT fk_produccion_users_anula FOREIGN KEY (user_anula_id) REFERENCES users (id)
);

create table detalle_produccion(
	secuencia int(255),
    produccion_id int(255),
	producto_id int(255),
    cantidad decimal(10,2),
    unidad_medida varchar(10),
    factor decimal(10,2),
    cajas decimal(10,2),
    total decimal(10,2),
	created_at datetime DEFAULT NULL,
	updated_at datetime DEFAULT NULL,    
	CONSTRAINT fk_detalles_produccion_productos FOREIGN KEY (producto_id) REFERENCES productos (id),
    CONSTRAINT fk_detalles_produccion_produccion FOREIGN KEY (produccion_id) REFERENCES produccion (id)
);
#drop table detalle_ventas;
#drop table ventas;
create table ventas(
	id int(255) NOT NULL AUTO_INCREMENT,
    cliente_id int(255),
    tipo_venta varchar(15),
    comentario varchar(100),
    fecha_documento datetime,
	total_venta decimal(10,2),
    user_registro_id bigint(20) unsigned NOT NULL,
    anulado tinyint(1) DEFAULT 0, # 1 = ANULADO; 0 = NO ANULADO
    comentario_anulacion varchar(100),
    user_anula_id bigint(20) unsigned null,
	created_at datetime DEFAULT NULL,
	updated_at datetime DEFAULT NULL,
	PRIMARY KEY (`id`),
    CONSTRAINT fk_ventas_users FOREIGN KEY (user_registro_id) REFERENCES users (id),
    CONSTRAINT fk_ventas_users_anula FOREIGN KEY (user_anula_id) REFERENCES users (id),
    CONSTRAINT fk_ventas_cliente FOREIGN KEY (cliente_id) REFERENCES clientes (id)
);

create table detalle_ventas(
	secuencia int(255),
    venta_id int(255),
	producto_id int(255),
    cantidad decimal(10,2),
    cajas decimal(10,2),
	precio_unitario decimal(10,2),
	unidad_medida varchar(10),
    factor decimal(10,2),
    total decimal(10,2),
	created_at datetime DEFAULT NULL,
	updated_at datetime DEFAULT NULL,    
	CONSTRAINT fk_detalle_ventas_productos FOREIGN KEY (producto_id) REFERENCES productos (id),
    CONSTRAINT fk_detalle_ventas_gastos FOREIGN KEY (venta_id) REFERENCES ventas (id)
);
drop table anios
create table anios(anio decimal);
insert into anios values(2015);
insert into anios values(2016);
insert into anios values(2017);
insert into anios values(2018);
insert into anios values(2019);
insert into anios values(2020);
insert into anios values(2021);
insert into anios values(2022);
insert into anios values(2023);
insert into anios values(2024);
insert into anios values(2025);

alter view vw_gastos_ventas as
select sum(gastos) gastos, sum(ventas) ventas, sum(produccion) produccion, month, fecha_documento, anio from(   
    select ifnull(sum(total_gasto),0) as gastos, 0 ventas, 0 produccion,1 month, year(fecha_documento) anio,fecha_documento from gastos where month(fecha_documento) = 1 and anulado = 0
    group by fecha_documento
    union all 
    select 0 gastos,ifnull(sum(total_venta),0) as ventas, 0 produccion,1 month, year(fecha_documento) anio,fecha_documento from ventas where month(fecha_documento) = 1 and anulado = 0
    group by fecha_documento
    union all
    select 0 gastos, 0 ventas,ifnull(sum(total_produccion),0) as produccion,1 month, year(fecha_documento) anio,fecha_documento from produccion where month(fecha_documento) = 1 and anulado = 0
        group by fecha_documento
    union all
    select 0,0,0,1, anio, curtime() from anios
) tmp  group by anio #ENERO
union all
select sum(gastos) gastos, sum(ventas) ventas, sum(produccion) produccion, month, fecha_documento, anio from(
    select ifnull(sum(total_gasto),0) as gastos, 0 ventas, 0 produccion,2 month, year(fecha_documento) anio,fecha_documento from gastos where month(fecha_documento) = 2 and anulado = 0
    group by fecha_documento
    union all 
    select 0 gastos,ifnull(sum(total_venta),0) as ventas, 0 produccion,2 month, year(fecha_documento) anio,fecha_documento from ventas where month(fecha_documento) = 2 and anulado = 0
    group by fecha_documento
    union all
    select 0 gastos, 0 ventas,ifnull(sum(total_produccion),0) as produccion,2 month, year(fecha_documento) anio,fecha_documento from produccion where month(fecha_documento) = 2 and anulado = 0
        group by fecha_documento
    union all
    select 0,0,0,2, anio, curtime() from anios
) tmp group by anio #FEBRERO
union all
select sum(gastos) gastos, sum(ventas) ventas, sum(produccion) produccion, month, fecha_documento, anio from(
    select ifnull(sum(total_gasto),0) as gastos, 0 ventas, 0 produccion,3 month, year(fecha_documento) anio,fecha_documento from gastos where month(fecha_documento) = 3 and anulado = 0
    group by fecha_documento
    union all 
    select 0 gastos,ifnull(sum(total_venta),0) as ventas, 0 produccion,3 month, year(fecha_documento) anio,fecha_documento from ventas where month(fecha_documento) = 3 and anulado = 0
    group by fecha_documento
    union all
    select 0 gastos, 0 ventas,ifnull(sum(total_produccion),0) as produccion,3 month, year(fecha_documento) anio,fecha_documento from produccion where month(fecha_documento) = 3 and anulado = 0
        group by fecha_documento
    union all
    select 0,0,0,3, anio, curtime() from anios
) tmp group by anio #MARZO
union all
select sum(gastos) gastos, sum(ventas) ventas, sum(produccion) produccion, month, fecha_documento, anio from(
    select ifnull(sum(total_gasto),0) as gastos, 0 ventas, 0 produccion,4 month, year(fecha_documento) anio,fecha_documento from gastos where month(fecha_documento) = 4 and anulado = 0
    group by fecha_documento
    union all 
    select 0 gastos,ifnull(sum(total_venta),0) as ventas, 0 produccion,4 month, year(fecha_documento) anio,fecha_documento from ventas where month(fecha_documento) = 4 and anulado = 0
    group by fecha_documento
    union all
    select 0 gastos, 0 ventas,ifnull(sum(total_produccion),0) as produccion,4 month, year(fecha_documento) anio,fecha_documento from produccion where month(fecha_documento) = 4 and anulado = 0
        group by fecha_documento
    union all
    select 0,0,0,4, anio, curtime() from anios
) tmp group by anio #ABRIL
union all
select sum(gastos) gastos, sum(ventas) ventas, sum(produccion) produccion, month, fecha_documento, anio from(
    select ifnull(sum(total_gasto),0) as gastos, 0 ventas, 0 produccion,5 month, year(fecha_documento) anio,fecha_documento from gastos where month(fecha_documento) = 5 and anulado = 0
    group by fecha_documento
    union all 
    select 0 gastos,ifnull(sum(total_venta),0) as ventas, 0 produccion,5 month, year(fecha_documento) anio,fecha_documento from ventas where month(fecha_documento) = 5 and anulado = 0
    group by fecha_documento
    union all
    select 0 gastos, 0 ventas,ifnull(sum(total_produccion),0) as produccion,5 month, year(fecha_documento) anio,fecha_documento from produccion where month(fecha_documento) = 5 and anulado = 0
        group by fecha_documento
    union all
    select 0,0,0,5, anio, curtime() from anios
) tmp group by anio #MAYO
union all
select sum(gastos) gastos, sum(ventas) ventas, sum(produccion) produccion, month, fecha_documento, anio from(
    select ifnull(sum(total_gasto),0) as gastos, 0 ventas, 0 produccion,6 month, year(fecha_documento) anio,fecha_documento from gastos where month(fecha_documento) = 6 and anulado = 0
    group by fecha_documento
    union all 
    select 0 gastos,ifnull(sum(total_venta),0) as ventas, 0 produccion,6 month, year(fecha_documento) anio,fecha_documento from ventas where month(fecha_documento) = 6 and anulado = 0
    group by fecha_documento
    union all
    select 0 gastos, 0 ventas,ifnull(sum(total_produccion),0) as produccion,6 month, year(fecha_documento) anio,fecha_documento from produccion where month(fecha_documento) = 6 and anulado = 0
        group by fecha_documento
    union all
    select 0,0,0,6, anio, curtime() from anios
) tmp group by anio #JUNIO
union all
select sum(gastos) gastos, sum(ventas) ventas, sum(produccion) produccion, month, fecha_documento, anio from(
    select ifnull(sum(total_gasto),0) as gastos, 0 ventas, 0 produccion,7 month, year(fecha_documento) anio,fecha_documento from gastos where month(fecha_documento) = 7 and anulado = 0
    group by fecha_documento
    union all 
    select 0 gastos,ifnull(sum(total_venta),0) as ventas, 0 produccion,7 month, year(fecha_documento) anio,fecha_documento from ventas where month(fecha_documento) = 7 and anulado = 0
    group by fecha_documento
    union all
    select 0 gastos, 0 ventas,ifnull(sum(total_produccion),0) as produccion,7 month, year(fecha_documento) anio,fecha_documento from produccion where month(fecha_documento) = 7 and anulado = 0
        group by fecha_documento
    union all
    select 0,0,0,7, anio, curtime() from anios
) tmp group by anio #JULIO
union all
select sum(gastos) gastos, sum(ventas) ventas, sum(produccion) produccion, month, fecha_documento, anio from(
    select ifnull(sum(total_gasto),0) as gastos, 0 ventas, 0 produccion,8 month, year(fecha_documento) anio,fecha_documento from gastos where month(fecha_documento) = 8 and anulado = 0
    group by fecha_documento
    union all 
    select 0 gastos,ifnull(sum(total_venta),0) as ventas, 0 produccion,8 month, year(fecha_documento) anio,fecha_documento from ventas where month(fecha_documento) = 8 and anulado = 0
    group by fecha_documento
    union all
    select 0 gastos, 0 ventas,ifnull(sum(total_produccion),0) as produccion,8 month, year(fecha_documento) anio,fecha_documento from produccion where month(fecha_documento) = 8 and anulado = 0
        group by fecha_documento
    union all
    select 0,0,0,8, anio, curtime() from anios
) tmp group by anio #AGOSTO
union all
select sum(gastos) gastos, sum(ventas) ventas, sum(produccion) produccion, month, fecha_documento, anio from(
    select ifnull(sum(total_gasto),0) as gastos, 0 ventas, 0 produccion,9 month, year(fecha_documento) anio,fecha_documento from gastos where month(fecha_documento) = 9 and anulado = 0
    group by fecha_documento
    union all 
    select 0 gastos,ifnull(sum(total_venta),0) as ventas, 0 produccion,9 month, year(fecha_documento) anio,fecha_documento from ventas where month(fecha_documento) = 9 and anulado = 0
    group by fecha_documento
    union all
    select 0 gastos, 0 ventas,ifnull(sum(total_produccion),0) as produccion,9 month, year(fecha_documento) anio,fecha_documento from produccion where month(fecha_documento) = 9 and anulado = 0
        group by fecha_documento
    union all
    select 0,0,0,9, anio, curtime() from anios
) tmp group by anio #SEPTIEMBRE
union all
select sum(gastos) gastos, sum(ventas) ventas, sum(produccion) produccion, month, fecha_documento, anio from(
    select ifnull(sum(total_gasto),0) as gastos, 0 ventas, 0 produccion,10 month, year(fecha_documento) anio,fecha_documento from gastos where month(fecha_documento) = 10 and anulado = 0
    group by fecha_documento
    union all 
    select 0 gastos,ifnull(sum(total_venta),0) as ventas, 0 produccion,10 month, year(fecha_documento) anio,fecha_documento from ventas where month(fecha_documento) = 10 and anulado = 0
    group by fecha_documento
    union all
    select 0 gastos, 0 ventas,ifnull(sum(total_produccion),0) as produccion,10 month, year(fecha_documento) anio,fecha_documento from produccion where month(fecha_documento) = 10 and anulado = 0
        group by fecha_documento
    union all
    select 0,0,0,10, anio, curtime() from anios
) tmp group by anio #OCTUBRE
union all
select sum(gastos) gastos, sum(ventas) ventas, sum(produccion) produccion, month, fecha_documento, anio from(
    select ifnull(sum(total_gasto),0) as gastos, 0 ventas, 0 produccion,11 month, year(fecha_documento) anio,fecha_documento from gastos where month(fecha_documento) = 11 and anulado = 0
    group by fecha_documento
    union all 
    select 0 gastos,ifnull(sum(total_venta),0) as ventas, 0 produccion,11 month, year(fecha_documento) anio,fecha_documento from ventas where month(fecha_documento) = 11 and anulado = 0
    group by fecha_documento
    union all
    select 0 gastos, 0 ventas,ifnull(sum(total_produccion),0) as produccion,11 month, year(fecha_documento) anio,fecha_documento from produccion where month(fecha_documento) = 11 and anulado = 0
        group by fecha_documento
    union all
    select 0,0,0,11, anio, curtime() from anios
) tmp group by anio #NOVIEMBRE
union all
select sum(gastos) gastos, sum(ventas) ventas, sum(produccion) produccion, month, fecha_documento, anio from(
    select ifnull(sum(total_gasto),0) as gastos, 0 ventas, 0 produccion,12 month, year(fecha_documento) anio,fecha_documento from gastos where month(fecha_documento) = 12 and anulado = 0
    group by fecha_documento
    union all 
    select 0 gastos,ifnull(sum(total_venta),0) as ventas, 0 produccion,12 month, year(fecha_documento) anio,fecha_documento from ventas where month(fecha_documento) = 12 and anulado = 0
    group by fecha_documento
    union all
    select 0 gastos, 0 ventas,ifnull(sum(total_produccion),0) as produccion,12 month, year(fecha_documento) anio,fecha_documento from produccion where month(fecha_documento) = 12 and anulado = 0
        group by fecha_documento
    union all
    select 0,0,0,12, anio, curtime() from anios
) tmp group by anio #DICIEMBRE

alter view vw_gastos_produccion as
select exist,sum(gastos) gastos, sum(produccion) produccion, sum(p_local) p_local, sum(p_exportacion) p_exportacion, month, anio, nombre_lote,dualidad_mes from(
	select 0 exist,ifnull(sum(total_gasto),0) as gastos, 0 produccion,0 p_local,0 p_exportacion,1 month, year(fecha_documento) anio,
		(select dualidad_mes from sector_lotes where id = sector_lote_id) dualidad_mes,
        (select descripcion from sector_lotes where id = sector_lote_id) nombre_lote  from gastos where month(fecha_documento) = 1 and anulado = 0
        and (select vigencia from sector_lotes where id = sector_lote_id) = 1
		group by sector_lote_id
	union all 
	select 0 exist,0 gastos,ifnull(sum(total_produccion),0) as produccion
        ,If(detalle_produccion.producto_id = 7,ifnull(sum(cajas),0), 0) p_local
        ,If(detalle_produccion.producto_id = 8,ifnull(sum(cajas),0), 0) p_exportacion
        ,1 month, year(fecha_documento) anio,
		(select dualidad_mes from sector_lotes where id = sector_lote_id) dualidad_mes,
        (select descripcion from sector_lotes where id = sector_lote_id) nombre_lote from produccion 
        left outer join detalle_produccion on detalle_produccion.produccion_id = produccion.id
        where month(fecha_documento) = 1 and anulado = 0
        and (select vigencia from sector_lotes where id = sector_lote_id) = 1
	group by sector_lote_id
    union all
		select count(id) exist,0 gastos, 0.00 produccion,0,0, 1 month, year(curtime()) anio, dualidad_mes, descripcion from sector_lotes where dualidad_mes = 'ene_feb'
        and vigencia = 1
		group by descripcion
) tmp #ENERO 
group by nombre_lote
union all
select exist,sum(gastos) gastos, sum(produccion) produccion, sum(p_local) p_local, sum(p_exportacion) p_exportacion, month, anio, nombre_lote,dualidad_mes from(
	select 0 exist,ifnull(sum(total_gasto),0) as gastos, 0 produccion,0 p_local,0 p_exportacion,2 month, year(fecha_documento) anio,
		(select dualidad_mes from sector_lotes where id = sector_lote_id) dualidad_mes,
        (select descripcion from sector_lotes where id = sector_lote_id) nombre_lote  from gastos where month(fecha_documento) = 2 and anulado = 0
        and (select vigencia from sector_lotes where id = sector_lote_id) = 1
		group by sector_lote_id
	union all 
	select 0 exist,0 gastos,ifnull(sum(total_produccion),0) as produccion
        ,If(detalle_produccion.producto_id = 7,ifnull(sum(cajas),0), 0) p_local
        ,If(detalle_produccion.producto_id = 8,ifnull(sum(cajas),0), 0) p_exportacion
        ,2 month, year(fecha_documento) anio,
		(select dualidad_mes from sector_lotes where id = sector_lote_id) dualidad_mes,
        (select descripcion from sector_lotes where id = sector_lote_id) nombre_lote from produccion 
        left outer join detalle_produccion on detalle_produccion.produccion_id = produccion.id
        where month(fecha_documento) = 2 and anulado = 0
        and (select vigencia from sector_lotes where id = sector_lote_id) = 1
	group by sector_lote_id
    union all
		select count(id) exist,0 gastos, 0.00 produccion,0,0, 2 month, year(curtime()) anio, dualidad_mes, descripcion from sector_lotes where dualidad_mes = 'ene_feb'
        and vigencia = 1
		group by descripcion
) tmp #FEBRERO
group by nombre_lote
union all
select exist,sum(gastos) gastos, sum(produccion) produccion, sum(p_local) p_local, sum(p_exportacion) p_exportacion, month, anio, nombre_lote,dualidad_mes from(
	select 0 exist,ifnull(sum(total_gasto),0) as gastos, 0 produccion,0 p_local,0 p_exportacion,3 month, year(fecha_documento) anio,
		(select dualidad_mes from sector_lotes where id = sector_lote_id) dualidad_mes,
        (select descripcion from sector_lotes where id = sector_lote_id) nombre_lote  from gastos where month(fecha_documento) = 3 and anulado = 0
        and (select vigencia from sector_lotes where id = sector_lote_id) = 1
		group by sector_lote_id
	union all 
	select 0 exist,0 gastos,ifnull(sum(total_produccion),0) as produccion
        ,If(detalle_produccion.producto_id = 7,ifnull(sum(cajas),0), 0) p_local
        ,If(detalle_produccion.producto_id = 8,ifnull(sum(cajas),0), 0) p_exportacion
        ,3 month, year(fecha_documento) anio,
		(select dualidad_mes from sector_lotes where id = sector_lote_id) dualidad_mes,
        (select descripcion from sector_lotes where id = sector_lote_id) nombre_lote from produccion 
        left outer join detalle_produccion on detalle_produccion.produccion_id = produccion.id
        where month(fecha_documento) = 3 and anulado = 0
        and (select vigencia from sector_lotes where id = sector_lote_id) = 1
	group by sector_lote_id
    union all
		select count(id) exist,0 gastos, 0.00 produccion,0,0, 3 month, year(curtime()) anio, dualidad_mes, descripcion from sector_lotes where dualidad_mes = 'mar_abr'
        and vigencia = 1
		group by descripcion
) tmp #MARZO
group by nombre_lote
union all
select exist,sum(gastos) gastos, sum(produccion) produccion, sum(p_local) p_local, sum(p_exportacion) p_exportacion, month, anio, nombre_lote,dualidad_mes from(
	select 0 exist,ifnull(sum(total_gasto),0) as gastos, 0 produccion,0 p_local,0 p_exportacion,4 month, year(fecha_documento) anio,
		(select dualidad_mes from sector_lotes where id = sector_lote_id) dualidad_mes,
        (select descripcion from sector_lotes where id = sector_lote_id) nombre_lote  from gastos where month(fecha_documento) = 4 and anulado = 0
        and (select vigencia from sector_lotes where id = sector_lote_id) = 1
		group by sector_lote_id
	union all 
	select 0 exist,0 gastos,ifnull(sum(total_produccion),0) as produccion
        ,If(detalle_produccion.producto_id = 7,ifnull(sum(cajas),0), 0) p_local
        ,If(detalle_produccion.producto_id = 8,ifnull(sum(cajas),0), 0) p_exportacion
        ,4 month, year(fecha_documento) anio,
		(select dualidad_mes from sector_lotes where id = sector_lote_id) dualidad_mes,
        (select descripcion from sector_lotes where id = sector_lote_id) nombre_lote from produccion 
        left outer join detalle_produccion on detalle_produccion.produccion_id = produccion.id
        where month(fecha_documento) = 4 and anulado = 0
        and (select vigencia from sector_lotes where id = sector_lote_id) = 1
	group by sector_lote_id
    union all
		select count(id) exist,0 gastos, 0.00 produccion,0,0, 4 month, year(curtime()) anio, dualidad_mes, descripcion from sector_lotes where dualidad_mes = 'mar_abr'
        and vigencia = 1
		group by descripcion
) tmp #ABRIL
group by nombre_lote
union all
select exist,sum(gastos) gastos, sum(produccion) produccion, sum(p_local) p_local, sum(p_exportacion) p_exportacion, month, anio, nombre_lote,dualidad_mes from(
	select 0 exist,ifnull(sum(total_gasto),0) as gastos, 0 produccion,0 p_local,0 p_exportacion,5 month, year(fecha_documento) anio,
		(select dualidad_mes from sector_lotes where id = sector_lote_id) dualidad_mes,
        (select descripcion from sector_lotes where id = sector_lote_id) nombre_lote  from gastos where month(fecha_documento) = 5 and anulado = 0
        and (select vigencia from sector_lotes where id = sector_lote_id) = 1
		group by sector_lote_id
	union all 
	select 0 exist,0 gastos,ifnull(sum(total_produccion),0) as produccion
        ,If(detalle_produccion.producto_id = 7,ifnull(sum(cajas),0), 0) p_local
        ,If(detalle_produccion.producto_id = 8,ifnull(sum(cajas),0), 0) p_exportacion
        ,5 month, year(fecha_documento) anio,
		(select dualidad_mes from sector_lotes where id = sector_lote_id) dualidad_mes,
        (select descripcion from sector_lotes where id = sector_lote_id) nombre_lote from produccion 
        left outer join detalle_produccion on detalle_produccion.produccion_id = produccion.id
        where month(fecha_documento) = 5 and anulado = 0
        and (select vigencia from sector_lotes where id = sector_lote_id) = 1
	group by sector_lote_id
    union all
		select count(id) exist,0 gastos, 0.00 produccion,0,0, 5 month, year(curtime()) anio, dualidad_mes, descripcion from sector_lotes where dualidad_mes = 'may_jun'
        and vigencia = 1
		group by descripcion
) tmp #MAYO
group by nombre_lote
union all
select exist,sum(gastos) gastos, sum(produccion) produccion, sum(p_local) p_local, sum(p_exportacion) p_exportacion, month, anio, nombre_lote,dualidad_mes from(
	select 0 exist,ifnull(sum(total_gasto),0) as gastos, 0 produccion,0 p_local,0 p_exportacion,6 month, year(fecha_documento) anio,
		(select dualidad_mes from sector_lotes where id = sector_lote_id) dualidad_mes,
        (select descripcion from sector_lotes where id = sector_lote_id) nombre_lote  from gastos where month(fecha_documento) = 6 and anulado = 0
        and (select vigencia from sector_lotes where id = sector_lote_id) = 1
		group by sector_lote_id
	union all 
	select 0 exist,0 gastos,ifnull(sum(total_produccion),0) as produccion
        ,If(detalle_produccion.producto_id = 7,ifnull(sum(cajas),0), 0) p_local
        ,If(detalle_produccion.producto_id = 8,ifnull(sum(cajas),0), 0) p_exportacion
        ,6 month, year(fecha_documento) anio,
		(select dualidad_mes from sector_lotes where id = sector_lote_id) dualidad_mes,
        (select descripcion from sector_lotes where id = sector_lote_id) nombre_lote from produccion 
        left outer join detalle_produccion on detalle_produccion.produccion_id = produccion.id
        where month(fecha_documento) = 6 and anulado = 0
        and (select vigencia from sector_lotes where id = sector_lote_id) = 1
	group by sector_lote_id
    union all
		select count(id) exist,0 gastos, 0.00 produccion,0,0, 6 month, year(curtime()) anio, dualidad_mes, descripcion from sector_lotes where dualidad_mes = 'may_jun'
        and vigencia = 1
		group by descripcion
) tmp #JUNIO
group by nombre_lote
union all
select exist,sum(gastos) gastos, sum(produccion) produccion, sum(p_local) p_local, sum(p_exportacion) p_exportacion, month, anio, nombre_lote,dualidad_mes from(
	select 0 exist,ifnull(sum(total_gasto),0) as gastos, 0 produccion,0 p_local,0 p_exportacion,7 month, year(fecha_documento) anio,
		(select dualidad_mes from sector_lotes where id = sector_lote_id) dualidad_mes,
        (select descripcion from sector_lotes where id = sector_lote_id) nombre_lote  from gastos where month(fecha_documento) = 7 and anulado = 0
        and (select vigencia from sector_lotes where id = sector_lote_id) = 1
		group by sector_lote_id
	union all 
	select 0 exist,0 gastos,ifnull(sum(total_produccion),0) as produccion
        ,If(detalle_produccion.producto_id = 7,ifnull(sum(cajas),0), 0) p_local
        ,If(detalle_produccion.producto_id = 8,ifnull(sum(cajas),0), 0) p_exportacion
        ,7 month, year(fecha_documento) anio,
		(select dualidad_mes from sector_lotes where id = sector_lote_id) dualidad_mes,
        (select descripcion from sector_lotes where id = sector_lote_id) nombre_lote from produccion 
        left outer join detalle_produccion on detalle_produccion.produccion_id = produccion.id
        where month(fecha_documento) = 7 and anulado = 0
        and (select vigencia from sector_lotes where id = sector_lote_id) = 1
	group by sector_lote_id
    union all
		select count(id) exist,0 gastos, 0.00 produccion,0,0, 7 month, year(curtime()) anio, dualidad_mes, descripcion from sector_lotes where dualidad_mes = 'jul_ago'
        and vigencia = 1
		group by descripcion
) tmp #JULIO
group by nombre_lote
union all
select exist,sum(gastos) gastos, sum(produccion) produccion, sum(p_local) p_local, sum(p_exportacion) p_exportacion, month, anio, nombre_lote,dualidad_mes from(
	select 0 exist,ifnull(sum(total_gasto),0) as gastos, 0 produccion,0 p_local,0 p_exportacion,8 month, year(fecha_documento) anio,
		(select dualidad_mes from sector_lotes where id = sector_lote_id) dualidad_mes,
        (select descripcion from sector_lotes where id = sector_lote_id) nombre_lote  from gastos where month(fecha_documento) = 8 and anulado = 0
        and (select vigencia from sector_lotes where id = sector_lote_id) = 1
		group by sector_lote_id
	union all 
	select 0 exist,0 gastos,ifnull(sum(total_produccion),0) as produccion
        ,If(detalle_produccion.producto_id = 7,ifnull(sum(cajas),0), 0) p_local
        ,If(detalle_produccion.producto_id = 8,ifnull(sum(cajas),0), 0) p_exportacion
        ,8 month, year(fecha_documento) anio,
		(select dualidad_mes from sector_lotes where id = sector_lote_id) dualidad_mes,
        (select descripcion from sector_lotes where id = sector_lote_id) nombre_lote from produccion 
        left outer join detalle_produccion on detalle_produccion.produccion_id = produccion.id
        where month(fecha_documento) = 8 and anulado = 0
        and (select vigencia from sector_lotes where id = sector_lote_id) = 1
	group by sector_lote_id
    union all
		select count(id) exist,0 gastos, 0.00 produccion,0,0, 8 month, year(curtime()) anio, dualidad_mes, descripcion from sector_lotes where dualidad_mes = 'jul_ago'
        and vigencia = 1
		group by descripcion
) tmp #AGOSTO
group by nombre_lote
union all
select exist,sum(gastos) gastos, sum(produccion) produccion, sum(p_local) p_local, sum(p_exportacion) p_exportacion, month, anio, nombre_lote,dualidad_mes from(
	select 0 exist,ifnull(sum(total_gasto),0) as gastos, 0 produccion,0 p_local,0 p_exportacion,9 month, year(fecha_documento) anio,
		(select dualidad_mes from sector_lotes where id = sector_lote_id) dualidad_mes,
        (select descripcion from sector_lotes where id = sector_lote_id) nombre_lote  from gastos where month(fecha_documento) = 9 and anulado = 0
        and (select vigencia from sector_lotes where id = sector_lote_id) = 1
		group by sector_lote_id
	union all 
	select 0 exist,0 gastos,ifnull(sum(total_produccion),0) as produccion
        ,If(detalle_produccion.producto_id = 7,ifnull(sum(cajas),0), 0) p_local
        ,If(detalle_produccion.producto_id = 8,ifnull(sum(cajas),0), 0) p_exportacion
        ,9 month, year(fecha_documento) anio,
		(select dualidad_mes from sector_lotes where id = sector_lote_id) dualidad_mes,
        (select descripcion from sector_lotes where id = sector_lote_id) nombre_lote from produccion 
        left outer join detalle_produccion on detalle_produccion.produccion_id = produccion.id
        where month(fecha_documento) = 9 and anulado = 0
        and (select vigencia from sector_lotes where id = sector_lote_id) = 1
	group by sector_lote_id
    union all
		select count(id) exist,0 gastos, 0.00 produccion,0,0, 9 month, year(curtime()) anio, dualidad_mes, descripcion from sector_lotes where dualidad_mes = 'sep_oct'
        and vigencia = 1
		group by descripcion
) tmp #SEPTIEMBRE
group by nombre_lote
union all
select exist,sum(gastos) gastos, sum(produccion) produccion, sum(p_local) p_local, sum(p_exportacion) p_exportacion, month, anio, nombre_lote,dualidad_mes from(
	select 0 exist,ifnull(sum(total_gasto),0) as gastos, 0 produccion,0 p_local,0 p_exportacion,10 month, year(fecha_documento) anio,
		(select dualidad_mes from sector_lotes where id = sector_lote_id) dualidad_mes,
        (select descripcion from sector_lotes where id = sector_lote_id) nombre_lote  from gastos where month(fecha_documento) = 10 and anulado = 0
        and (select vigencia from sector_lotes where id = sector_lote_id) = 1
		group by sector_lote_id
	union all 
	select 0 exist,0 gastos,ifnull(sum(total_produccion),0) as produccion
        ,If(detalle_produccion.producto_id = 7,ifnull(sum(cajas),0), 0) p_local
        ,If(detalle_produccion.producto_id = 8,ifnull(sum(cajas),0), 0) p_exportacion
        ,10 month, year(fecha_documento) anio,
		(select dualidad_mes from sector_lotes where id = sector_lote_id) dualidad_mes,
        (select descripcion from sector_lotes where id = sector_lote_id) nombre_lote from produccion 
        left outer join detalle_produccion on detalle_produccion.produccion_id = produccion.id
        where month(fecha_documento) = 10 and anulado = 0
        and (select vigencia from sector_lotes where id = sector_lote_id) = 1
	group by sector_lote_id
    union all
		select count(id) exist,0 gastos, 0.00 produccion,0,0, 10 month, year(curtime()) anio, dualidad_mes, descripcion from sector_lotes where dualidad_mes = 'sep_oct'
        and vigencia = 1
		group by descripcion
) tmp #OCTUBRE
group by nombre_lote
union all
select exist,sum(gastos) gastos, sum(produccion) produccion, sum(p_local) p_local, sum(p_exportacion) p_exportacion, month, anio, nombre_lote,dualidad_mes from(
	select 0 exist,ifnull(sum(total_gasto),0) as gastos, 0 produccion,0 p_local,0 p_exportacion,11 month, year(fecha_documento) anio,
		(select dualidad_mes from sector_lotes where id = sector_lote_id) dualidad_mes,
        (select descripcion from sector_lotes where id = sector_lote_id) nombre_lote  from gastos where month(fecha_documento) = 11 and anulado = 0
        and (select vigencia from sector_lotes where id = sector_lote_id) = 1
		group by sector_lote_id
	union all 
	select 0 exist,0 gastos,ifnull(sum(total_produccion),0) as produccion
        ,If(detalle_produccion.producto_id = 7,ifnull(sum(cajas),0), 0) p_local
        ,If(detalle_produccion.producto_id = 8,ifnull(sum(cajas),0), 0) p_exportacion
        ,11 month, year(fecha_documento) anio,
		(select dualidad_mes from sector_lotes where id = sector_lote_id) dualidad_mes,
        (select descripcion from sector_lotes where id = sector_lote_id) nombre_lote from produccion 
        left outer join detalle_produccion on detalle_produccion.produccion_id = produccion.id
        where month(fecha_documento) = 11 and anulado = 0
        and (select vigencia from sector_lotes where id = sector_lote_id) = 1
	group by sector_lote_id
    union all
		select count(id) exist,0 gastos, 0.00 produccion,0,0, 11 month, year(curtime()) anio, dualidad_mes, descripcion from sector_lotes where dualidad_mes = 'nov_dic'
        and vigencia = 1
		group by descripcion
) tmp #NOVIEMBRE
group by nombre_lote
union all
select exist,sum(gastos) gastos, sum(produccion) produccion, sum(p_local) p_local, sum(p_exportacion) p_exportacion, month, anio, nombre_lote,dualidad_mes from(
	select 0 exist,ifnull(sum(total_gasto),0) as gastos, 0 produccion,0 p_local,0 p_exportacion,12 month, year(fecha_documento) anio,
		(select dualidad_mes from sector_lotes where id = sector_lote_id) dualidad_mes,
        (select descripcion from sector_lotes where id = sector_lote_id) nombre_lote  from gastos where month(fecha_documento) = 12 and anulado = 0
        and (select vigencia from sector_lotes where id = sector_lote_id) = 1
		group by sector_lote_id
	union all 
	select 0 exist,0 gastos,ifnull(sum(total_produccion),0) as produccion
        ,If(detalle_produccion.producto_id = 7,ifnull(sum(cajas),0), 0) p_local
        ,If(detalle_produccion.producto_id = 8,ifnull(sum(cajas),0), 0) p_exportacion
        ,12 month, year(fecha_documento) anio,
		(select dualidad_mes from sector_lotes where id = sector_lote_id) dualidad_mes,
        (select descripcion from sector_lotes where id = sector_lote_id) nombre_lote from produccion 
        left outer join detalle_produccion on detalle_produccion.produccion_id = produccion.id
        where month(fecha_documento) = 12 and anulado = 0
        and (select vigencia from sector_lotes where id = sector_lote_id) = 1
	group by sector_lote_id
    union all
		select count(id) exist,0 gastos, 0.00 produccion,0,0, 12 month, year(curtime()) anio, dualidad_mes, descripcion from sector_lotes where dualidad_mes = 'nov_dic'
        and vigencia = 1
		group by descripcion
) tmp #DICIEMBRE
group by nombre_lote


#productos
INSERT INTO productos (id,descripcion,tipo_inventario,tipo_producto,stock,costo,precio_unitario,unidad_medida,factor,tipo_gasto_id,created_at,updated_at)
VALUES (1,'Urea','1',1,0.00,31.40,0.00,'kg',	50.00,5,curtime(),curtime());

INSERT INTO productos (id,descripcion,tipo_inventario,tipo_producto,stock,costo,precio_unitario,unidad_medida,factor,tipo_gasto_id,created_at,updated_at)
VALUES (2,'Fosfato diamónico','1','1',0.00,35.00,0.00,'kg',25.00,5,curtime(),curtime());

INSERT INTO productos (id,descripcion,tipo_inventario,tipo_producto,stock,costo,precio_unitario,unidad_medida,factor,tipo_gasto_id,created_at,updated_at)
VALUES (3,'Nitrato de potasio','1','1',0.00,70.00,0.00,'kg',0.00,5,curtime(),curtime());

INSERT INTO productos (id,descripcion,tipo_inventario,tipo_producto,stock,costo,precio_unitario,unidad_medida,factor,tipo_gasto_id,created_at,updated_at)
VALUES (4,'Sulfato armónico','1','1',0.00,32.16,0.00,'kg',0.00,5,curtime(),curtime());

INSERT INTO productos (id,descripcion,tipo_inventario,tipo_producto,stock,costo,precio_unitario,unidad_medida,factor,tipo_gasto_id,created_at,updated_at)
VALUES (5,'Riego (cada 2 días)','2','1',0.00,190.00,0.00,'und',1.00,6,curtime(),curtime());

INSERT INTO productos (id,descripcion,tipo_inventario,tipo_producto,stock,costo,precio_unitario,unidad_medida,factor,tipo_gasto_id,created_at,updated_at)
VALUES (6,'Vigilancia','2','1',0.00,350.00,0.00,'und',1.00,7,curtime(),curtime());

INSERT INTO productos (id,descripcion,tipo_inventario,tipo_producto,stock,costo,precio_unitario,unidad_medida,factor,tipo_gasto_id,created_at,updated_at)
VALUES (7,'Papaya Local','1','2',00.00,0.00,5.00,'lb',37.00,8,curtime(),curtime());

INSERT INTO productos (id,descripcion,tipo_inventario,tipo_producto,stock,costo,precio_unitario,unidad_medida,factor,tipo_gasto_id,created_at,updated_at)
VALUES (8,'Papaya Exportación','1','2',0.00,0.00,5.00,'lb',37.00,8,curtime(),curtime());

INSERT INTO productos (id,descripcion,tipo_inventario,tipo_producto,stock,costo,precio_unitario,unidad_medida,factor,tipo_gasto_id,created_at,updated_at)
VALUES (9,'Jornalero','2','1',0.00,195.00,0.00,'und',1.00,9,curtime(),curtime());

#tipos_gastos;
INSERT INTO tipos_gastos (id,descripcion,created_at,updated_at)
VALUES(5,'Fertilizantes',curtime(),curtime());

INSERT INTO tipos_gastos (id,descripcion,created_at,updated_at)
VALUES(6,'Riego',curtime(),curtime());

INSERT INTO tipos_gastos (id,descripcion,created_at,updated_at)
VALUES(7,'Vigilancia',curtime(),curtime());

INSERT INTO tipos_gastos (id,descripcion,created_at,updated_at)
VALUES(8,'Indeterminado',curtime(),curtime());

INSERT INTO tipos_gastos (id,descripcion,created_at,updated_at)
VALUES(9,'mano de obra',curtime(),curtime());

select * from sector_lotes;
#sector_lotes
	#sector
	INSERT INTO sector_lotes (id,descripcion,data,codigo_padre,hectareas_area,dualidad_mes,vigencia,created_at,updated_at)
	VALUES (5,'Parcela Paya Maradol2022','SC',null,20.00,null,0,curtime(),curtime());
	#hectarea
	INSERT INTO sector_lotes (id,descripcion,data,codigo_padre,hectareas_area,dualidad_mes,vigencia,created_at,updated_at)
	VALUES (6,'Hectarea Enero-Febrero','LT',5,2,'ene_feb',1,curtime(),curtime());
    INSERT INTO sector_lotes (id,descripcion,data,codigo_padre,hectareas_area,dualidad_mes,vigencia,created_at,updated_at)
	VALUES (7,'Hectarea Marzo-Abril','LT',5,2,'mar_abr',1,curtime(),curtime());
    INSERT INTO sector_lotes (id,descripcion,data,codigo_padre,hectareas_area,dualidad_mes,vigencia,created_at,updated_at)
	VALUES (8,'Hectarea Mayo-Junio','LT',5,2,'may_jun',1,curtime(),curtime());
    INSERT INTO sector_lotes (id,descripcion,data,codigo_padre,hectareas_area,dualidad_mes,vigencia,created_at,updated_at)
	VALUES (9,'Hectarea Julio-Agosto','LT',5,2,'jul_ago',1,curtime(),curtime());
    INSERT INTO sector_lotes (id,descripcion,data,codigo_padre,hectareas_area,dualidad_mes,vigencia,created_at,updated_at)
	VALUES (10,'Hectarea Septiembre-Octubre','LT',5,2,'sep_oct',1,curtime(),curtime());
    INSERT INTO sector_lotes (id,descripcion,data,codigo_padre,hectareas_area,dualidad_mes,vigencia,created_at,updated_at)
	VALUES (11,'Hectarea Noviembre-Diciembre','LT',5,2,'nov_dic',1,curtime(),curtime());
    
#cliente
INSERT INTO clientes (id,cedula,nombres,apellidos,email,direccion,telefono,celular,tipo_cliente,created_at,updated_at)
VALUES (1,'0921571857','Joel Javier','García Zavala','mascasacada56@gmail.com','Avenida del ejercito y Maracai','2358006','0986481355','1',curtime(),curtime());

INSERT INTO clientes (id,cedula,nombres,apellidos,email,direccion,telefono,celular,tipo_cliente,created_at,updated_at)
VALUES (2,'0945682136','Miguel Pedro','Contreras Viñeda','pedcontre@gmail.com','avanieda7788','2698456','0965891255','2',curtime(),curtime());

INSERT INTO clientes (id,cedula,nombres,apellidos,email,direccion,telefono,celular,tipo_cliente,created_at,updated_at)
VALUES (3,'0701794588','Angela Azusena','Suarez','angesua@gmail.com','Avenida del ejercito y Maracai','2357452','0967221155','2',curtime(),curtime());



alter view vw_balance_final as
select sum(gastos) gastos, sum(ventas) ventas, sum(produccion) produccion, month, fecha_documento, anio, nombre_lote from(   
    select ifnull(sum(total_gasto),0) as gastos, 0 ventas, 0 produccion,1 month, year(fecha_documento) anio,fecha_documento,
    (select descripcion from sector_lotes where id = sector_lote_id) nombre_lote from gastos where month(fecha_documento) = 1 and anulado = 0
    group by fecha_documento,sector_lote_id
    union all 
    select 0 gastos,ifnull(sum(total_venta),0) as ventas, 0 produccion,1 month, year(fecha_documento) anio,fecha_documento, 
    (select descripcion from sector_lotes where id = sector_lote_id) nombre_lote from ventas where month(fecha_documento) = 1 and anulado = 0
    group by fecha_documento
    union all
    select 0 gastos, 0 ventas,ifnull(sum(total_produccion),0) as produccion,1 month, year(fecha_documento) anio,fecha_documento,
    (select descripcion from sector_lotes where id = sector_lote_id) nombre_lote from produccion where month(fecha_documento) = 1 and anulado = 0
        group by fecha_documento,sector_lote_id
    union all
    select 0,0,0,1, anio, curtime(), '' from anios
) tmp  group by anio #ENERO
union all
select sum(gastos) gastos, sum(ventas) ventas, sum(produccion) produccion, month, fecha_documento, anio, nombre_lote from(
    select ifnull(sum(total_gasto),0) as gastos, 0 ventas, 0 produccion,2 month, year(fecha_documento) anio,fecha_documento,
    (select descripcion from sector_lotes where id = sector_lote_id) nombre_lote from gastos where month(fecha_documento) = 2 and anulado = 0
    group by fecha_documento,sector_lote_id
    union all 
    select 0 gastos,ifnull(sum(total_venta),0) as ventas, 0 produccion,2 month, year(fecha_documento) anio,fecha_documento, 
    (select descripcion from sector_lotes where id = sector_lote_id) nombre_lote from ventas where month(fecha_documento) = 2 and anulado = 0
    group by fecha_documento
    union all
    select 0 gastos, 0 ventas,ifnull(sum(total_produccion),0) as produccion,2 month, year(fecha_documento) anio,fecha_documento,
    (select descripcion from sector_lotes where id = sector_lote_id) nombre_lote from produccion where month(fecha_documento) = 2 and anulado = 0
        group by fecha_documento,sector_lote_id
    union all
    select 0,0,0,2, anio, curtime(), '' from anios
) tmp group by anio #FEBRERO
union all
select sum(gastos) gastos, sum(ventas) ventas, sum(produccion) produccion, month, fecha_documento, anio, nombre_lote from(
    select ifnull(sum(total_gasto),0) as gastos, 0 ventas, 0 produccion,3 month, year(fecha_documento) anio,fecha_documento,
    (select descripcion from sector_lotes where id = sector_lote_id) nombre_lote from gastos where month(fecha_documento) = 3 and anulado = 0
    group by fecha_documento,sector_lote_id
    union all 
    select 0 gastos,ifnull(sum(total_venta),0) as ventas, 0 produccion,3 month, year(fecha_documento) anio,fecha_documento, 
    (select descripcion from sector_lotes where id = sector_lote_id) nombre_lote from ventas where month(fecha_documento) = 3 and anulado = 0
    group by fecha_documento
    union all
    select 0 gastos, 0 ventas,ifnull(sum(total_produccion),0) as produccion,3 month, year(fecha_documento) anio,fecha_documento,
    (select descripcion from sector_lotes where id = sector_lote_id) nombre_lote from produccion where month(fecha_documento) = 3 and anulado = 0
        group by fecha_documento,sector_lote_id
    union all
    select 0,0,0,3, anio, curtime(), '' from anios
) tmp group by anio #MARZO
union all
select sum(gastos) gastos, sum(ventas) ventas, sum(produccion) produccion, month, fecha_documento, anio, nombre_lote from(
    select ifnull(sum(total_gasto),0) as gastos, 0 ventas, 0 produccion,4 month, year(fecha_documento) anio,fecha_documento,
    (select descripcion from sector_lotes where id = sector_lote_id) nombre_lote from gastos where month(fecha_documento) = 4 and anulado = 0
    group by fecha_documento,sector_lote_id
    union all 
    select 0 gastos,ifnull(sum(total_venta),0) as ventas, 0 produccion,4 month, year(fecha_documento) anio,fecha_documento, 
    (select descripcion from sector_lotes where id = sector_lote_id) nombre_lote from ventas where month(fecha_documento) = 4 and anulado = 0
    group by fecha_documento
    union all
    select 0 gastos, 0 ventas,ifnull(sum(total_produccion),0) as produccion,4 month, year(fecha_documento) anio,fecha_documento,
    (select descripcion from sector_lotes where id = sector_lote_id) nombre_lote from produccion where month(fecha_documento) = 4 and anulado = 0
        group by fecha_documento,sector_lote_id
    union all
    select 0,0,0,4, anio, curtime(), '' from anios
) tmp group by anio #ABRIL
union all
select sum(gastos) gastos, sum(ventas) ventas, sum(produccion) produccion, month, fecha_documento, anio, nombre_lote from(
    select ifnull(sum(total_gasto),0) as gastos, 0 ventas, 0 produccion,5 month, year(fecha_documento) anio,fecha_documento,
    (select descripcion from sector_lotes where id = sector_lote_id) nombre_lote from gastos where month(fecha_documento) = 5 and anulado = 0
    group by fecha_documento,sector_lote_id
    union all 
    select 0 gastos,ifnull(sum(total_venta),0) as ventas, 0 produccion,5 month, year(fecha_documento) anio,fecha_documento, 
    (select descripcion from sector_lotes where id = sector_lote_id) nombre_lote from ventas where month(fecha_documento) = 5 and anulado = 0
    group by fecha_documento
    union all
    select 0 gastos, 0 ventas,ifnull(sum(total_produccion),0) as produccion,5 month, year(fecha_documento) anio,fecha_documento,
    (select descripcion from sector_lotes where id = sector_lote_id) nombre_lote from produccion where month(fecha_documento) = 5 and anulado = 0
        group by fecha_documento,sector_lote_id
    union all
    select 0,0,0,5, anio, curtime(), '' from anios
) tmp group by anio #MAYO
union all
select sum(gastos) gastos, sum(ventas) ventas, sum(produccion) produccion, month, fecha_documento, anio, nombre_lote from(
    select ifnull(sum(total_gasto),0) as gastos, 0 ventas, 0 produccion,6 month, year(fecha_documento) anio,fecha_documento,
    (select descripcion from sector_lotes where id = sector_lote_id) nombre_lote from gastos where month(fecha_documento) = 6 and anulado = 0
    group by fecha_documento,sector_lote_id
    union all 
    select 0 gastos,ifnull(sum(total_venta),0) as ventas, 0 produccion,6 month, year(fecha_documento) anio,fecha_documento, 
    (select descripcion from sector_lotes where id = sector_lote_id) nombre_lote from ventas where month(fecha_documento) = 6 and anulado = 0
    group by fecha_documento
    union all
    select 0 gastos, 0 ventas,ifnull(sum(total_produccion),0) as produccion,6 month, year(fecha_documento) anio,fecha_documento,
    (select descripcion from sector_lotes where id = sector_lote_id) nombre_lote from produccion where month(fecha_documento) = 6 and anulado = 0
        group by fecha_documento,sector_lote_id
    union all
    select 0,0,0,6, anio, curtime(), '' from anios
) tmp group by anio #JUNIO
union all
select sum(gastos) gastos, sum(ventas) ventas, sum(produccion) produccion, month, fecha_documento, anio, nombre_lote from(
    select ifnull(sum(total_gasto),0) as gastos, 0 ventas, 0 produccion,7 month, year(fecha_documento) anio,fecha_documento,
    (select descripcion from sector_lotes where id = sector_lote_id) nombre_lote from gastos where month(fecha_documento) = 7 and anulado = 0
    group by fecha_documento,sector_lote_id
    union all 
    select 0 gastos,ifnull(sum(total_venta),0) as ventas, 0 produccion,7 month, year(fecha_documento) anio,fecha_documento, 
    (select descripcion from sector_lotes where id = sector_lote_id) nombre_lote from ventas where month(fecha_documento) = 7 and anulado = 0
    group by fecha_documento
    union all
    select 0 gastos, 0 ventas,ifnull(sum(total_produccion),0) as produccion,7 month, year(fecha_documento) anio,fecha_documento,
    (select descripcion from sector_lotes where id = sector_lote_id) nombre_lote from produccion where month(fecha_documento) = 7 and anulado = 0
        group by fecha_documento,sector_lote_id
    union all
    select 0,0,0,7, anio, curtime(), '' from anios
) tmp group by anio #JULIO
union all
select sum(gastos) gastos, sum(ventas) ventas, sum(produccion) produccion, month, fecha_documento, anio, nombre_lote from(
    select ifnull(sum(total_gasto),0) as gastos, 0 ventas, 0 produccion,8 month, year(fecha_documento) anio,fecha_documento,
    (select descripcion from sector_lotes where id = sector_lote_id) nombre_lote from gastos where month(fecha_documento) = 8 and anulado = 0
    group by fecha_documento,sector_lote_id
    union all 
    select 0 gastos,ifnull(sum(total_venta),0) as ventas, 0 produccion,8 month, year(fecha_documento) anio,fecha_documento, 
    (select descripcion from sector_lotes where id = sector_lote_id) nombre_lote from ventas where month(fecha_documento) = 8 and anulado = 0
    group by fecha_documento
    union all
    select 0 gastos, 0 ventas,ifnull(sum(total_produccion),0) as produccion,8 month, year(fecha_documento) anio,fecha_documento,
    (select descripcion from sector_lotes where id = sector_lote_id) nombre_lote from produccion where month(fecha_documento) = 8 and anulado = 0
        group by fecha_documento,sector_lote_id
    union all
    select 0,0,0,8, anio, curtime(), '' from anios
) tmp group by anio #AGOSTO
union all
select sum(gastos) gastos, sum(ventas) ventas, sum(produccion) produccion, month, fecha_documento, anio, nombre_lote from(
    select ifnull(sum(total_gasto),0) as gastos, 0 ventas, 0 produccion,9 month, year(fecha_documento) anio,fecha_documento,
    (select descripcion from sector_lotes where id = sector_lote_id) nombre_lote from gastos where month(fecha_documento) = 9 and anulado = 0
    group by fecha_documento,sector_lote_id
    union all 
    select 0 gastos,ifnull(sum(total_venta),0) as ventas, 0 produccion,9 month, year(fecha_documento) anio,fecha_documento, 
    (select descripcion from sector_lotes where id = sector_lote_id) nombre_lote from ventas where month(fecha_documento) = 9 and anulado = 0
    group by fecha_documento
    union all
    select 0 gastos, 0 ventas,ifnull(sum(total_produccion),0) as produccion,9 month, year(fecha_documento) anio,fecha_documento,
    (select descripcion from sector_lotes where id = sector_lote_id) nombre_lote from produccion where month(fecha_documento) = 9 and anulado = 0
        group by fecha_documento,sector_lote_id
    union all
    select 0,0,0,9, anio, curtime(), '' from anios
) tmp group by anio #SEPTIEMBRE
union all
select sum(gastos) gastos, sum(ventas) ventas, sum(produccion) produccion, month, fecha_documento, anio, nombre_lote from(
    select ifnull(sum(total_gasto),0) as gastos, 0 ventas, 0 produccion,10 month, year(fecha_documento) anio,fecha_documento,
    (select descripcion from sector_lotes where id = sector_lote_id) nombre_lote from gastos where month(fecha_documento) = 10 and anulado = 0
    group by fecha_documento,sector_lote_id
    union all 
    select 0 gastos,ifnull(sum(total_venta),0) as ventas, 0 produccion,10 month, year(fecha_documento) anio,fecha_documento, 
    (select descripcion from sector_lotes where id = sector_lote_id) nombre_lote from ventas where month(fecha_documento) = 10 and anulado = 0
    group by fecha_documento
    union all
    select 0 gastos, 0 ventas,ifnull(sum(total_produccion),0) as produccion,10 month, year(fecha_documento) anio,fecha_documento,
    (select descripcion from sector_lotes where id = sector_lote_id) nombre_lote from produccion where month(fecha_documento) = 10 and anulado = 0
        group by fecha_documento,sector_lote_id
    union all
    select 0,0,0,10, anio, curtime(), '' from anios
) tmp group by anio #OCTUBRE
union all
select sum(gastos) gastos, sum(ventas) ventas, sum(produccion) produccion, month, fecha_documento, anio, nombre_lote from(
    select ifnull(sum(total_gasto),0) as gastos, 0 ventas, 0 produccion,11 month, year(fecha_documento) anio,fecha_documento,
    (select descripcion from sector_lotes where id = sector_lote_id) nombre_lote from gastos where month(fecha_documento) = 11 and anulado = 0
    group by fecha_documento,sector_lote_id
    union all 
    select 0 gastos,ifnull(sum(total_venta),0) as ventas, 0 produccion,11 month, year(fecha_documento) anio,fecha_documento, 
    (select descripcion from sector_lotes where id = sector_lote_id) nombre_lote from ventas where month(fecha_documento) = 11 and anulado = 0
    group by fecha_documento
    union all
    select 0 gastos, 0 ventas,ifnull(sum(total_produccion),0) as produccion,11 month, year(fecha_documento) anio,fecha_documento,
    (select descripcion from sector_lotes where id = sector_lote_id) nombre_lote from produccion where month(fecha_documento) = 11 and anulado = 0
        group by fecha_documento,sector_lote_id
    union all
    select 0,0,0,11, anio, curtime(), '' from anios
) tmp group by anio #NOVIEMBRE
union all
select sum(gastos) gastos, sum(ventas) ventas, sum(produccion) produccion, month, fecha_documento, anio, nombre_lote from(
    select ifnull(sum(total_gasto),0) as gastos, 0 ventas, 0 produccion,12 month, year(fecha_documento) anio,fecha_documento,
    (select descripcion from sector_lotes where id = sector_lote_id) nombre_lote from gastos where month(fecha_documento) = 12 and anulado = 0
    group by fecha_documento,sector_lote_id
    union all 
    select 0 gastos,ifnull(sum(total_venta),0) as ventas, 0 produccion,12 month, year(fecha_documento) anio,fecha_documento, 
    (select descripcion from sector_lotes where id = sector_lote_id) nombre_lote from ventas where month(fecha_documento) = 12 and anulado = 0
    group by fecha_documento
    union all
    select 0 gastos, 0 ventas,ifnull(sum(total_produccion),0) as produccion,12 month, year(fecha_documento) anio,fecha_documento,
    (select descripcion from sector_lotes where id = sector_lote_id) nombre_lote from produccion where month(fecha_documento) = 12 and anulado = 0
        group by fecha_documento,sector_lote_id
    union all
    select 0,0,0,12, anio, curtime(), '' from anios
) tmp group by anio #DICIEMBRE


