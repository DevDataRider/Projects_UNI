-- Crear base de datos de staging
CREATE DATABASE BiciMundo_Stage;
GO

USE BiciMundo_Stage;
GO

-- Zona Stage
CREATE TABLE Stage_Zona (
    id_zona INT,
    nombre_zona VARCHAR(100),
    id_distrito INT
);
GO

-- Distrito Stage
CREATE TABLE Stage_Distrito (
    id_distrito INT,
    nombre_distrito VARCHAR(100)
);
GO

-- Tienda Stage
CREATE TABLE Stage_Tienda (
    id_tienda INT,
    nombre_tienda VARCHAR(100),
    direccion VARCHAR(150),
    id_distrito INT
);
GO

-- Marca Stage
CREATE TABLE Stage_Marca (
    id_marca INT,
    nombre_marca VARCHAR(100)
);
GO
--sss
-- Modelo Stage
CREATE TABLE Stage_Modelo (
    id_modelo INT,
    nombre_modelo VARCHAR(100),
    año_modelo INT
);
GO

-- Categoria Stage
CREATE TABLE Stage_Categoria (
    id_categoria INT,
    nombre_categoria VARCHAR(100)
);
GO

-- Producto Stage
CREATE TABLE Stage_Producto (
    id_producto INT,
    nombre VARCHAR(100),
    descripcion TEXT,
    precio_actual DECIMAL(10, 2),
    garantia_meses INT,
    id_categoria INT,
    id_marca INT,
    id_modelo INT
);
GO

-- Inventario Stage
CREATE TABLE Stage_Inventario (
    id_inventario INT,
    id_producto INT,
    id_tienda INT,
    stock INT
);
GO

-- Cliente Stage
CREATE TABLE Stage_Cliente (
    id_cliente INT,
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
GO

-- Vendedor Stage
CREATE TABLE Stage_Vendedor (
    id_vendedor INT,
    nombres VARCHAR(100),
    apellidos VARCHAR(100),
    dni VARCHAR(15),
    domicilio VARCHAR(150),
    id_tienda INT
);
GO

-- Tipo_Entrega Stage
CREATE TABLE Stage_Tipo_Entrega (
    id_tipo_entrega INT,
    tipo_entrega VARCHAR(100)
);
GO

-- Medio_Pago Stage
CREATE TABLE Stage_Medio_Pago (
    id_medio_pago INT,
    descripcion VARCHAR(50)
);
GO

-- Tipo_Tarjeta Stage
CREATE TABLE Stage_Tipo_Tarjeta (
    id_tipo_tarjeta INT,
    tipo VARCHAR(50),
    id_medio_pago INT
);
GO

-- Tipo_Documento Stage
CREATE TABLE Stage_Tipo_Documento (
    id_tipo_documento INT,
    descripcion VARCHAR(50)
);
GO

-- Venta Stage
CREATE TABLE Stage_Venta (
    id_venta INT,
    fecha DATE,
    id_tipo_documento INT,
    serie_documento VARCHAR(10),
    numero_documento VARCHAR(20),
    id_cliente INT,
    id_vendedor INT,
    id_tipo_entrega INT,
    id_medio_pago INT
);
GO

-- Detalle_Venta Stage
CREATE TABLE Stage_Detalle_Venta (
    id_detalle INT,
    id_venta INT,
    id_producto INT,
    cantidad INT,
    precio_unitario DECIMAL(10, 2)
);
GO

-- Proveedor Stage
CREATE TABLE Stage_Proveedor (
    id_proveedor INT,
    razon_social VARCHAR(100),
    ruc VARCHAR(15),
    direccion VARCHAR(150),
    correo VARCHAR(100),
    telefono VARCHAR(15)
);
GO

-- Producto_Proveedor Stage
CREATE TABLE Stage_Producto_Proveedor (
    id_producto_proveedor INT,
    id_producto INT,
    id_proveedor INT,
    precio_compra DECIMAL(10, 2),
    fecha_registro DATE
);
GO

-- INSERTS desde la base original BiciMundo
INSERT INTO Stage_Zona SELECT * FROM BiciMundo.dbo.Zona;
INSERT INTO Stage_Distrito SELECT * FROM BiciMundo.dbo.Distrito;
INSERT INTO Stage_Tienda SELECT * FROM BiciMundo.dbo.Tienda;
INSERT INTO Stage_Marca SELECT * FROM BiciMundo.dbo.Marca;
INSERT INTO Stage_Modelo SELECT * FROM BiciMundo.dbo.Modelo;
INSERT INTO Stage_Categoria SELECT * FROM BiciMundo.dbo.Categoria;
INSERT INTO Stage_Producto SELECT * FROM BiciMundo.dbo.Producto;
INSERT INTO Stage_Inventario SELECT * FROM BiciMundo.dbo.Inventario;
INSERT INTO Stage_Cliente SELECT * FROM BiciMundo.dbo.Cliente;
INSERT INTO Stage_Vendedor SELECT * FROM BiciMundo.dbo.Vendedor;
INSERT INTO Stage_Tipo_Entrega SELECT * FROM BiciMundo.dbo.Tipo_Entrega;
INSERT INTO Stage_Medio_Pago SELECT * FROM BiciMundo.dbo.Medio_Pago;
INSERT INTO Stage_Tipo_Tarjeta SELECT * FROM BiciMundo.dbo.Tipo_Tarjeta;
INSERT INTO Stage_Tipo_Documento SELECT * FROM BiciMundo.dbo.Tipo_Documento;
INSERT INTO Stage_Venta SELECT * FROM BiciMundo.dbo.Venta;
INSERT INTO Stage_Detalle_Venta SELECT * FROM BiciMundo.dbo.Detalle_Venta;
INSERT INTO Stage_Proveedor SELECT * FROM BiciMundo.dbo.Proveedor;
INSERT INTO Stage_Producto_Proveedor SELECT * FROM BiciMundo.dbo.Producto_Proveedor;
GO

SELECT TOP 10 * FROM Stage_Producto;
SELECT TOP 10 * FROM Stage_Cliente;
SELECT TOP 10 * FROM Stage_Venta;
SELECT TOP 10 * FROM Stage_Vendedor;
SELECT TOP 10 * FROM Stage_Proveedor;
SELECT TOP 10 * FROM Stage_Categoria;
SELECT TOP 10 * FROM Stage_Tipo_Entrega;
SELECT TOP 10 * FROM Stage_Detalle_Venta;

SELECT TOP 10 * FROM Stage_Tipo_Documento;
SELECT TOP 10 * FROM Stage_Medio_Pago;
SELECT TOP 10 * FROM Stage_Tipo_Tarjeta;

SELECT TOP 10 * FROM Stage_Marca;
SELECT TOP 10 * FROM Stage_Modelo;
SELECT TOP 10 * FROM Stage_Tienda;
SELECT TOP 10 * FROM Stage_Distrito;
SELECT TOP 10 * FROM Stage_Zona;
