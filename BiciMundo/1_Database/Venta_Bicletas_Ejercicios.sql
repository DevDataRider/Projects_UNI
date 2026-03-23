-------------------------------------------------------------------------
use BiciMundo;

--1. Listado de productos que NO tengan como primer caracter en el nombre
-- las letras A,B,C,D,E,F,G,J

--SELECT COUNT(*) AS 'Cantidad de Productos'
--FROM Producto;
--100

SELECT * FROM PRODUCTO
WHERE NOMBRE LIKE '[^ABCDEFGJ]%'

-----------------------------------------------------------------------------------
--2. ¿Cuáles fueron las ventas realizadas durante el segundo trimestre
-- del año 2025 que se efectuaron un día jueves?

--SELECT @@VERSION;
--SELECT @@LANGUAGE;
--us_english
--SET LANGUAGE Spanish;
--SELECT @@LANGUAGE;
--ESPAÑOL

SELECT * 
FROM Venta
WHERE YEAR(fecha) = 2025
  AND DATEPART(QUARTER, fecha) = 2
  AND DATEPART(WEEKDAY, fecha) = 4; --(jueves)

------------------------------------------------------------------------------------
--3. ¿Cuáles son los productos que pertenecen a las categorías
--"Herramientas" o "Accesorios", y cuáles son sus nombres,
--descripciones y precios actuales?

SELECT nombre, descripcion, precio_actual
FROM Producto
WHERE id_categoria IN (SELECT id_categoria
                       FROM Categoria
                       WHERE nombre_categoria IN ('Herramientas', 'Accesorios'));

-------------------------------------------------------------------------------------
--4. ¿Cuál es el nombre, la marca, el modelo y 
--la categoría de cada producto disponible?

--SELECT * FROM PRODUCTO

SELECT 
    p.nombre, descripcion, precio_actual, p.garantia_meses,
    m.nombre_marca,
    mo.nombre_modelo,
    c.nombre_categoria
FROM 
    Producto p
INNER JOIN 
    Marca m ON p.id_marca = m.id_marca
INNER JOIN 
    Modelo mo ON p.id_modelo = mo.id_modelo
INNER JOIN 
    Categoria c ON p.id_categoria = c.id_categoria

------------------------------------------------------------------------------------
--5. Qué tiendas están ubicadas en un distrito
-- específico llamado "Miraflores"?

SELECT t.nombre_tienda, d.nombre_distrito
FROM Tienda t
INNER JOIN 
    Distrito d ON t.id_distrito = d.id_distrito
WHERE 
    d.nombre_distrito = 'Miraflores';

---------------------------------------------------------------------------------------------
---------------------------------------------------------------------------------------------
--1. Vistas
--1.1. ¿Cuál es el inventario de productos disponible en cada tienda, incluyendo el nombre
 --del producto, su categoría, marca, modelo y cantidad en stock?

CREATE VIEW Inventario_Tienda AS
SELECT 
    t.nombre_tienda,
    p.nombre AS nombre_producto,
    c.nombre_categoria,
    m.nombre_marca,
    mo.nombre_modelo,
    i.stock
FROM 
    Inventario i
INNER JOIN 
    Tienda t ON i.id_tienda = t.id_tienda
INNER JOIN 
    Producto p ON i.id_producto = p.id_producto
INNER JOIN 
    Categoria c ON p.id_categoria = c.id_categoria
INNER JOIN 
    Marca m ON p.id_marca = m.id_marca
INNER JOIN 
    Modelo mo ON p.id_modelo = mo.id_modelo;

--Listar todo el inventario
--SELECT * FROM Inventario_Tienda;

--Filtrar por productos de una categoría específica:
SELECT * FROM Inventario_Tienda
WHERE nombre_categoria = 'Squirt Cycling';

------------------------------------------------------------------------------------------------------
--1.2. ¿Cuántos años tienen los clientes registrados en la base de datos, y cuáles de ellos cumplen
-- años hoy para poder aplicarles algún descuento o promoción?

CREATE VIEW Clientes_Edad_Descuento AS
SELECT 
    c.id_cliente,
    c.nombres,
    c.apellidos,
    c.correo,
    c.fecha_nacimiento,
    DATEDIFF(YEAR, c.fecha_nacimiento, GETDATE()) AS edad,
    CASE 
        WHEN MONTH(c.fecha_nacimiento) = MONTH(GETDATE()) AND DAY(c.fecha_nacimiento) = DAY(GETDATE()) 
        THEN 'Sí' 
        ELSE 'No' 
    END AS cumple_ano
FROM 
    Cliente c;

SELECT * FROM Clientes_Edad_Descuento;

--------------------------------------------------------------------------------------------------------
--------------------------------------------------------------------------------------------------------
--2. FUNCIONES
--2.1 ¿Cuánto dinero ha gastado cada cliente en todas sus
-- compras registradas en el sistema?
CREATE FUNCTION dbo.fn_TotalGastadoCliente (@id_cliente INT)
RETURNS DECIMAL(10,2)
AS
BEGIN
    DECLARE @total_gastado DECIMAL(10,2)

    SELECT @total_gastado = SUM(dv.cantidad * dv.precio_unitario)
    FROM Venta v
    INNER JOIN Detalle_Venta dv ON v.id_venta = dv.id_venta
    WHERE v.id_cliente = @id_cliente

    RETURN ISNULL(@total_gastado, 0)
END;

SELECT 
    c.nombres + ' ' + c.apellidos AS nombre_cliente,
    dbo.fn_TotalGastadoCliente(c.id_cliente) AS total_gastado
FROM 
    Cliente c;

-----------------------------------------------------------------------------------------------------------
--2.2. ¿Cuántas unidades hay disponibles de cada producto 
--considerando el inventario de todas las tiendas?
CREATE FUNCTION dbo.fn_StockTotalProducto (@id_producto INT)
RETURNS INT
AS
BEGIN
    DECLARE @stock_total INT

    SELECT @stock_total = SUM(i.stock)
    FROM Inventario i
    WHERE i.id_producto = @id_producto

    RETURN ISNULL(@stock_total, 0)
END;


SELECT 
    p.nombre AS nombre_producto,
    dbo.fn_StockTotalProducto(p.id_producto) AS stock_total
FROM 
    Producto p;

-----------------------------------------------------------------------------------------------
-----------------------------------------------------------------------------------------------
--3. Procedimientos Almacenados
--3.1. ¿Cómo ingresar rápidamente una venta completa en el
--sistema sin tener que escribir múltiples INSERT manuales?

CREATE PROCEDURE sp_RegistrarVentaSimple
    @fecha DATE,
    @id_tipo_documento INT,
    @serie_documento VARCHAR(10),
    @numero_documento VARCHAR(20),
    @id_cliente INT,
    @id_vendedor INT,
    @id_tipo_entrega INT,
    @id_medio_pago INT,
    @id_producto INT,
    @cantidad INT,
    @precio_unitario DECIMAL(10,2)
AS
BEGIN
    DECLARE @id_venta INT;

    -- Insertar en Venta
    INSERT INTO Venta (
        fecha, id_tipo_documento, serie_documento, numero_documento,
        id_cliente, id_vendedor, id_tipo_entrega, id_medio_pago
    )
    VALUES (
        @fecha, @id_tipo_documento, @serie_documento, @numero_documento,
        @id_cliente, @id_vendedor, @id_tipo_entrega, @id_medio_pago
    );

    SET @id_venta = SCOPE_IDENTITY();

    -- Insertar detalle de la venta
    INSERT INTO Detalle_Venta (
        id_venta, id_producto, cantidad, precio_unitario
    )
    VALUES (
        @id_venta, @id_producto, @cantidad, @precio_unitario
    );

    -- Mostrar resultado (opcional)
    SELECT 
        @id_venta AS id_venta,
        @cantidad * @precio_unitario AS total_venta;
END;

EXEC sp_RegistrarVentaSimple
    @fecha = '2025-04-29',
    @id_tipo_documento = 1,
    @serie_documento = 'F001',
    @numero_documento = '00001234',
    @id_cliente = 5,
    @id_vendedor = 3,
    @id_tipo_entrega = 2,
    @id_medio_pago = 1,
    @id_producto = 10,
    @cantidad = 2,
    @precio_unitario = 850.50;

--comprobar
SELECT * FROM Venta
ORDER BY id_venta DESC;

--SELECT * FROM Detalle_Venta
--ORDER BY id_detalle DESC;

------------------------------------------------------------------------------

---3.2. ¿Cómo registrar un nuevo cliente en el
--  sistema de ventas de la tienda?

CREATE PROCEDURE RegistrarCliente
    @nombres VARCHAR(100),
    @apellidos VARCHAR(100),
    @correo VARCHAR(100),
    @telefono VARCHAR(15),
    @direccion VARCHAR(150),
    @fecha_nacimiento DATE,
    @dni VARCHAR(15),
    @ruc VARCHAR(15),
    @id_distrito INT
AS
BEGIN
    INSERT INTO Cliente (
        nombres, apellidos, correo, telefono, direccion,
        fecha_nacimiento, dni, ruc, id_distrito
    )
    VALUES (
        @nombres, @apellidos, @correo, @telefono, @direccion,
        @fecha_nacimiento, @dni, @ruc, @id_distrito
    );

    -- Retornar el ID generado
    SELECT SCOPE_IDENTITY() AS id_cliente_registrado;
END;


EXEC RegistrarCliente 
    @nombres = 'Ana',
    @apellidos = 'Soto',
    @correo = 'ana.soto@example.com',
    @telefono = '987654321',
    @direccion = 'Calle Los Robles 123',
    @fecha_nacimiento = '1992-05-12',
    @dni = '12345678',
    @ruc = '10293847561',
    @id_distrito = 3;


--verificando
SELECT *  FROM Cliente
Order by id_cliente desc;







