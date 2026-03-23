----------------------------------------------------------
----------------------------------------------------------
--Creacion de la base de datos
IF NOT EXISTS (
    SELECT name FROM sys.databases WHERE name = 'BiciMundo'
)
BEGIN
    CREATE DATABASE BiciMundo;
END
GO

-----------------------------------------------------------
-----------------------------------------------------------
-- CREACIÓN DE TABLAS
USE BiciMundo;

------------------------------------------------------------

CREATE TABLE Zona (
    id_zona INT IDENTITY(1,1),
    nombre_zona VARCHAR(100),
	id_distrito INT
);

-----------------------------------------------------------

CREATE TABLE Distrito (
    id_distrito INT IDENTITY(1,1),
    nombre_distrito VARCHAR(100),
);

-----------------------------------------------------------

CREATE TABLE Tienda (
    id_tienda INT IDENTITY(1,1),
    nombre_tienda VARCHAR(100),
    direccion VARCHAR(150),
    id_distrito INT
);

------------------------------------------------------------

CREATE TABLE Marca (
    id_marca INT IDENTITY(1,1),
    nombre_marca VARCHAR(100)
);

-------------------------------------------------------------

CREATE TABLE Modelo (
    id_modelo INT IDENTITY(1,1),
    nombre_modelo VARCHAR(100),
    año_modelo INT
);

--------------------------------------------------------------

CREATE TABLE Categoria (
    id_categoria INT IDENTITY(1,1),
    nombre_categoria VARCHAR(100)
);

---------------------------------------------------------------

CREATE TABLE Producto (
    id_producto INT IDENTITY(1,1),
    nombre VARCHAR(100),
    descripcion TEXT,
    precio_actual DECIMAL(10, 2),
    garantia_meses INT,
    id_categoria INT,
    id_marca INT,
    id_modelo INT
);

---------------------------------------------------------------

CREATE TABLE Inventario (
    id_inventario INT IDENTITY(1,1),
    id_producto INT,
    id_tienda INT,
    stock INT
);

---------------------------------------------------------------

CREATE TABLE Cliente (
    id_cliente INT IDENTITY(1,1),
    nombres VARCHAR(100),
    apellidos VARCHAR(100),
    correo VARCHAR(100),
    telefono VARCHAR(15),
    direccion VARCHAR(150),
    fecha_nacimiento DATE,
    dni VARCHAR(15),
    ruc VARCHAR(15),
    id_distrito INT
);

--dni es unico
ALTER TABLE Cliente
ADD CONSTRAINT UQ_Cliente_dni UNIQUE (dni);

-- ruc es unico
ALTER TABLE Cliente
ADD CONSTRAINT UQ_Cliente_ruc UNIQUE (ruc);

---------------------------------------------------------------

CREATE TABLE Vendedor (
    id_vendedor INT IDENTITY(1,1),
    nombres VARCHAR(100),
    apellidos VARCHAR(100),
    dni VARCHAR(15),
    domicilio VARCHAR(150),
    id_tienda INT
);
--dni es unico
Alter table Vendedor
add constraint UQ_Vendedor_dni UNIQUE (dni);

---------------------------------------------------------------

CREATE TABLE Tipo_Entrega (
    id_tipo_entrega INT IDENTITY(1,1),
    tipo_entrega VARCHAR(100)
);

---------------------------------------------------------------

CREATE TABLE Medio_Pago (
    id_medio_pago INT IDENTITY(1,1),
    descripcion VARCHAR(50)
);

----------------------------------------------------------------

CREATE TABLE Tipo_Tarjeta (
    id_tipo_tarjeta INT IDENTITY(1,1),
    tipo VARCHAR(50),
    id_medio_pago INT
);

-----------------------------------------------------------------

CREATE TABLE Tipo_Documento (
    id_tipo_documento INT IDENTITY(1,1),
    descripcion VARCHAR(50)
);

------------------------------------------------------------------

CREATE TABLE Venta (
    id_venta INT IDENTITY(1,1),
    fecha DATE,
    id_tipo_documento INT,
    serie_documento VARCHAR(10),
    numero_documento VARCHAR(20),
    id_cliente INT,
    id_vendedor INT,
    id_tipo_entrega INT,
    id_medio_pago INT
);
--Lo que sí debe ser único es la combinación de serie_documento + numero_documento.
--Eso asegura que cada documento (como una factura o boleta) sea único.
ALTER TABLE Venta
ADD CONSTRAINT UQ_Venta_SerieNumero UNIQUE (serie_documento, numero_documento);

-----------------------------------------------------------------

CREATE TABLE Detalle_Venta (
    id_detalle INT IDENTITY(1,1),
    id_venta INT,
    id_producto INT,
    cantidad INT,
    precio_unitario DECIMAL(10, 2)
);

------------------------------------------------------------------

CREATE TABLE Proveedor (
    id_proveedor INT IDENTITY(1,1),
    razon_social VARCHAR(100),
    ruc VARCHAR(15),
    direccion VARCHAR(150),
    correo VARCHAR(100),
    telefono VARCHAR(15)
);

--ruc es unico
Alter table Proveedor
add constraint UQ_Proveedor_ruc UNIQUE (ruc);

------------------------------------------------------------------

CREATE TABLE Producto_Proveedor (
    id_producto_proveedor INT IDENTITY(1,1),
    id_producto INT,
    id_proveedor INT,
    precio_compra DECIMAL(10, 2),
    fecha_registro DATE
);


--------------------------------------------------------------------------------------------------------------------------------------
--------------------------------------------------------------------------------------------------------------------------------------

-- CLAVES PRIMARIAS

ALTER TABLE Zona ADD CONSTRAINT PK_Zona PRIMARY KEY (id_zona);
ALTER TABLE Distrito ADD CONSTRAINT PK_Distrito PRIMARY KEY (id_distrito);
ALTER TABLE Tienda ADD CONSTRAINT PK_Tienda PRIMARY KEY (id_tienda);
ALTER TABLE Marca ADD CONSTRAINT PK_Marca PRIMARY KEY (id_marca);
ALTER TABLE Modelo ADD CONSTRAINT PK_Modelo PRIMARY KEY (id_modelo);
ALTER TABLE Categoria ADD CONSTRAINT PK_Categoria PRIMARY KEY (id_categoria);
ALTER TABLE Producto ADD CONSTRAINT PK_Producto PRIMARY KEY (id_producto);
ALTER TABLE Inventario ADD CONSTRAINT PK_Inventario PRIMARY KEY (id_inventario);
ALTER TABLE Cliente ADD CONSTRAINT PK_Cliente PRIMARY KEY (id_cliente);
ALTER TABLE Vendedor ADD CONSTRAINT PK_Vendedor PRIMARY KEY (id_vendedor);
ALTER TABLE Tipo_Entrega ADD CONSTRAINT PK_Tipo_Entrega PRIMARY KEY (id_tipo_entrega);
ALTER TABLE Medio_Pago ADD CONSTRAINT PK_Medio_Pago PRIMARY KEY (id_medio_pago);
ALTER TABLE Tipo_Tarjeta ADD CONSTRAINT PK_Tipo_Tarjeta PRIMARY KEY (id_tipo_tarjeta);
ALTER TABLE Tipo_Documento ADD CONSTRAINT PK_Tipo_Documento PRIMARY KEY (id_tipo_documento);
ALTER TABLE Venta ADD CONSTRAINT PK_Venta PRIMARY KEY (id_venta);
ALTER TABLE Detalle_Venta ADD CONSTRAINT PK_Detalle_Venta PRIMARY KEY (id_detalle);
ALTER TABLE Proveedor ADD CONSTRAINT PK_Proveedor PRIMARY KEY (id_proveedor);
ALTER TABLE Producto_Proveedor ADD CONSTRAINT PK_Producto_Proveedor PRIMARY KEY (id_producto_proveedor);

-- CLAVES FORÁNEAS

ALTER TABLE Zona ADD CONSTRAINT FK_Zona_Distrito FOREIGN KEY (id_distrito) REFERENCES Distrito(id_distrito);
ALTER TABLE Tienda ADD CONSTRAINT FK_Tienda_Distrito FOREIGN KEY (id_distrito) REFERENCES Distrito(id_distrito);
ALTER TABLE Producto ADD CONSTRAINT FK_Producto_Categoria FOREIGN KEY (id_categoria) REFERENCES Categoria(id_categoria);
ALTER TABLE Producto ADD CONSTRAINT FK_Producto_Marca FOREIGN KEY (id_marca) REFERENCES Marca(id_marca);
ALTER TABLE Producto ADD CONSTRAINT FK_Producto_Modelo FOREIGN KEY (id_modelo) REFERENCES Modelo(id_modelo);
ALTER TABLE Inventario ADD CONSTRAINT FK_Inventario_Producto FOREIGN KEY (id_producto) REFERENCES Producto(id_producto);
ALTER TABLE Inventario ADD CONSTRAINT FK_Inventario_Tienda FOREIGN KEY (id_tienda) REFERENCES Tienda(id_tienda);
ALTER TABLE Cliente ADD CONSTRAINT FK_Cliente_Distrito FOREIGN KEY (id_distrito) REFERENCES Distrito(id_distrito);
ALTER TABLE Vendedor ADD CONSTRAINT FK_Vendedor_Tienda FOREIGN KEY (id_tienda) REFERENCES Tienda(id_tienda);
ALTER TABLE Tipo_Tarjeta ADD CONSTRAINT FK_Tipo_Tarjeta_Medio FOREIGN KEY (id_medio_pago) REFERENCES Medio_Pago(id_medio_pago);
ALTER TABLE Venta ADD CONSTRAINT FK_Venta_Cliente FOREIGN KEY (id_cliente) REFERENCES Cliente(id_cliente);
ALTER TABLE Venta ADD CONSTRAINT FK_Venta_Vendedor FOREIGN KEY (id_vendedor) REFERENCES Vendedor(id_vendedor);
ALTER TABLE Venta ADD CONSTRAINT FK_Venta_Entrega FOREIGN KEY (id_tipo_entrega) REFERENCES Tipo_Entrega(id_tipo_entrega);
ALTER TABLE Venta ADD CONSTRAINT FK_Venta_Medio FOREIGN KEY (id_medio_pago) REFERENCES Medio_Pago(id_medio_pago);
ALTER TABLE Venta ADD CONSTRAINT FK_Venta_Documento FOREIGN KEY (id_tipo_documento) REFERENCES Tipo_Documento(id_tipo_documento);
ALTER TABLE Detalle_Venta ADD CONSTRAINT FK_Detalle_Venta_Venta FOREIGN KEY (id_venta) REFERENCES Venta(id_venta);
ALTER TABLE Detalle_Venta ADD CONSTRAINT FK_Detalle_Venta_Producto FOREIGN KEY (id_producto) REFERENCES Producto(id_producto);
ALTER TABLE Producto_Proveedor ADD CONSTRAINT FK_Producto_Proveedor_Producto FOREIGN KEY (id_producto) REFERENCES Producto(id_producto);
ALTER TABLE Producto_Proveedor ADD CONSTRAINT FK_Producto_Proveedor_Proveedor FOREIGN KEY (id_proveedor) REFERENCES Proveedor(id_proveedor);

--------------------------------------------------------------------------------------------------------------------------------------------------------
--------------------------------------------------------------------------------------------------------------------------------------------------------

-- tabla distrito
INSERT INTO Distrito (nombre_distrito) VALUES
('Ancón'),
('Ate'),
('Barranco'),
('Breña'),
('Carabayllo'),
('Chaclacayo'),
('Chorrillos'),
('Cieneguilla'),
('Comas'),
('El Agustino'),
('Independencia'),
('Jesús María'),
('La Molina'),
('La Victoria'),
('Lince'),
('Los Olivos'),
('Lurigancho'),
('Lurín'),
('Magdalena del Mar'),
('Miraflores'),
('Pueblo Libre'),
('Puente Piedra'),
('San Bartolo'),
('San Borja'),
('San Isidro'),
('San Juan de Lurigancho'),
('San Juan de Miraflores'),
('San Luis'),
('San Martín de Porres'),
('San Miguel');

--select * from Distrito

----------------------------------------------------------------------------------
-- Tabla Zona

INSERT INTO Zona (nombre_zona, id_distrito) VALUES
('Playa de Ancón', 1),
('Puerto de Ancón', 1),
('Centro Histórico de Ancón', 1),
('Calle Lima (Avenida principal)', 1),
('Mirador de Ancón', 1),
('Cerro El Agustino', 2),
('Avenida Javier Prado', 2),
('Parque Zonal Huayna Cápac', 2),
('Avenida Nicolás Ayllón', 2),
('Zonal Ate Vitarte', 2),
('Plaza de Barranco', 3),
('Puente de los Suspiros', 3),
('Avenida Bajada de Baños', 3),
('La Ermita', 3),
('Museo de Arte Contemporáneo (MAC)', 3),
('Plaza de Breña', 4),
('Avenida Brasil', 4),
('Parque del Ejército', 4),
('José Galvez', 4),
('Avenida Venezuela', 4),
('Parque Zonal Sinchi Roca', 5),
('Avenida Tupac Amaru', 5),
('Plaza de Armas de Carabayllo', 5),
('Centro Histórico de Carabayllo', 5),
('Avenida Panamericana Norte', 5),
('Centro de Chaclacayo', 6),
('Avenida Las Flores', 6),
('Avenida Chaclacayo', 6),
('Parque Central de Chaclacayo', 6),
('Cerro San Juan', 6),
('Playa Costa Verde', 7),
('Parque Ecológico Loma Amarilla', 7),
('Avenida Pescadores', 7),
('Centro Histórico de Chorrillos', 7),
('Malecón de Chorrillos', 7),
('Centro de Cieneguilla', 8),
('Parque Zonal Héroes del Cenepa', 8),
('Avenida Los Ruiseñores', 8),
('Cerro San Pedro', 8),
('Zona de los Valles de Cieneguilla', 8),
('Parque Zonal Sinchi Roca', 9),
('Plaza Mayor de Comas', 9),
('Avenida Universitaria', 9),
('Avenida Tupac Amaru', 9),
('Jardines de Comas', 9),
('Cerro El Agustino', 10),
('Avenida San Juan', 10),
('Parque Zonal El Agustino', 10),
('Plaza Cívica de El Agustino', 10),
('Avenida 9 de Octubre', 10),
('Plaza de Independencia', 11),
('Avenida Independencia', 11),
('Centro Histórico de Independencia', 11),
('Parque Zonal Huayna Cápac', 11),
('Calle Los Pinos', 11),
('Plaza de Jesús María', 12),
('Avenida San Felipe', 12),
('Parque de la Reserva', 12),
('Avenida Arenales', 12),
('Jirón Húsares de Junín', 12),
('Avenida La Molina', 13),
('Cerro El Sol', 13),
('Centro Comercial Molina Plaza', 13),
('Avenida Los Fresnos', 13),
('La Universidad Nacional Agraria La Molina (UNALM)', 13),
('Avenida Nicolás Ayllón', 14),
('Centro Comercial Gamarra', 14),
('Plaza Manco Cápac', 14),
('Calle Santa Beatriz', 14),
('Calle Prolongación México', 14),
('Parque Mariscal Ramón Castilla', 15),
('Avenida Pardo', 15),
('Avenida César Vallejo', 15),
('Plaza de Lince', 15),
('Avenida Petit Thouars', 15),
('Plaza de Los Olivos', 16),
('Avenida Carlos Izaguirre', 16),
('Avenida Las Palmeras', 16),
('Cerro San Felipe', 16),
('Centro Comercial MegaPlaza', 16),
('Chosica (zona central)', 17),
('Avenida Progreso', 17),
('Parque Zonal Héroes del Cenepa', 17),
('Avenida Ceres', 17),
('Avenida Los Alpes', 17),
('Zona Arqueológica de Pachacámac', 18),
('Playa de Lurín', 18),
('Parque Industrial de Lurín', 18),
('Avenida Lurín', 18),
('Cerro Lurín', 18),
('Malecón de la Reserva', 19),
('Plaza de Magdalena', 19),
('Avenida Sucre', 19),
('Playa Waikiki', 19),
('Parque de la Iglesia', 19),
('Parque Kennedy', 20),
('Avenida Pardo', 20),
('Malecón de la Reserva', 20),
('Avenida José Larco', 20),
('Barranco (en los límites con Miraflores)', 20),
('Plaza Bolívar', 21),
('Avenida Sucre', 21),
('Parque de la Cultura', 21),
('Museo Nacional de Antropología, Arqueología e Historia del Perú', 21),
('Parque Temático Pueblo Libre', 21),
('Plaza de Puente Piedra', 22),
('Avenida Túpac Amaru', 22),
('Cerro de Puente Piedra', 22),
('Mercado de Puente Piedra', 22),
('Parque Zonal Puente Piedra', 22),
('Playa San Bartolo', 23),
('Plaza de San Bartolo', 23),
('Malecón de San Bartolo', 23),
('Parque Zonal San Bartolo', 23),
('Avenida Los Héroes', 23),
('Parque de la Reserva', 24),
('Centro Cultural de la Nación', 24),
('Avenida San Borja Norte', 24),
('Avenida Javier Prado', 24),
('Parque Zoológico de Huachipa', 24),
('Parque El Olivar', 25),
('Avenida Pardo y Aliaga', 25),
('Centro Empresarial de San Isidro', 25),
('Avenida Conquistadores', 25),
('Parque Mariscal Ramón Castilla', 25),
('Plaza de Armas de San Juan de Lurigancho', 26),
('Avenida Canto Grande', 26),
('Avenida San Juan', 26),
('Parque Zonal Héroes del Cenepa', 26),
('Cerro Lurigancho', 26),
('Parque de la Madre', 27),
('Avenida Los Héroes', 27),
('Plaza de Armas', 27),
('Avenida San Juan', 27),
('Zona de Villa de Salvador', 27),
('Plaza de San Luis', 28),
('Avenida San Luis', 28),
('Parque Zonal San Luis', 28),
('Calle Los Álamos', 28),
('Avenida Canadá', 28),
('Parque Zonal San Martín', 29),
('Plaza de San Martín de Porres', 29),
('Avenida Universitaria', 29),
('Mercado de San Martín de Porres', 29),
('Avenida Perú', 29),
('Plaza de San Miguel', 30),
('Avenida La Marina', 30),
('Centro Comercial San Miguel', 30),
('Parque de las Leyendas', 30),
('Malecón de la Marina', 30);

--Select * from Zona

----------------------------------------------------------------------------------------------------
--tabla Tienda

INSERT INTO Tienda (nombre_tienda, direccion, id_distrito) VALUES
('Tienda Ancón', 'Av. Mariscal Andrés Avelino Cáceres, Ancón', 1),
('Tienda Ate', 'Av. Nicolás Ayllón 8000, Ate', 2),
('Tienda Barranco', 'Av. Paseo de la República 1500, Barranco', 3),
('Tienda Breña', 'Jr. Cuzco 400, Breña', 4),
('Tienda Carabayllo', 'Av. Panamericana Norte 1200, Carabayllo', 5),
('Tienda Chaclacayo', 'Av. Chaclacayo 150, Chaclacayo', 6),
('Tienda Chorrillos', 'Av. Pescadores 900, Chorrillos', 7),
('Tienda Cieneguilla', 'Av. Los Ruiseñores 500, Cieneguilla', 8),
('Tienda Comas', 'Av. Universitaria 2100, Comas', 9),
('Tienda El Agustino', 'Av. San Juan 500, El Agustino', 10),
('Tienda Independencia', 'Av. Independencia 1300, Independencia', 11),
('Tienda Jesús María', 'Av. San Felipe 500, Jesús María', 12),
('Tienda La Molina', 'Av. La Molina 2000, La Molina', 13),
('Tienda La Victoria', 'Av. 28 de Julio 1600, La Victoria', 14),
('Tienda Lince', 'Av. Petit Thouars 1700, Lince', 15),
('Tienda Los Olivos', 'Av. Carlos Izaguirre 1200, Los Olivos', 16),
('Tienda Lurigancho', 'Av. Canto Grande 1400, Lurigancho', 17),
('Tienda Lurín', 'Av. Lurín 1800, Lurín', 18),
('Tienda Magdalena del Mar', 'Av. Sucre 2100, Magdalena del Mar', 19),
('Tienda Miraflores', 'Av. José Larco 800, Miraflores', 20),
('Tienda Pueblo Libre', 'Av. Sucre 1200, Pueblo Libre', 21),
('Tienda Puente Piedra', 'Av. Túpac Amaru 2000, Puente Piedra', 22),
('Tienda San Bartolo', 'Av. Los Héroes 1500, San Bartolo', 23),
('Tienda San Borja', 'Av. San Borja Norte 1000, San Borja', 24),
('Tienda San Isidro', 'Av. Conquistadores 1800, San Isidro', 25),
('Tienda San Juan de Lurigancho', 'Av. San Juan 1000, San Juan de Lurigancho', 26),
('Tienda San Juan de Miraflores', 'Av. Pedro Miotta 600, San Juan de Miraflores', 27),
('Tienda San Luis', 'Av. San Luis 1100, San Luis', 28),
('Tienda San Martín de Porres', 'Av. Perú 2000, San Martín de Porres', 29),
('Tienda San Miguel', 'Av. La Marina 1500, San Miguel', 30);

--select * from Tienda

------------------------------------------------------------------------------------------------------
--Tabla  Vendedor

INSERT INTO Vendedor (nombres, apellidos, dni, domicilio, id_tienda) VALUES
('Juan', 'Pérez', 70000001, 'Av. Siempre Viva 123', 1),
('María', 'Gómez', 70000002, 'Calle Luna 456', 2),
('Carlos', 'Ramírez', 70000003, 'Av. Sol 789', 3),
('Ana', 'Torres', 70000004, 'Jr. Estrella 101', 4),
('Luis', 'Vargas', 70000005, 'Av. Mar 202', 5),
('Sofía', 'Castro', 70000006, 'Pasaje Río 303', 6),
('José', 'Rojas', 70000007, 'Calle Lago 404', 7),
('Laura', 'Fernández', 70000008, 'Av. Nube 505', 8),
('Miguel', 'Salazar', 70000009, 'Jr. Brisa 606', 9),
('Lucía', 'Delgado', 70000010, 'Av. Bosque 707', 10),
('Diego', 'Mendoza', 70000011, 'Calle Monte 808', 1),
('Camila', 'Reyes', 70000012, 'Pasaje Viento 909', 2),
('Ricardo', 'Ibarra', 70000013, 'Av. Arena 111', 3),
('Daniela', 'Ortega', 70000014, 'Calle Fuego 222', 4),
('Fernando', 'Silva', 70000015, 'Jr. Lluvia 333', 5),
('Valeria', 'Navarro', 70000016, 'Av. Nieve 444', 6),
('Andrés', 'Guerrero', 70000017, 'Pasaje Sol 555', 7),
('Nicole', 'Cárdenas', 70000018, 'Calle Estrella 666', 8),
('Bruno', 'Morales', 70000019, 'Av. Cometa 777', 9),
('Gabriela', 'Vera', 70000020, 'Jr. Galaxia 888', 10),
('Eduardo', 'Paredes', 70000021, 'Av. Universo 999', 1),
('Flor', 'Chávez', 70000022, 'Calle Maravilla 121', 2),
('Martín', 'Montoya', 70000023, 'Pasaje Rocío 232', 3),
('Cecilia', 'Santos', 70000024, 'Jr. Horizonte 343', 4),
('Alonso', 'Peña', 70000025, 'Av. Amanecer 454', 5),
('Patricia', 'Rosales', 70000026, 'Calle Aurora 565', 6),
('Sebastián', 'Del Águila', 70000027, 'Pasaje Luna 676', 7),
('Claudia', 'Gutiérrez', 70000028, 'Av. Solsticio 787', 8),
('Pablo', 'Campos', 70000029, 'Jr. Eclipse 898', 9),
('Karina', 'Barrios', 70000030, 'Calle Cosmos 909', 10),
('Iván', 'Gonzales', 70000031, 'Av. Meteoro 112', 1),
('Vanessa', 'Alvarado', 70000032, 'Pasaje Brisa 223', 2),
('Mauricio', 'López', 70000033, 'Calle Llama 334', 3),
('Fiorella', 'Cruz', 70000034, 'Av. Tierra 445', 4),
('Óscar', 'Ruiz', 70000035, 'Jr. Río 556', 5),
('Paola', 'Herrera', 70000036, 'Pasaje Valle 667', 6),
('Cristian', 'Soto', 70000037, 'Calle Lago 778', 7),
('Liliana', 'Mora', 70000038, 'Av. Mar 889', 8),
('Javier', 'Aguilar', 70000039, 'Jr. Nube 990', 9),
('Denisse', 'Quispe', 70000040, 'Calle Sol 101', 10),
('Fabián', 'Mejía', 70000041, 'Av. Viento 202', 1),
('Angela', 'Vásquez', 70000042, 'Pasaje Estrella 303', 2),
('Héctor', 'Sandoval', 70000043, 'Calle Arena 404', 3),
('Luisa', 'Valdez', 70000044, 'Av. Cometa 505', 4),
('Gustavo', 'Paz', 70000045, 'Jr. Horizonte 606', 5),
('Alejandra', 'Cáceres', 70000046, 'Pasaje Universo 707', 6),
('Enrique', 'Zamora', 70000047, 'Calle Galaxia 808', 7),
('Mónica', 'Becerra', 70000048, 'Av. Nube 909', 8),
('Raúl', 'Arroyo', 70000049, 'Jr. Amanecer 112', 9),
('Natalia', 'Espinoza', 70000050, 'Calle Luna 223', 10),
('Rodrigo', 'Medina', 70000051, 'Av. Brisa 334', 1),
('Diana', 'Caballero', 70000052, 'Pasaje Sol 445', 2),
('Gerardo', 'Palacios', 70000053, 'Calle Estrella 556', 3),
('Araceli', 'Peralta', 70000054, 'Av. Tierra 667', 4),
('Felipe', 'Huerta', 70000055, 'Jr. Río 778', 5),
('Sandra', 'Rivas', 70000056, 'Pasaje Valle 889', 6),
('Esteban', 'Acosta', 70000057, 'Calle Lago 990', 7),
('Elena', 'Meza', 70000058, 'Av. Mar 101', 8),
('Tomás', 'Bravo', 70000059, 'Jr. Nube 212', 9),
('Verónica', 'Luna', 70000060, 'Calle Sol 323', 10),
('Hugo', 'Valverde', 70000061, 'Av. Viento 434', 1),
('Lorena', 'Cuellar', 70000062, 'Pasaje Estrella 545', 2),
('Alberto', 'Salinas', 70000063, 'Calle Arena 656', 3),
('Jessica', 'Sánchez', 70000064, 'Av. Cometa 767', 4),
('Ramiro', 'Torrealva', 70000065, 'Jr. Horizonte 878', 5),
('Marisol', 'Nieto', 70000066, 'Pasaje Universo 989', 6),
('Francisco', 'Galván', 70000067, 'Calle Galaxia 101', 7),
('Carla', 'Escobar', 70000068, 'Av. Nube 212', 8),
('Beto', 'Meneses', 70000069, 'Jr. Amanecer 323', 9),
('Romina', 'Quinteros', 70000070, 'Calle Luna 434', 10),
('Álvaro', 'Delgado', 70000071, 'Av. Brisa 545', 1),
('Lorena', 'Silva', 70000072, 'Pasaje Sol 656', 2),
('Arturo', 'Córdova', 70000073, 'Calle Estrella 767', 3),
('Clara', 'Villanueva', 70000074, 'Av. Tierra 878', 4),
('Benjamín', 'Guizado', 70000075, 'Jr. Río 989', 5),
('Tatiana', 'Palomino', 70000076, 'Pasaje Valle 101', 6),
('Samuel', 'Montenegro', 70000077, 'Calle Lago 212', 7),
('Nataly', 'Huamán', 70000078, 'Av. Mar 323', 8),
('César', 'Amaya', 70000079, 'Jr. Nube 434', 9),
('Mirtha', 'Vallejos', 70000080, 'Calle Sol 545', 10),
('Renato', 'Bravo', 70000081, 'Av. Viento 656', 1),
('Camila', 'Pizarro', 70000082, 'Pasaje Estrella 767', 2),
('Guillermo', 'Sanchez', 70000083, 'Calle Arena 878', 3),
('Janet', 'Mansilla', 70000084, 'Av. Cometa 989', 4),
('Agustín', 'Reyes', 70000085, 'Jr. Horizonte 101', 5),
('Melina', 'Carrillo', 70000086, 'Pasaje Universo 212', 6),
('Ángel', 'Mamani', 70000087, 'Calle Galaxia 323', 7),
('Tatiana', 'López', 70000088, 'Av. Nube 434', 8),
('Dilan', 'Sánchez', 70000089, 'Jr. Amanecer 545', 9),
('Micaela', 'Vidal', 70000090, 'Calle Luna 656', 10);

--select * from Vendedor

-------------------------------------------------------------------------------------------------------------------------------------
--Tabla Cliente

INSERT INTO Cliente (nombres, apellidos, correo, telefono, direccion, fecha_nacimiento, dni, ruc, id_distrito) VALUES
('Luis', 'Ramirez', 'luis.ramirez1@email.com', '912345678', 'Av. Siempre Viva 123', '1985-06-15', 71234567, 20100000001, 1),
('Ana', 'Fernandez', 'ana.fernandez2@email.com', '923456789', 'Calle Falsa 456', '1990-03-22', 71234568, 20100000002, 1),
('Carlos', 'Gomez', 'carlos.gomez3@email.com', '934567890', 'Jr. Los Olivos 789', '1978-11-05', 71234569, 20100000003, 1),
('María', 'Sánchez', 'maria.sanchez4@email.com', '945678901', 'Psj. Las Flores 321', '1995-08-12', 71234570, 20100000004, 2),
('Jorge', 'Lopez', 'jorge.lopez5@email.com', '956789012', 'Av. Arequipa 654', '1980-02-10', 71234571, 20100000005, 2),
('Lucía', 'Díaz', 'lucia.diaz6@email.com', '967890123', 'Calle Sol 987', '1998-09-27', 71234572, 20100000006, 2),
('Miguel', 'Castro', 'miguel.castro7@email.com', '978901234', 'Av. Primavera 135', '1987-04-01', 71234573, 20100000007, 3),
('Valeria', 'Paredes', 'valeria.paredes8@email.com', '989012345', 'Jr. Luna Pizarro 246', '1993-12-19', 71234574, 20100000008, 3),
('Raul', 'Hernandez', 'raul.hernandez9@email.com', '910123456', 'Calle Esperanza 876', '1982-07-30', 71234575, 20100000009, 3),
('Daniela', 'Morales', 'daniela.morales10@email.com', '911234567', 'Av. José Pardo 112', '1989-01-09', 71234576, 20100000010, 4),
('David', 'Martínez', 'david.martinez11@email.com', '922345678', 'Jr. Libertad 543', '1994-11-14', 71234577, 20100000011, 4),
('Sandra', 'Ortiz', 'sandra.ortiz12@email.com', '933456789', 'Calle Lomas 654', '1992-04-17', 71234578, 20100000012, 4),
('Juan', 'Ramírez', 'juan.ramirez13@email.com', '944567890', 'Av. Bolívar 987', '1986-02-28', 71234579, 20100000013, 5),
('María', 'González', 'maria.gonzalez14@email.com', '955678901', 'Calle San Martín 321', '1997-06-10', 71234580, 20100000014, 5),
('José', 'Ruiz', 'jose.ruiz15@email.com', '966789012', 'Psj. San Juan 543', '1980-10-03', 71234581, 20100000015, 5),
('Cecilia', 'Vargas', 'cecilia.vargas16@email.com', '977890123', 'Av. San Isidro 654', '1992-05-15', 71234582, 20100000016, 6),
('Felipe', 'Silva', 'felipe.silva17@email.com', '988901234', 'Jr. La Mar 789', '1985-12-25', 71234583, 20100000017, 6),
('Natalia', 'Córdoba', 'natalia.cordoba18@email.com', '999012345', 'Calle José Carlos Mariátegui 234', '1990-01-14', 71234584, 20100000018, 6),
('Raul', 'Pérez', 'raul.perez19@email.com', '910234567', 'Av. La Libertad 135', '1994-07-18', 71234585, 20100000019, 7),
('Laura', 'Jaramillo', 'laura.jaramillo20@email.com', '921345678', 'Calle Las Dalias 246', '1989-02-11', 71234586, 20100000020, 7),
('Eduardo', 'García', 'eduardo.garcia21@email.com', '932456789', 'Jr. Los Pinos 111', '1993-08-06', 71234587, 20100000021, 7),
('Carolina', 'Moreno', 'carolina.moreno22@email.com', '943567890', 'Av. El Sol 654', '1988-11-24', 71234588, 20100000022, 8),
('Carlos', 'Mendoza', 'carlos.mendoza23@email.com', '954678901', 'Calle San Francisco 987', '1991-04-09', 71234589, 20100000023, 8),
('Raquel', 'Jiménez', 'raquel.jimenez24@email.com', '965789012', 'Jr. La Paz 321', '1984-09-17', 71234590, 20100000024, 8),
('Santiago', 'Chavez', 'santiago.chavez25@email.com', '976890123', 'Av. Los Álamos 432', '1992-12-05', 71234591, 20100000025, 9),
('Paula', 'Serrano', 'paula.serrano26@email.com', '987901234', 'Calle Los Nogales 876', '1990-07-22', 71234592, 20100000026, 9),
('Javier', 'Guerra', 'javier.guerra27@email.com', '998012345', 'Av. El Sol 654', '1986-11-14', 71234593, 20100000027, 9),
('Tatiana', 'Ramírez', 'tatiana.ramirez28@email.com', '909123456', 'Jr. San José 321', '1995-05-04', 71234594, 20100000028, 10),
('Tomás', 'González', 'tomas.gonzalez29@email.com', '920234567', 'Calle del Sol 654', '1987-10-25', 71234595, 20100000029, 10),
('Andrea', 'Cruz', 'andrea.cruz30@email.com', '931345678', 'Psj. Los Andes 987', '1993-03-16', 71234596, 20100000030, 10),
('Pedro', 'Torres', 'pedro.torres31@email.com', '912345678', 'Av. La Esperanza 123', '1985-06-15', 71234597, 20100000031, 11),
('Sofía', 'Martínez', 'sofia.martinez32@email.com', '923456789', 'Calle de la Paz 456', '1990-03-22', 71234598, 20100000032, 11),
('Luis', 'Serrano', 'luis.serrano33@email.com', '934567890', 'Jr. Sol 789', '1978-11-05', 71234599, 20100000033, 11),
('Gabriela', 'Morales', 'gabriela.morales34@email.com', '945678901', 'Calle Echegaray 321', '1995-08-12', 71234600, 20100000034, 12),
('Ricardo', 'Ramírez', 'ricardo.ramirez35@email.com', '956789012', 'Av. San Juan 654', '1980-02-10', 71234601, 20100000035, 12),
('Eva', 'Cervantes', 'eva.cervantes36@email.com', '967890123', 'Calle Las Palmas 987', '1998-09-27', 71234602, 20100000036, 12),
('César', 'López', 'cesar.lopez37@email.com', '978901234', 'Av. Mariscal 135', '1987-04-01', 71234603, 20100000037, 13),
('Valeria', 'Castillo', 'valeria.castillo38@email.com', '989012345', 'Jr. Los Ángeles 246', '1993-12-19', 71234604, 20100000038, 13),
('Renato', 'Sánchez', 'renato.sanchez39@email.com', '910123456', 'Calle Oriente 876', '1982-07-30', 71234605, 20100000039, 13),
('Mónica', 'Cruz', 'monica.cruz40@email.com', '911234567', 'Av. Vía Expresa 112', '1989-01-09', 71234606, 20100000040, 14),
('Felipe', 'Vega', 'felipe.vega41@email.com', '922345678', 'Jr. Lirio 543', '1994-11-14', 71234607, 20100000041, 14),
('Carlos', 'González', 'carlos.gonzalez42@email.com', '933456789', 'Calle Los Milagros 654', '1992-04-17', 71234608, 20100000042, 14),
('Natalia', 'Valencia', 'natalia.valencia43@email.com', '944567890', 'Av. Cusco 987', '1986-02-28', 71234609, 20100000043, 15),
('Santiago', 'Linares', 'santiago.linares44@email.com', '955678901', 'Calle Vencedores 321', '1997-06-10', 71234610, 20100000044, 15),
('Jorge', 'Martín', 'jorge.martin45@email.com', '966789012', 'Psj. Libertad 543', '1980-10-03', 71234611, 20100000045, 15),
('Luis', 'Hernández', 'luis.hernandez46@email.com', '977890123', 'Av. Los Sauces 654', '1992-05-15', 71234612, 20100000046, 16),
('David', 'Mora', 'david.mora47@email.com', '988901234', 'Jr. La Colina 789', '1985-12-25', 71234613, 20100000047, 16),
('María', 'Chavez', 'maria.chavez48@email.com', '999012345', 'Calle Los Pinos 234', '1990-01-14', 71234614, 20100000048, 16),
('Ana', 'Ramírez', 'ana.ramirez49@email.com', '910234567', 'Av. Los Rosales 135', '1994-07-18', 71234615, 20100000049, 17),
('Adrián', 'Hidalgo', 'adrian.hidalgo50@email.com', '921345678', 'Calle el Bosque 246', '1989-02-11', 71234616, 20100000050, 17),
('Alma', 'Lozada', 'alma.lozada51@email.com', '932456789', 'Jr. Los Olivos 111', '1993-08-06', 71234617, 20100000051, 17),
('Carlos', 'Jiménez', 'carlos.jimenez52@email.com', '943567890', 'Av. Los Andes 654', '1988-11-24', 71234618, 20100000052, 18),
('Sofía', 'Navarro', 'sofia.navarro53@email.com', '954678901', 'Calle Los Álamos 987', '1991-04-09', 71234619, 20100000053, 18),
('Luis', 'Vargas', 'luis.vargas54@email.com', '965789012', 'Jr. San Martin 321', '1984-09-17', 71234620, 20100000054, 18),
('Gonzalo', 'Paredes', 'gonzalo.paredes55@email.com', '976890123', 'Av. Los Leones 432', '1992-12-05', 71234621, 20100000055, 19),
('Paola', 'López', 'paola.lopez56@email.com', '987901234', 'Calle Las Delicias 876', '1990-07-22', 71234622, 20100000056, 19),
('Manuel', 'Gutiérrez', 'manuel.gutierrez57@email.com', '998012345', 'Av. Libertador 654', '1986-11-14', 71234623, 20100000057, 19),
('Pedro', 'Vera', 'pedro.vera58@email.com', '909123456', 'Jr. Los Sauces 321', '1995-05-04', 71234624, 20100000058, 20),
('Paula', 'Garcia', 'paula.garcia59@email.com', '920234567', 'Calle Real 654', '1987-10-25', 71234625, 20100000059, 20),
('Pedro', 'Torres', 'pedro.torres60@email.com', '931345678', 'Psj. Los Ángeles 987', '1993-03-16', 71234626, 20100000060, 20);

--select * from Cliente

----------------------------------------------------------------------------------------------------------------

--tabla categoria
INSERT INTO Categoria (nombre_categoria) VALUES
('Bicicletas'),
('Squirt Cycling'),
('Accesorios'),
('Componentes'),
('Herramientas'),
('Vestimenta');

--select * from Categoria

-----------------------------------------------------------------------------------------------------------------

--tabla marca
INSERT INTO Marca (nombre_marca) VALUES
('Specialized'),
('Trek'),
('Giant'),
('Monark'),
('Kendall');

--select * from Marca

-------------------------------------------------------------------------------------------------------------------

--tabla modelo
INSERT INTO Modelo (nombre_modelo, año_modelo) VALUES
('Rockhopper', 2024),            -- Bicicleta Specialized
('Marlin 5', 2024),               -- Bicicleta Trek
('Talon 3', 2023),                -- Bicicleta Giant
('Urban Classic', 2023),          -- Bicicleta Monark
('MTB Kendall Pro', 2024),        -- Bicicleta Kendall
('Serie Lubricantes Squirt', 2024), -- Lubricantes y productos Squirt
('Serie Casco AirBreaker', 2023),   -- Casco Abus
('Serie Deore XT', 2024),           -- Componentes Shimano
('Serie Accesorios Mini Pro', 2024), -- Accesorios varios
('Serie Reflectante UltraSafe', 2023), -- Chaleco reflectante
('Serie Herramientas 15 en 1', 2024);  -- Kit herramienta

--select * from modelo

--------------------------------------------------------------------------------------------------------------------
--Tabla Producto

INSERT INTO Producto (nombre, descripcion, precio_actual, garantia_meses, id_categoria, id_marca, id_modelo) VALUES
('Bicicleta eléctrica urbana', 'Bicicleta eléctrica urbana ideal para la ciudad', 3899.90, 12, 1, 4, 4),
('Bicicleta plegable compacta', 'Bicicleta plegable ideal para transporte y almacenaje fácil', 2599.50, 12, 1, 4, 4),
('Tornillos de titanio para bicicleta', 'Set de tornillos de alta resistencia', 179.90, 6, 4, 5, 8),
('Porta celulares para bicicleta', 'Soporte para celular en el manillar', 89.90, 6, 3, 2, 9),
('Polo de ciclismo manga larga', 'Polo deportivo de ciclismo manga larga para frío', 129.90, 6, 6, 5, 10),
('Chaleco cortavientos reflectante', 'Chaleco para ciclismo con alta visibilidad', 149.90, 6, 6, 5, 10),
('Guantes de ciclismo antideslizantes', 'Guantes de ciclismo con almohadilla y agarre seguro', 79.90, 6, 5, 5, 9),
('Tomatodo isotérmico 750ml', 'Tomatodo isotérmico de alta capacidad', 89.90, 6, 3, 2, 9),
('Desarmador multifunción Pro', 'Desarmador especial de alta calidad para bicicletas', 69.90, 5, 4, 3, 11),
('Asiento ergonómico premium', 'Asiento ergonómico con gel para mayor comodidad', 189.90, 12, 4, 5, 8),
('Pedales de aluminio reforzados', 'Pedales resistentes de aluminio antideslizantes', 99.90, 12, 4, 2, 8),
('Cadena de acero templado', 'Cadena reforzada para mayor durabilidad en rutas extremas', 119.90, 12, 4, 2, 8),
('Llanta de alta resistencia', 'Llanta de repuesto con diseño anti-pinchazos', 249.90, 12, 4, 5, 5),
('Kit de luces LED ultra brillantes', 'Juego de luces LED delanteras y traseras para bicicleta', 129.90, 6,3, 2, 9),
('Casco aerodinámico profesional', 'Casco de ciclismo liviano y resistente', 299.90, 12, 3, 2, 7),
('Bombín de alta presión portátil', 'Bombín compacto de alta presión', 89.90, 6,3,3, 9),
('Multiherramienta de ciclismo 22 en 1', 'Herramienta compacta para ajustes y reparaciones', 149.90,6, 5, 3, 11),
('Porta-caramañola de aluminio', 'Porta-caramañola ligero y resistente', 59.90, 6,3, 2, 9),
('Computadora de ciclismo GPS', 'Odómetro avanzado con GPS integrado', 599.90, 12, 3, 2, 9),
('Ropa interior acolchada para ciclista', 'Ropa interior con acolchado para largas rutas', 119.90, 6,6, 5, 10),
('Rodillera de protección para ciclismo', 'Rodillera para evitar lesiones en caídas', 99.90, 6,6, 5, 10),
('Gafas polarizadas de ciclismo', 'Gafas de ciclismo con protección UV', 199.90, 6,6,5, 9),
('Freno de disco hidráulico profesional', 'Sistema de freno de disco hidráulico', 449.90, 12, 4, 5, 8),
('Lubricante premium para cadena', 'Lubricante de alta eficiencia para cadenas', 59.90, 6,2, 2, 6),
('Cubierta antipinchazos reforzada', 'Cubierta especial anti pinchazos', 299.90, 12, 4, 5, 5),
('Guardabarros de ciclismo', 'Guardabarros delantero y trasero desmontable', 129.90, 6,3, 2, 9),
('Alforjas impermeables', 'Bolsas de carga resistentes al agua', 349.90, 6,4, 2, 9),
('Mochila de hidratación 2L', 'Mochila para ciclismo con depósito de agua', 249.90, 6,3, 5, 9),
('Pastillas de freno semi-metálicas', 'Juego de pastillas para freno hidráulico', 89.90, 12, 4, 5, 8),
('Tija de sillín telescópica', 'Tija de sillín ajustable para MTB', 499.90, 12, 4, 5, 8),
('Portabicicletas de techo para auto', 'Portabicicletas compatible con racks de auto', 899.90, 12, 3, 2, 9),
('Cinta de manillar de microfibra', 'Cinta de manillar acolchada para confort', 99.90, 6,3, 2, 9),
('Calzas térmicas de ciclismo', 'Calzas largas para invierno', 159.90, 6,4, 5, 10),
('Medias de ciclismo transpirables', 'Medias especiales para ciclismo de alto rendimiento', 49.90, 6, 6,5, 10),
('Casco infantil de ciclismo', 'Casco de protección para niños', 199.90, 12, 3, 2, 7),
('Polo de ciclismo manga corta', 'Polo de ciclismo liviano y transpirable', 99.90, 6,6, 5, 10),
('Guantes de invierno para ciclismo', 'Guantes impermeables y térmicos', 139.90, 6,6, 5, 9),
('Luz trasera LED potente', 'Luz trasera con modos intermitentes', 89.90, 6, 3,2, 9),
('Herramienta corta cadenas', 'Herramienta especial para corte de cadenas', 89.90, 5,5, 3, 11),
('Extractor de bielas profesional', 'Extractor para mantenimiento de bielas', 109.90, 5,5, 3, 11),
('Pedales automáticos MTB', 'Pedales automáticos para MTB', 329.90, 12, 4, 5, 8),
('Cadena de 11 velocidades', 'Cadena de alta gama para transmisiones de 11v', 199.90, 12, 4, 5, 8),
('Llanta de gravel reforzada', 'Llanta especial para gravel', 379.90, 12, 4, 5, 5),
('Lubricante seco para cadena', 'Lubricante seco para rutas secas', 54.90, 6,2, 2, 6),
('Soporte de mantenimiento plegable', 'Soporte para reparación de bicicletas', 649.90, 12, 5, 3, 11),
('Bicicleta eléctrica urbana', 'Bicicleta eléctrica urbana de alta eficiencia.', 4500.00, 12, 1, 4, 4),
('Polo de ciclismo de verano', 'Polo transpirable especial para ciclismo en climas cálidos.', 85.00, 6, 6, 5, 9),
('Botella térmica profesional', 'Botella térmica de acero inoxidable para largas rutas.', 95.00, 12, 3, 2, 9),
('Bicicleta de paseo vintage', 'Bicicleta de paseo con diseño clásico vintage.', 1600.00, 12, 1, 4, 4),
('Polo técnico manga larga', 'Polo técnico de manga larga para protección solar.', 95.00, 6,6, 5, 9),
('Guantes impermeables', 'Guantes resistentes al agua para ciclismo en lluvia.', 90.00, 6,6, 5, 9),
('Bombín de pie reforzado', 'Bombín de pie de alta presión para bicicletas.', 120.00, 12, 5, 3, 11),
('Gafas polarizadas para ciclismo', 'Gafas polarizadas de alta protección UV.', 150.00, 12, 3, 2, 9),
('Freno de disco mecánico', 'Sistema de freno de disco mecánico de alto rendimiento.', 180.00, 12, 4, 5, 8),
('Cera lubricante para cadena', 'Cera especial para lubricación de cadenas.', 45.00, 6, 2, 1, 6),
('Luz trasera de alta intensidad', 'Luz LED trasera de alta visibilidad.', 75.00, 12, 3, 2, 9),
('Rodillera profesional acolchada', 'Rodillera ergonómica acolchada para ciclismo.', 110.00, 12, 6, 5, 10),
('Cadena antirrobo reforzada', 'Cadena de seguridad reforzada para bicicletas.', 135.00, 12, 3, 2, 9),
('Tija telescópica hidráulica', 'Tija de sillín ajustable hidráulicamente.', 600.00, 12, 4, 5, 8),
('Set de parches autoadhesivos', 'Set de parches para reparar pinchazos.', 45.00, 6,5, 5, 9),
('Guantes acolchados anti-impacto', 'Guantes de ciclismo anti-impacto.', 105.00, 6,6, 5, 9),
('Luz frontal con sensor', 'Luz frontal inteligente con sensor de luminosidad.', 135.00, 12, 3, 2, 9),
('Casco MTB con visera', 'Casco de ciclismo MTB con visera ajustable.', 290.00, 12, 3, 2, 7),
('Chaleco impermeable reflectante', 'Chaleco reflectante impermeable para ciclismo nocturno.', 150.00, 12, 6, 5, 10),
('Freno hidráulico de 4 pistones', 'Sistema de freno de disco hidráulico avanzado.', 580.00, 12, 4, 5, 8),
('Bicicleta', 'Bicicleta de alta resistencia ideal para terrenos difíciles.', 2800.00, 12, 1, 4, 1),
('Polo', 'Polo deportivo de secado rápido para ciclismo.', 90.00, 6, 6, 2, 9),
('Tomatodo', 'Tomatodo térmico para hidratación durante el deporte.', 45.00, 6, 3, 2, 9),
('Bicicleta de montaña', 'Bicicleta de montaña con suspensión delantera.', 3200.00, 12, 1, 4, 1),
('Bicicleta de ruta', 'Bicicleta de ruta ultraligera para competencias.', 4100.00, 12, 1, 4, 2),
('Polo deportivo', 'Polo ligero y transpirable para ciclistas.', 100.00, 6, 6, 2, 9),
('Casaca cortavientos', 'Casaca resistente al viento y ligera para ciclismo.', 200.00, 12, 6, 2, 9),
('Guantes de ciclismo', 'Guantes con acolchado para trayectos largos.', 85.00, 6, 3, 5, 9),
('Tomatodo térmico', 'Tomatodo térmico para mantener tus bebidas frescas.', 50.00, 6, 3, 2, 9),
('Desarmador especial para bicicletas', 'Desarmador multifunción para reparaciones rápidas.', 70.00, 12, 5, 1, 11),
('Asiento ergonómico', 'Asiento ergonómico que mejora la comodidad en viajes largos.', 250.00, 12, 4, 5, 4),
('Pedales antideslizantes', 'Pedales antideslizantes para mayor seguridad.', 180.00, 12, 4, 5, 4),
('Cadena reforzada', 'Cadena de alta resistencia para bicicletas de montaña.', 150.00, 12, 4, 5, 8),
('Llantas de repuesto', 'Llantas reforzadas para todo tipo de terrenos.', 300.00, 12, 4, 5, 5),
('Kit de luces LED', 'Luces LED de alta visibilidad para seguridad nocturna.', 90.00, 6, 3, 2, 9),
('Casco de ciclismo', 'Casco liviano y aerodinámico para ciclistas.', 350.00, 12, 6, 2, 7),
('Bombín portátil', 'Bombín portátil compacto para inflar neumáticos.', 60.00, 6, 3, 2, 9),
('Multiherramienta para bicicleta', 'Herramienta 15 en 1 para mantenimiento de bicicletas.', 110.00, 12, 5, 1, 11),
('Porta-caramañola', 'Soporte resistente para caramañola.', 40.00, 6, 4,2, 9),
('Computadora de bicicleta (odómetro)', 'Medidor digital de distancia, velocidad y tiempo.', 250.00, 12, 3, 2, 9),
('Ropa interior acolchada', 'Ropa interior acolchada especial para largas distancias.', 120.00, 6, 6, 2, 9),
('Rodillera de protección', 'Rodilleras ligeras y resistentes para protección.', 130.00, 6, 6, 2, 9),
('Gafas de ciclismo', 'Gafas con protección UV y antiempañante.', 140.00, 6, 6, 2, 9),
('Freno de disco hidráulico', 'Sistema de freno de disco de alto rendimiento.', 400.00, 12, 4, 5, 8),
('Lubricante para cadena', 'Lubricante especial para mantener la cadena en óptimas condiciones.', 35.00, 6,2, 2, 6),
('Cubierta antipinchazos', 'Cubierta reforzada para evitar pinchazos.', 280.00, 12, 4, 5, 5),
('Guardabarros desmontable', 'Guardabarros práctico y desmontable.', 75.00, 6, 3, 2, 9),
('Alforjas para bicicleta', 'Bolsas resistentes para transportar objetos en bicicleta.', 180.00, 12, 3, 2, 9),
('Mochila de hidratación', 'Mochila ligera con depósito de agua incorporado.', 210.00, 12, 3, 2, 9),
('Pastillas de freno', 'Pastillas de freno de alta durabilidad.', 90.00, 12, 4, 5, 8),
('Tija de sillín ajustable', 'Sillín ajustable para optimizar la postura.', 320.00, 12, 4, 5, 8),
('Porta-bicicletas para auto', 'Sistema de transporte para bicicletas en vehículos.', 500.00, 12, 3, 2, 9),
('Cinta de manillar', 'Cinta ergonómica para manillares de bicicletas.', 70.00, 6, 3, 2, 9),
('Bicicleta eléctrica Gayeric', 'Bicicleta eléctrica', 4899.90, 12, 1, 5, 4),
('Bicicleta Montañera', 'Bicicleta plegable ideal para transporte y almacenaje fácil', 4599.50, 12, 1, 4, 4);

--select * from Producto

--------------------------------------------------------------------------------------------------------------

--Tabla Proveedor
INSERT INTO Proveedor (razon_social, ruc, direccion, correo, telefono) VALUES
('Rimac Bikes', '20608942345', 'Av. Pardo y Aliaga 600, San Isidro', 'contacto@rimacbikes.com', '987654321'),
('Distribuidora Bici Peru', '20456798765', 'Av. Comandante Espinar 453, Miraflores', 'ventas@biciperu.com', '965432109'),
('Riders Peru', '20234567890', 'Av. Pescadores 1025, San Borja', 'info@ridersperu.com', '981234567'),
('Trek Internacional', '20123456789', 'Av. Javier Prado 3450, San Isidro', 'contacto@trekperu.com', '954321678'),
('Giant', '20567812345', 'Av. 28 de Julio 789, Miraflores', 'atencion@giantperu.com', '993456789'),
('BMC empresa suiza', '20654321098', 'Av. Velasco Astete 1320, Surco', 'ventas@bmcsuiza.com', '972345678'),
('Bikes peruanos', '20876543210', 'Calle Los Alamos 450, San Miguel', 'soporte@bikesperuanos.com', '982345678'),
('Ciclovia', '20987654321', 'Av. Benavides 1450, Surco', 'informes@ciclovia.com', '966543210'),
('Bicicross', '20765432109', 'Av. Santa Cruz 1285, San Isidro', 'ventas@bicicross.com', '983210987'),
('Ciclos Kroos', '20345678901', 'Calle San Martin 220, San Borja', 'contacto@cicloskroos.com', '979876543');

--select * from Proveedor

----------------------------------------------------------------------------------------------------------------

--Tabla Producto_Proveedor

INSERT INTO Producto_Proveedor (id_producto, id_proveedor, precio_compra, fecha_registro) VALUES
(1, 1, 3399.90, '2025-03-01'),
(2, 2, 2099.50, '2025-03-02'),
(3, 3, 139.90, '2025-03-03'),
(4, 4, 59.90, '2025-03-04'),
(5, 5, 89.90, '2025-03-05'),
(6, 6, 119.90, '2025-03-06'),
(7, 7, 49.90, '2025-03-07'),
(8, 8, 69.90, '2025-03-08'),
(9, 9, 39.90, '2025-03-09'),
(10, 10, 159.90, '2025-03-10'),
(11, 1, 59.90, '2025-03-11'),
(12, 2, 79.90, '2025-03-12'),
(13, 3, 199.90, '2025-03-13'),
(14, 4, 79.90, '2025-03-14'),
(15, 5, 179.90, '2025-03-15'),
(16, 6, 59.90, '2025-03-16'),
(17, 7, 99.90, '2025-03-17'),
(18, 8, 39.90, '2025-03-18'),
(19, 9, 549.90, '2025-03-19'),
(20, 10, 99.90, '2025-03-20'),
(21, 1, 79.90, '2025-03-21'),
(22, 2, 149.90, '2025-03-22'),
(23, 3, 399.90, '2025-03-23'),
(24, 4, 39.90, '2025-03-24'),
(25, 5, 239.90, '2025-03-25'),
(26, 6, 79.90, '2025-03-26'),
(27, 7, 289.90, '2025-03-27'),
(28, 8, 179.90, '2025-03-28'),
(29, 9, 59.90, '2025-03-29'),
(30, 10, 429.90, '2025-03-30'),
(31, 1, 799.90, '2025-03-31'),
(32, 2, 59.90, '2025-03-01'),
(33, 3, 139.90, '2025-03-02'),
(34, 4, 29.90, '2025-03-03'),
(35, 5, 159.90, '2025-03-04'),
(36, 6, 79.90, '2025-03-05'),
(37, 7, 109.90, '2025-03-06'),
(38, 8, 59.90, '2025-03-07'),
(39, 9, 59.90, '2025-03-08'),
(40, 10, 89.90, '2025-03-09'),
(41, 1, 229.90, '2025-03-10'),
(42, 2, 149.90, '2025-03-11'),
(43, 3, 349.90, '2025-03-12'),
(44, 4, 24.90, '2025-03-13'),
(45, 5, 539.90, '2025-03-14'),
(46, 6, 3999.90, '2025-03-15'),
(47, 7, 45.00, '2025-03-16'),
(48, 8, 55.00, '2025-03-17'),
(49, 9, 1300.00, '2025-03-18'),
(50, 10, 85.00, '2025-03-19'),
(51, 1, 60.00, '2025-03-20'),
(52, 2, 95.00, '2025-03-21'),
(53, 3, 120.00, '2025-03-22'),
(54, 4, 135.00, '2025-03-23'),
(55, 5, 40.00, '2025-03-24'),
(56, 6, 65.00, '2025-03-25'),
(57, 7, 95.00, '2025-03-26'),
(58, 8, 120.00, '2025-03-27'),
(59, 9, 510.00, '2025-03-28'),
(60, 10, 35.00, '2025-03-29'),
(61, 1, 95.00, '2025-03-30'),
(62, 2, 115.00, '2025-03-31'),
(63, 3, 125.00, '2025-03-01'),
(64, 4, 55.00, '2025-03-02'),
(65, 5, 490.00, '2025-03-03'),
(66, 6, 2300.00, '2025-03-04'),
(67, 7, 65.00, '2025-03-05'),
(68, 8, 40.00, '2025-03-06'),
(69, 9, 2900.00, '2025-03-07'),
(70, 10, 3500.00, '2025-03-08'),
(71, 1, 90.00, '2025-03-09'),
(72, 2, 160.00, '2025-03-10'),
(73, 3, 75.00, '2025-03-11'),
(74, 4, 40.00, '2025-03-12'),
(75, 5, 55.00, '2025-03-13'),
(76, 6, 220.00, '2025-03-14'),
(77, 7, 140.00, '2025-03-15'),
(78, 8, 115.00, '2025-03-16'),
(79, 9, 250.00, '2025-03-17'),
(80, 10, 80.00, '2025-03-18'),
(81, 1, 300.00, '2025-03-19'),
(82, 2, 55.00, '2025-03-20'),
(83, 3, 80.00, '2025-03-21'),
(84, 4, 25.00, '2025-03-22'),
(85, 5, 200.00, '2025-03-23'),
(86, 6, 90.00, '2025-03-24'),
(87, 7, 110.00, '2025-03-25'),
(88, 8, 120.00, '2025-03-26'),
(89, 9, 300.00, '2025-03-27'),
(90, 10, 25.00, '2025-03-28'),
(91, 1, 270.00, '2025-03-29'),
(92, 6, 60.00, '2025-03-31'),
(93, 4, 150.00, '2025-04-10'),
(94, 2, 180.00, '2025-04-04'),
(95, 7, 60.00, '2025-04-01'),
(96, 5, 270.00, '2025-04-11'),
(97, 10, 400.00, '2025-04-04'),
(98, 3, 50.00,'2025-04-21'),
(99,2, 4200.00, '2025-04-10'),
(100,1, 3890.00, '2025-03-22');

select * from Producto_Proveedor

-------------------------------------------------------------------

--tabla Medio_Pago
INSERT INTO Medio_Pago (descripcion) VALUES
('Efectivo'),
('Tarjeta de Crédito'),
('Tarjeta de Débito'),
('Yape'),
('Plin');

--select * from Medio_Pago

-----------------------------------------------------------------------

--tabla Tipo_Tarjeta

INSERT INTO Tipo_Tarjeta (tipo, id_medio_pago) VALUES
(null, 1),
('Visa', 2),
('Mastercard', 3),
('Visa', 2),
('Mastercard', 3),
(null, 4),
(null, 5);

--select * from Tipo_Tarjeta

--------------------------------------------------------------------------

--Tabla Tipo_Documento 
INSERT INTO Tipo_Documento (descripcion) VALUES
('Boleta'),
('Factura');

--SELECT * FROM Tipo_Documento

----------------------------------------------------

--Tabla Tipo_Entrega
INSERT INTO Tipo_Entrega (tipo_entrega) VALUES
('En Tienda'),
('A Domicilio');

--select * from Tipo_Entrega

----------------------------------------------------

--tabla Venta
INSERT INTO Venta (fecha, id_tipo_documento, serie_documento, numero_documento, id_cliente, id_vendedor, id_tipo_entrega, id_medio_pago) VALUES
('2025-06-01', 1, 'A001', '000001', 1, 1, 1, 1),
('2025-06-02', 2, 'B002', 'A00001', 2, 2, 1, 2),
('2025-06-03', 1, 'A001', '000002', 3, 3, 1, 3),
('2025-06-04', 2, 'B002', 'A00002', 4, 4, 1, 4),
('2025-06-05', 1, 'A001', '000003', 5, 5, 1, 5),
('2025-06-06', 2, 'B002', 'A00003', 6, 6, 1, 1),
('2025-06-07', 1, 'A001', '000004', 7, 7, 1, 2),
('2025-06-08', 2, 'B002', 'A00004', 8, 8, 1, 3),
('2025-06-09', 1, 'A001', '000005', 9, 9, 1, 4),
('2025-06-10', 2, 'B002', 'A00005', 10, 10, 1, 5),
('2025-06-11', 1, 'A001', '000006', 11, 11, 1, 1),
('2025-06-12', 2, 'B002', 'A00006', 12, 12, 1, 2),
('2025-06-13', 1, 'A001', '000007', 13, 13, 1, 3),
('2025-06-14', 2, 'B002', 'A00007', 14, 14, 1, 4),
('2025-06-15', 1, 'A001', '000008', 15, 15, 1, 5),
('2025-06-16', 2, 'B002', 'A00008', 16, 16, 1, 1),
('2025-06-17', 1, 'A001', '000009', 17, 17, 1, 2),
('2025-06-18', 2, 'B002', 'A00009', 18, 18, 1, 3),
('2025-06-19', 1, 'A001', '000010', 19, 19, 1, 4),
('2025-06-20', 2, 'B002', 'A00010', 20, 20, 1, 5),
('2025-06-21', 1, 'A001', '000011', 21, 21, 1, 1),
('2025-06-22', 2, 'B002', 'A00011', 22, 22, 1, 2),
('2025-06-23', 1, 'A001', '000012', 23, 23, 1, 3),
('2025-06-24', 2, 'B002', 'A00012', 24, 24, 1, 4),
('2025-06-25', 1, 'A001', '000013', 25, 25, 1, 5),
('2025-06-26', 2, 'B002', 'A00013', 26, 26, 1, 1),
('2025-06-27', 1, 'A001', '000014', 27, 27, 1, 2),
('2025-06-28', 2, 'B002', 'A00014', 28, 28, 1, 3),
('2025-06-29', 1, 'A001', '000015', 29, 29, 1, 4),
('2025-06-30', 2, 'B002', 'A00015', 30, 30, 1, 5),
('2025-07-01', 1, 'A001', '000016', 31, 31, 1, 1),
('2025-07-02', 2, 'B002', 'A00016', 32, 32, 1, 2),
('2025-07-03', 1, 'A001', '000017', 33, 33, 1, 3),
('2025-07-04', 2, 'B002', 'A00017', 34, 34, 1, 4),
('2025-07-05', 1, 'A001', '000018', 35, 35, 1, 5),
('2025-07-06', 2, 'B002', 'A00018', 36, 36, 1, 1),
('2025-07-07', 1, 'A001', '000019', 37, 37, 1, 2),
('2025-07-08', 2, 'B002', 'A00019', 38, 38, 1, 3),
('2025-07-09', 1, 'A001', '000020', 39, 39, 1, 4),
('2025-07-10', 2, 'B002', 'A00020', 40, 40, 1, 5),
('2025-07-11', 1, 'A001', '000021', 41, 41, 1, 1),
('2025-07-12', 2, 'B002', 'A00021', 42, 42, 1, 2),
('2025-07-13', 1, 'A001', '000022', 43, 43, 1, 3),
('2025-07-14', 2, 'B002', 'A00022', 44, 44, 1, 4),
('2025-07-15', 1, 'A001', '000023', 45, 45, 1, 5),
('2025-07-16', 2, 'B002', 'A00023', 46, 46, 1, 1),
('2025-07-17', 1, 'A001', '000024', 47, 47, 1, 2),
('2025-07-18', 2, 'B002', 'A00024', 48, 48, 1, 3),
('2025-07-19', 1, 'A001', '000025', 49, 49, 1, 4),
('2025-07-20', 2, 'B002', 'A00025', 50, 50, 1, 5),
('2025-07-21', 1, 'A001', '000026', 51, 51, 1, 1),
('2025-07-22', 2, 'B002', 'A00026', 52, 52, 1, 2),
('2025-07-23', 1, 'A001', '000027', 53, 53, 1, 3),
('2025-07-24', 2, 'B002', 'A00027', 54, 54, 1, 4),
('2025-07-25', 1, 'A001', '000028', 55, 55, 1, 5),
('2025-07-26', 2, 'B002', 'A00028', 56, 56, 1, 1),
('2025-07-27', 1, 'A001', '000029', 57, 57, 1, 2),
('2025-07-28', 2, 'B002', 'A00029', 58, 58, 1, 3),
('2025-07-29', 1, 'A001', '000030', 59, 59, 1, 4),
('2025-07-30', 2, 'B002', 'A00030', 60, 60, 1, 5);

--select * from Venta;

--------------------------------------------------------------------------------------
--Detalle_Venta

INSERT INTO Detalle_Venta (id_venta, id_producto, cantidad, precio_unitario) VALUES
(1, 2, 1, 2599.50),
(2, 4, 2, 89.90),
(3, 6, 1, 149.90),
(4, 8, 3, 89.90),
(5, 10, 2, 189.90),
(6, 12, 1, 119.90),
(7, 14, 3, 129.90),
(8, 16, 1, 89.90),
(9, 18, 2, 59.90),
(10, 20, 1, 119.90),
(11, 22, 3, 199.90),
(12, 24, 2, 59.90),
(13, 26, 1, 129.90),
(14, 28, 3, 249.90),
(15, 30, 2, 499.90),
(16, 32, 1, 99.90),
(17, 34, 2, 49.90),
(18, 36, 3, 99.90),
(19, 38, 2, 89.90),
(20, 40, 1, 109.90),
(21, 42, 2, 199.90),
(22, 44, 3, 54.90),
(23, 46, 2, 4500.00),
(24, 48, 1, 95.00),
(25, 50, 3, 95.00),
(26, 52, 2, 120.00),
(27, 54, 1, 180.00),
(28, 56, 3, 75.00),
(29, 58, 2, 135.00),
(30, 60, 1, 45.00),
(31, 62, 3, 135.00),
(32, 64, 2, 150.00),
(33, 66, 1, 2800.00),
(34, 68, 2, 45.00),
(35, 70, 1, 4100.00),
(36, 72, 3, 200.00),
(37, 74, 2, 50.00),
(38, 76, 1, 250.00),
(39, 78, 3, 150.00),
(40, 80, 2, 90.00),
(41, 82, 1, 60.00),
(42, 84, 2, 40.00),
(43, 86, 3, 120.00),
(44, 88, 2, 140.00),
(45, 90, 1, 35.00),
(46, 92, 3, 75.00),
(47, 94, 2, 210.00),
(48, 96, 1, 320.00),
(49, 98, 2, 70.00),
(50, 1, 3, 3899.90),
(51, 3, 1, 179.90),
(52, 5, 2, 129.90),
(53, 7, 1, 79.90),
(54, 9, 3, 69.90),
(55, 11, 2, 99.90),
(56, 13, 1, 249.90),
(57, 15, 3, 299.90),
(58, 17, 2, 149.90),
(59, 19, 1, 599.90),
(60, 21, 3, 99.90);

--select * from Detalle_Venta

-------------------------------------------------------------------

--tabla inventario
INSERT INTO Inventario (id_producto, id_tienda, stock) VALUES
(1, 1, 12),
(2, 2, 12),
(3, 3, 12),
(4, 4, 12),
(5, 5, 12),
(6, 6, 12),
(7, 7, 12),
(8, 8, 12),
(9, 9, 12),
(10, 10, 12),
(11, 11, 12),
(12, 12, 12),
(13, 13, 12),
(14, 14, 12),
(15, 15, 12),
(16, 16, 12),
(17, 17, 12),
(18, 18, 12),
(19, 19, 12),
(20, 20, 12),
(21, 21, 12),
(22, 22, 12),
(23, 23, 12),
(24, 24, 12),
(25, 25, 12),
(26, 26, 12),
(27, 27, 12),
(28, 28, 12),
(29, 29, 12),
(30, 30, 12),
(31, 1, 12),
(32, 2, 12),
(33, 3, 12),
(34, 4, 12),
(35, 5, 12),
(36, 6, 12),
(37, 7, 12),
(38, 8, 12),
(39, 9, 12),
(40, 10, 12),
(41, 11, 12),
(42, 12, 12),
(43, 13, 12),
(44, 14, 12),
(45, 15, 12),
(46, 16, 12),
(47, 17, 12),
(48, 18, 12),
(49, 19, 12),
(50, 20, 12),
(51, 21, 12),
(52, 22, 12),
(53, 23, 12),
(54, 24, 12),
(55, 25, 12),
(56, 26, 12),
(57, 27, 12),
(58, 28, 12),
(59, 29, 12),
(60, 30, 12),
(61, 1, 12),
(62, 2, 12),
(63, 3, 12),
(64, 4, 12),
(65, 5, 12),
(66, 6, 12),
(67, 7, 12),
(68, 8, 12),
(69, 9, 12),
(70, 10, 12),
(71, 11, 12),
(72, 12, 12),
(73, 13, 12),
(74, 14, 12),
(75, 15, 12),
(76, 16, 12),
(77, 17, 12),
(78, 18, 12),
(79, 19, 12),
(80, 20, 12),
(81, 21, 12),
(82, 22, 12),
(83, 23, 12),
(84, 24, 12),
(85, 25, 12),
(86, 26, 12),
(87, 27, 12),
(88, 28, 12),
(89, 29, 12),
(90, 30, 12),
(91, 1, 12),
(92, 2, 12),
(93, 3, 12),
(94, 4, 12),
(95, 5, 12),
(96, 6, 12),
(97, 7, 12),
(98, 8, 12),
(99, 9, 12),
(100, 10, 12);

--select * from Inventario

------------------------------------------------------------------------------------
------------------------------------------------------------------------------------


--guardado hasta allí
