# Agenda de Contactos Web

## 1. Descripción del proyecto
Aplicación web desarrollada para la gestión personal de contactos mediante operaciones CRUD (crear, leer, actualizar y eliminar). El sistema cuenta con autenticación de usuarios (registro e inicio de sesión), aislamiento de datos para que cada usuario administre únicamente su propia lista de contactos, y medidas de seguridad como cifrado de contraseñas (`password_hash`) y consultas preparadas mediante PDO para prevenir inyecciones SQL.

## 2. Tecnologías utilizadas
* **Backend:** PHP 8+ (con extensión PDO)
* **Base de datos:** MySQL / MariaDB
* **Frontend:** HTML5, CSS3
* **Entorno de servidor local:** XAMPP (Apache y MySQL)
* **Control de versiones:** Git y GitHub

## 3. Requisitos para su ejecución
Para ejecutar este proyecto de manera local necesitas contar con:
* Un servidor local instalado como **XAMPP**, WAMP o Laragon (con Apache y MySQL activos).
* Navegador web actualizado (Chrome, Edge, Firefox, etc.).
* Gestor de bases de datos como **phpMyAdmin** (incluido en XAMPP).

## 4. Pasos para instalar la aplicación

1. **Clonar o descargar el repositorio:**
   Descarga el proyecto o clónalo dentro de la carpeta `htdocs` de tu instalación de XAMPP:
   ```bash
   git clone [https://github.com/daavxd/agenda_contactos.git](https://github.com/daavxd/agenda_contactos.git)
