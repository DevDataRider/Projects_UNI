# 🚴‍♂️ BiciMundo – Data Engineering & BI Project

Proyecto integral de ingeniería de datos y business intelligence enfocado en el diseño, transformación y análisis de datos para la toma de decisiones.

---

## 🎯 Descripción

**BiciMundo** es un proyecto desarrollado de forma individual que abarca todo el ciclo de vida de los datos, desde la construcción de la base de datos hasta la creación de dashboards interactivos.

El objetivo es transformar datos en información útil mediante procesos ETL, modelado dimensional y herramientas de análisis.

---

## 🧠 Arquitectura del proyecto

El flujo de trabajo sigue una arquitectura clásica de BI:

```text
Fuente de datos → Database → DataStage → DataMart → SSIS → SSAS → Dashboard
```

---

## 🚀 Tecnologías utilizadas

* SQL Server
* SSIS (SQL Server Integration Services)
* SSAS (Multidimensional y Tabular)
* Excel (conexión a cubos OLAP)
* Power BI
* Modelado dimensional (modelo estrella)

---

## ⚙️ Proceso desarrollado

### 🔹 1. Base de datos (Database)

* Creación de base de datos
* Diseño de tablas relacionales
* Creación de vistas y funciones
* Inserción y manipulación de datos

---

### 🔹 2. DataStage

* Preparación y limpieza de datos
* Estructuración inicial para análisis

---

### 🔹 3. DataMart

* Modelado dimensional (esquema estrella)
* Definición de tablas de hechos y dimensiones

---

### 🔹 4. SSIS (ETL)

* Creación de flujos de datos
* Procesos de extracción, transformación y carga
* Automatización de integración de datos

---

### 🔹 5. SSAS (Análisis)

* Modelo multidimensional (cubos OLAP)
* Modelo tabular
* Consultas analíticas

---

### 🔹 6. Dashboards

* **Excel**: conexión a cubos OLAP (modo online, no interactivo localmente)
* **Power BI**: dashboard interactivo con análisis dinámico

---

## 📂 Estructura del repositorio

* `/database` → scripts SQL, tablas, vistas, funciones y ejercicios
* `/SSIntegrationServices` → paquetes ETL (SSIS)
* `/SSAnalysisServices` → DataStage, DataMart y modelos (multidimensional y tabular)
* `/Dashboard` → reportes en Excel y Power BI
* `/Documentation` → documentación detallada de cada etapa

---

## 🎯 Objetivo del proyecto

Demostrar habilidades en:

* Ingeniería de datos
* Procesos ETL
* Modelado dimensional
* Análisis de datos
* Visualización de información

---

## 📌 Notas

* Algunos archivos pueden requerir configuración local (SQL Server, SSIS, SSAS)
* Los dashboards en Excel dependen de conexión activa a cubos OLAP
* Power BI permite interacción completa con los datos

---

## 👨‍💻 Autor

**Rider Bravo**
