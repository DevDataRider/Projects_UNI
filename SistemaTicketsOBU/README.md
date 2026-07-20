# 🧾 Sistema de Tickets Comedor OBU

Sistema web desarrollado para la gestión de tickets del servicio de comedor universitario (desayuno, almuerzo y cena), diseñado para optimizar la atención y reducir tiempos de espera.

---

## 🎯 Descripción

El proyecto **Comedor OBU** surge como una solución para evitar largas colas y la pérdida de tiempo en la distribución de las comidas dentro del entorno universitario.

A través de este sistema, los usuarios pueden generar y gestionar tickets de manera digital, mejorando la organización y eficiencia del servicio.

---

## ⏰ Horarios de atención

El comedor atiende de **lunes a viernes**, en tres turnos fijos (fuera de estos horarios o los fines de semana no se pueden generar tickets nuevos):

| Turno | Horario |
|---|---|
| 🌅 Desayuno | 7:00 a. m. – 9:30 a. m. |
| 🍽️ Almuerzo | 12:00 p. m. – 2:00 p. m. |
| 🌙 Cena | 5:00 p. m. – 7:00 p. m. |

---

## 🚀 Tecnologías utilizadas

* PHP
* CodeIgniter
* JavaScript
* MySQL
* HTML & CSS

---

## ⚙️ Funcionalidades principales

* Generación de tickets digitales con código QR, uno por turno (desayuno, almuerzo, cena)
* Verificación de tickets por el personal del comedor al escanear el QR
* Gestión y control de atención (estudiantes, platos del día, incidencias, actividad estudiantil, asistencias)
* Exportación de reportes en PDF y Excel (Estudiantes, Incidencias, Actividades, Asistencias)
* Interfaz web interactiva
* Manejo de sesiones de usuario
* Registro de actividad mediante logs

---

## 📂 Estructura del proyecto

El repositorio se divide en dos partes principales:

### 🔹 Código fuente

Contiene toda la lógica y funcionamiento del sistema:

* `/app` → lógica de la aplicación (controladores, modelos)
* `/public` → punto de entrada y recursos accesibles
* `/assets`, `/css`, `/js` → archivos estáticos

---

### 🔹 Documentación

Incluye información clave del proyecto:

* 📄 Memoria descriptiva
* 📘 Manual de usuario
* 🧠 Explicación de componentes importantes del código

---

## 🧠 Objetivo

Desarrollar una solución tecnológica que mejore la eficiencia en la entrega de desayunos universitarios, aplicando buenas prácticas de desarrollo web y organización de sistemas.

---

## 📌 Notas

* Este repositorio refleja principalmente la integración del sistema completo, destacando la contribución en backend, base de datos y lógica del sistema.
* Algunos archivos como logs o dependencias no se incluyen por buenas prácticas
* El sistema puede requerir configuración de entorno (servidor local, base de datos) para su ejecución

---

👥 Colaboradores

Este proyecto fue desarrollado en colaboración:

**Rider Bravo**
- Desarrollo backend (PHP - CodeIgniter)
- Modelado de base de datos (MySQL)
- Lógica de negocio y gestión de sesiones

**Verónica Aguilar**

- Diseño de interfaz (UI)
- Desarrollo frontend (HTML, CSS, JavaScript)
- QA
