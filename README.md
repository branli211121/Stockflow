# 📦 StockFlow - Sistema de Gestión de Inventario

StockFlow es una aplicación web full-stack desarrollada como proyecto práctico para la gestión eficiente de inventarios, control de stock en tiempo real y administración de categorías de productos. 

Este proyecto fue construido con un enfoque en la seguridad de datos, buenas prácticas de desarrollo backend y una interfaz moderna y limpia.

---

## 🚀 Características Principales

* **🔐 Sistema de Autenticación Seguro:** 
  * Registro e inicio de sesión de usuarios con contraseñas cifradas utilizando `password_hash()` y `password_verify()`.
  * Control de sesiones activas para proteger las rutas del panel principal.
* **📊 CRUD Completo de Productos:**
  * **Crear:** Registro de nuevos artículos especificando nombre, categoría, precio, stock actual y stock mínimo de alerta.
  * **Leer:** Visualización en tiempo real del inventario con consultas relacionales (`INNER JOIN` entre productos y categorías).
  * **Actualizar:** Modificación de datos de cualquier producto existente.
  * **Eliminar:** Borrado seguro de artículos con confirmación previa vía JavaScript.
* **🚨 Alertas de Stock:** 
  * Indicadores visuales dinámicos que detectan automáticamente si un producto se encuentra en estado **"Óptimo"** o **"Bajo Stock"** según los parámetros establecidos.
* **🎨 Interfaz Responsiva:** 
  * Maquetación limpia y adaptable utilizando **Bootstrap 5**.

---

## 🛠️ Tecnologías Utilizadas

* **Backend:** PHP (con uso de **PDO** para consultas seguras y prevención de Inyección SQL).
* **Base de Datos:** MySQL.
* **Frontend:** HTML5, CSS3, JavaScript y Bootstrap 5.
* **Entorno de Desarrollo:** XAMPP (Apache / Localhost).

---

## ⚙️ Instalación y Configuración Local

Sigue estos pasos para clonar y ejecutar este proyecto en tu entorno local:

1. **Clonar o descargar el repositorio** en la carpeta de tu servidor local (por ejemplo, `C:\xampp\htdocs\stockflow\`).
2. **Configurar la Base de Datos:**
   * Abre tu gestor de base de datos (phpMyAdmin).
   * Crea una base de datos con el nombre de tu preferencia (ej. `stockflow_db`).
   * Importa las tablas necesarias (`usuarios`, `categorias`, `productos`) con sus respectivas relaciones de llaves foráneas.
3. **Configurar la Conexión:**
   * Abre el archivo `conexion.php` y verifica que tus credenciales de MySQL sean correctas (por defecto en XAMPP: usuario `root` y sin contraseña).
4. **Ejecutar la Aplicación:**
   * Abre tu navegador web y entra a:  
     `http://localhost/stockflow/login.php`

---

## 📂 Estructura del Proyecto

```text
stockflow/
│
├── conexion.php           # Conexión a la base de datos mediante PDO
├── login.php              # Vista y procesamiento de inicio de sesión
├── logout.php             # Destrucción segura de sesiones
├── dashboard.php          # Panel principal, tabla de inventario y formulario de registro
├── agregar_producto.php   # Lógica backend para insertar productos
├── editar_producto.php    # Vista y lógica para actualizar productos
└── eliminar_producto.php  # Lógica backend para eliminar registros
