# Página personal con módulo de gestión de usuarios

Módulo de gestión de usuarios agregado a mi página web personal, con base de datos MySQL/MariaDB (XAMPP).

**Sistema en línea:** https://cynthia-web.wuaze.com

**Autora:** Cynthia Alessandra Aguilar Uicab

## Funciones del módulo

1. Iniciar sesión (login)
2. Registrar un usuario
3. Modificar los datos de un usuario
4. Eliminar un usuario
5. Cerrar sesión
6. Validación de formularios con JavaScript (campos obligatorios, usuario de 3 a 20 caracteres, contraseña mínima de 6 caracteres y coincidencia de contraseña y re-contraseña)
7. Contraseñas cifradas con `password_hash()` y verificadas con `password_verify()`
8. Panel protegido: sin sesión iniciada redirige al login

## Tecnologías

- HTML y CSS
- JavaScript
- PHP 8
- MySQL / MariaDB (XAMPP en local, InfinityFree en línea)

## Estructura del proyecto

```
├── index.php              Redirige al login
├── autobiografia/         Páginas HTML de la página personal
├── calculadora/
├── contacto/
├── conversor/
├── cuestionario/
├── galeria/
├── index/
├── css/estilos.css        Estilos
├── js/
│   ├── codigo.js
│   └── validar_usuario.js Validación de formularios
├── imagenes/
├── media/
└── db/                    Módulo de usuarios
    ├── conexion.php
    ├── cabecera.php
    ├── pie.php
    ├── login.php
    ├── registro.php
    ├── panel.php
    ├── editar.php
    ├── eliminar.php
    ├── logout.php
    └── gestion_usuarios.sql   Respaldo de la base de datos
```

## Base de datos

- Nombre: `gestion_usuarios`
- Tabla: `clientes` (idcliente, nombre, apellido, ciudad, sexo, preferencias, usuario, contrasena, fecha_registro)
- Respaldo: `db/gestion_usuarios.sql`

## Cómo probarlo en local (XAMPP)

1. Copia el proyecto en `C:\xampp\htdocs\web`.
2. Inicia Apache y MySQL desde el panel de XAMPP.
3. En phpMyAdmin crea la base `gestion_usuarios` e importa `db/gestion_usuarios.sql`.
4. Revisa que `db/conexion.php` use `localhost`, `root` y contraseña vacía.
5. Abre `http://localhost/web/db/login.php`.

## Nota de seguridad

El archivo `db/conexion.php` de este repositorio tiene los datos de XAMPP. Los datos reales del servidor en línea se configuraron solo en el hosting y no se incluyen aquí.
