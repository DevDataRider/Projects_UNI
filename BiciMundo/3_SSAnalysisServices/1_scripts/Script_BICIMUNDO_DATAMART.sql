-------------------------------------------
-- Verificación
-------------------------------------------

USE master;
GO

-- Comprobar si existe BiciMundo_DataMart y eliminarla
IF DB_ID('BiciMundo_DataMart') IS NOT NULL
BEGIN
    ALTER DATABASE BiciMundo_DataMart SET SINGLE_USER WITH ROLLBACK IMMEDIATE;
    DROP DATABASE BiciMundo_DataMart;
END
GO

-------------------------------------------
-- Creación
-------------------------------------------

SET LANGUAGE Spanish;
GO

CREATE DATABASE BiciMundo_DataMart;
GO

USE BiciMundo_DataMart;
GO

-------------------------------------------
-- Crear Tablas Dimensiones
-------------------------------------------

-- Dim_Clientes
CREATE TABLE Dim_Clientes (
    ClienteSK INT IDENTITY(1,1) PRIMARY KEY,
    id_cliente INT,
    nombre_completo VARCHAR(200),
    distrito VARCHAR(100)
);
GO

-- Dim_Productos
CREATE TABLE Dim_Productos (
    ProductoSK INT IDENTITY(1,1) PRIMARY KEY,
    id_producto INT,
    nombre_producto VARCHAR(100),
    categoria VARCHAR(100),
    marca VARCHAR(100),
    modelo VARCHAR(100)
);
GO

-- Dim_Vendedores
CREATE TABLE Dim_Vendedores (
    VendedorSK INT IDENTITY(1,1) PRIMARY KEY,
    id_vendedor INT,
    nombre_completo VARCHAR(200),
    tienda VARCHAR(100)
);
GO

-- Dim_Fecha
CREATE TABLE Dim_Fecha (
    FechaKey INT PRIMARY KEY,
    Fecha DATE,
    Dia INT,
    Mes INT,
    NombreMes NVARCHAR(15),
    Trimestre INT,
    Anio INT,
    Semana INT,
    DiaSemana INT,
    NombreDia NVARCHAR(15)
);
GO

-- Dim_Orden
CREATE TABLE Dim_Orden (
    OrdenSK INT IDENTITY(1,1) PRIMARY KEY,
    id_venta INT,
    fecha DATE,
    cliente_nombre VARCHAR(200),
    vendedor_nombre VARCHAR(200),
    tipo_entrega VARCHAR(100)
);
GO

-------------------------------------------
-- Crear Tabla de Hechos
-------------------------------------------

CREATE TABLE Fact_Ventas (
    VentaSK INT IDENTITY(1,1) PRIMARY KEY,
    OrdenSK INT,
    ProductoSK INT,
    ClienteSK INT,
    VendedorSK INT,
    FechaKey INT,
    cantidad INT,
    precio_unitario DECIMAL(10,2),
    monto_total DECIMAL(12,2)
);
GO

-------------------------------------------
-- Poblar Dimensiones
-------------------------------------------

-- Dim_Clientes
INSERT INTO Dim_Clientes (id_cliente, nombre_completo, distrito)
SELECT DISTINCT
    c.id_cliente,
    c.nombres + ' ' + c.apellidos,
    d.nombre_distrito
FROM BiciMundo_Stage.dbo.Stage_Cliente c
LEFT JOIN BiciMundo_Stage.dbo.Stage_Distrito d ON c.id_distrito = d.id_distrito
WHERE c.id_cliente IS NOT NULL;
GO

-- Dim_Productos
INSERT INTO Dim_Productos (id_producto, nombre_producto, categoria, marca, modelo)
SELECT DISTINCT
    p.id_producto,
    p.nombre,
    c.nombre_categoria,
    m.nombre_marca,
    mo.nombre_modelo
FROM BiciMundo_Stage.dbo.Stage_Producto p
LEFT JOIN BiciMundo_Stage.dbo.Stage_Categoria c ON p.id_categoria = c.id_categoria
LEFT JOIN BiciMundo_Stage.dbo.Stage_Marca m ON p.id_marca = m.id_marca
LEFT JOIN BiciMundo_Stage.dbo.Stage_Modelo mo ON p.id_modelo = mo.id_modelo
WHERE p.id_producto IS NOT NULL;
GO

-- Dim_Vendedores
INSERT INTO Dim_Vendedores (id_vendedor, nombre_completo, tienda)
SELECT DISTINCT
    v.id_vendedor,
    v.nombres + ' ' + v.apellidos,
    t.nombre_tienda
FROM BiciMundo_Stage.dbo.Stage_Vendedor v
LEFT JOIN BiciMundo_Stage.dbo.Stage_Tienda t ON v.id_tienda = t.id_tienda
WHERE v.id_vendedor IS NOT NULL;
GO

-- Dim_Fecha
DECLARE @MinDate DATE, @MaxDate DATE, @CurrentDate DATE;

SELECT 
    @MinDate = MIN(fecha),
    @MaxDate = MAX(fecha)
FROM BiciMundo_Stage.dbo.Stage_Venta
WHERE fecha IS NOT NULL;

SET @CurrentDate = DATEFROMPARTS(YEAR(@MinDate), 1, 1);
SET @MaxDate = DATEFROMPARTS(YEAR(@MaxDate), 12, 31);

WHILE @CurrentDate <= @MaxDate
BEGIN
    INSERT INTO Dim_Fecha (
        FechaKey, Fecha, Dia, Mes, NombreMes, Trimestre,
        Anio, Semana, DiaSemana, NombreDia
    )
    VALUES (
        CONVERT(INT, FORMAT(@CurrentDate, 'yyyyMMdd')),
        @CurrentDate,
        DAY(@CurrentDate),
        MONTH(@CurrentDate),
        DATENAME(MONTH, @CurrentDate),
        DATEPART(QUARTER, @CurrentDate),
        YEAR(@CurrentDate),
        DATEPART(WEEK, @CurrentDate),
        DATEPART(WEEKDAY, @CurrentDate),
        DATENAME(WEEKDAY, @CurrentDate)
    );

    SET @CurrentDate = DATEADD(DAY, 1, @CurrentDate);
END;
GO

-- Dim_Orden
INSERT INTO Dim_Orden (id_venta, fecha, cliente_nombre, vendedor_nombre, tipo_entrega)
SELECT DISTINCT
    v.id_venta,
    v.fecha,
    c.nombres + ' ' + c.apellidos,
    ven.nombres + ' ' + ven.apellidos,
    te.tipo_entrega
FROM BiciMundo_Stage.dbo.Stage_Venta v
LEFT JOIN BiciMundo_Stage.dbo.Stage_Cliente c ON v.id_cliente = c.id_cliente
LEFT JOIN BiciMundo_Stage.dbo.Stage_Vendedor ven ON v.id_vendedor = ven.id_vendedor
LEFT JOIN BiciMundo_Stage.dbo.Stage_Tipo_Entrega te ON v.id_tipo_entrega = te.id_tipo_entrega
WHERE v.id_venta IS NOT NULL;
GO

-------------------------------------------
-- Poblar Fact_Ventas
-------------------------------------------

INSERT INTO Fact_Ventas (
    OrdenSK, ProductoSK, ClienteSK, VendedorSK, FechaKey,
    cantidad, precio_unitario, monto_total
)
SELECT
    o.OrdenSK,
    p.ProductoSK,
    c.ClienteSK,
    v.VendedorSK,
    CONVERT(INT, FORMAT(venta.fecha, 'yyyyMMdd')),
    dv.cantidad,
    dv.precio_unitario,
    dv.cantidad * dv.precio_unitario
FROM BiciMundo_Stage.dbo.Stage_Venta venta
JOIN BiciMundo_Stage.dbo.Stage_Detalle_Venta dv ON venta.id_venta = dv.id_venta
JOIN Dim_Orden o ON o.id_venta = venta.id_venta
JOIN Dim_Productos p ON p.id_producto = dv.id_producto
JOIN Dim_Clientes c ON c.id_cliente = venta.id_cliente
JOIN Dim_Vendedores v ON v.id_vendedor = venta.id_vendedor
WHERE venta.fecha IS NOT NULL;
GO

-------------------------------------------
-- Creación de Constraints
-------------------------------------------

ALTER TABLE Fact_Ventas
ADD CONSTRAINT FK_FactVentas_Orden
FOREIGN KEY (OrdenSK)
REFERENCES Dim_Orden(OrdenSK);
GO

ALTER TABLE Fact_Ventas
ADD CONSTRAINT FK_FactVentas_Productos
FOREIGN KEY (ProductoSK)
REFERENCES Dim_Productos(ProductoSK);
GO

ALTER TABLE Fact_Ventas
ADD CONSTRAINT FK_FactVentas_Clientes
FOREIGN KEY (ClienteSK)
REFERENCES Dim_Clientes(ClienteSK);
GO

ALTER TABLE Fact_Ventas
ADD CONSTRAINT FK_FactVentas_Vendedores
FOREIGN KEY (VendedorSK)
REFERENCES Dim_Vendedores(VendedorSK);
GO

ALTER TABLE Fact_Ventas
ADD CONSTRAINT FK_FactVentas_Fecha
FOREIGN KEY (FechaKey)
REFERENCES Dim_Fecha(FechaKey);
GO

-------------------------------------------
-- Verificación
-------------------------------------------

SELECT TOP 10 * FROM Dim_Clientes;
SELECT TOP 10 * FROM Dim_Productos;
SELECT TOP 10 * FROM Dim_Vendedores;
SELECT TOP 10 * FROM Dim_Fecha;
SELECT TOP 10 * FROM Dim_Orden;
SELECT TOP 10 * FROM Fact_Ventas;
GO

