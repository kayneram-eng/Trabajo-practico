# 🐾 Genesys – Sistema de Gestión Integral

Sistema de gestión integral para control de productos de mascotas y administración de empleados, desarrollado con arquitectura **MVC**, **PHP** y **MySQL**.  
Incluye autenticación de usuarios, roles jerárquicos, bloqueo automático, recuperación de contraseñas y un panel gerencial completo.

---

## 📋 Descripción General

**Genesys** es un sistema web diseñado para optimizar la administración de inventario y personal.  
Permite gestionar productos, empleados y controlar el acceso mediante distintos roles (Gerente / Empleado / Superadmin).  
El sistema incluye un **panel gerencial (dashboard)** con métricas en tiempo real y registro de accesos.

---

## ⚙️ Funcionalidades Principales

### 🧍‍♂️ Gestión de Empleados
- Alta, baja y modificación de empleados.  
- Campos principales: **DNI, nombre, apellido, email, contraseña, fecha de nacimiento, rol y estado.**  
- Bloqueo automático tras 5 intentos de login fallidos.  
- Desbloqueo manual desde el panel del gerente (registrado en el log).  
- Eliminación de usuarios (borrado físico o inactivación).  
- Buscador por email (DataTables).  

### 📦 Gestión de Productos
- CRUD completo (crear, leer, actualizar y eliminar).  
- Control de inventario y stock.  
- Visualización de productos según rol del usuario.

### 📊 Dashboard Gerencial
- Estadísticas en tiempo real:  
  - Total de empleados  
  - Empleados activos  
  - Empleados inactivos  
  - Total de productos  
- Sección “Ver lista” con modales interactivos para activos e inactivos.  
- Acceso al registro completo de accesos.

### 🔐 Sistema de Autenticación
- Login y logout con control de sesiones.  
- Roles definidos:  
  - **Gerente:** acceso total.  
  - **Empleado:** acceso restringido a productos.  
- Recuperación de contraseña con token temporal (15 minutos).  
- Control de intentos fallidos y bloqueo temporal.  
- Desbloqueo manual por administrador.

### 🧾 Registro de Accesos
- Todos los logins, errores de acceso y desbloqueos quedan registrados en la tabla `accesos`.  
- Visualización del log desde el panel del gerente.  

### 📊 Tablas Dinámicas (DataTables)
- Búsqueda en tiempo real (por email, nombre, etc.)  
- Paginación automática  
- Ordenamiento por columnas  
- Exportación a PDF / Excel  

---

## 🛠️ Tecnologías Utilizadas

### Backend
- **PHP 8**  
- **PDO (PHP Data Objects)**  
- **MySQL (MariaDB)**  
- **Arquitectura MVC (Model-View-Controller)**

### Frontend
- **Bootstrap 5** – Diseño moderno y responsive  
- **DataTables** – Tablas interactivas  
- **HTML5 / CSS3 / JavaScript**

### Seguridad
- Hash de contraseñas (password_hash / verify).  
- Validación de inputs y consultas preparadas (prevención de SQL Injection).  
- Control de sesiones y redirección segura.  
- Bloqueo automático por intentos fallidos.

---

## 🧠 Arquitectura y Estructura del Proyecto

```
sistema_gestion_php-main/
│
├── config.php                  # Configuración de conexión a la base de datos
├── database.php                # Conexión PDO
│
├── routers/
│   └── web.php                 # Router principal
│
├── controllers/
│   ├── login_controller.php
│   ├── empleado.controller.php
│   ├── product.controller.php
│   ├── registro_controller.php
│   ├── password_reset_controller.php
│   └── desbloquear_usuario_controller.php
│
├── models/
│   ├── empleado.model.php
│   └── product.model.php
│
├── views/
│   ├── login.view.php
│   ├── gerente.view.php
│   ├── gestion_empleados.view.php
│   ├── product.view.php
│   └── layouts/
│       ├── header.php
│       └── footer.php
│
├── helpers/
│   ├── datatables.js
│   └── toast.php
│
├── sistema_gestion.sql         # Script de base de datos
└── README.md
```

---

## 🧩 Instalación y Configuración

### Requisitos Previos
- **XAMPP** (Apache + MySQL + PHP)
- Navegador actualizado
- **phpMyAdmin** para importar la base de datos

### Pasos

1. Copiar la carpeta del proyecto a:
   ```
   C:\xampp\htdocs\sistema_gestion_php-main\
   ```
2. Iniciar Apache y MySQL desde el Panel de XAMPP.  
3. En `phpMyAdmin`, crear la base de datos:
   ```
   sistema_gestion
   ```
4. Importar el archivo `sistema_gestion.sql`.  
5. Verificar conexión en `config.php`:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'sistema_gestion');
   define('DB_USER', 'root');
   define('DB_PASS', '');
   ```
6. Acceder desde el navegador:
   ```
   http://localhost/sistema_gestion_php-main/
   ```

---

## 👥 Usuarios de Prueba

| Usuario | Contraseña | Rol |
|----------|-------------|-----|
| admin | Admin123! | Gerente |
| empleado | Empleado123! | Empleado |

---

## 💡 Mejoras Implementadas

| Mejora Opcional | Estado | Descripción |
|-----------------|---------|--------------|
| Desbloqueo de cuentas desde Admin | ✅ | Botón “🔓 Desbloquear” con registro automático en auditoría. |
| Recuperación de contraseña | ✅ | Con token temporal (15 minutos). |
| Fecha de nacimiento | ✅ | Nuevo campo en el registro y edición de empleados. |
| Eliminación de usuario | ✅ | Confirmación mediante modal. |
| Buscador por email | ✅ | Filtro en tiempo real con DataTables. |

---

## 🧾 Dashboard Gerencial

Muestra información clave:
- Total de empleados.  
- Empleados activos e inactivos.  
- Total de productos.  
- Modales con detalle de cada categoría.  
- Acceso directo al registro de accesos.

---

## 🧰 Solución de Problemas

### ❌ Error de conexión
Verificar:
- MySQL corriendo en XAMPP.
- Archivo `config.php` correcto.
- Base de datos importada.

### ⚠️ Pantalla en blanco
- Revisar los logs de PHP (`xampp/php/logs/php_error.log`).
- Confirmar que el archivo `index.php` carga `routers/web.php`.

### ⚙️ Problemas con DataTables
- Revisar conexión a internet (CDN).
- Abrir consola del navegador (`F12`) para ver errores JS.

---

## 📄 Licencia
Proyecto de uso educativo y privado.  
Desarrollado con ❤️ en PHP, MySQL y Bootstrap 5.

---

## ✨ Créditos
**Equipo de desarrollo:**
- [Tu Nombre]
- [Nombre de tu compañero]

**Docente:** [Nombre del profesor / cátedra]  
**Materia:** Programación Web Dinámica (PHP)

---

### ✅ Estado Final:  
**Proyecto completado al 100 %**  
Cumple con todos los **requisitos funcionales y mejoras opcionales** del trabajo práctico.
