# Titan Supplements

**Titan Supplements** es una aplicación web de e-commerce dedicada a la venta de suplementos deportivos de élite, con un diseño industrial, oscuro y dinámico.

Enlace al proyecto en producción: [https://alumno11.dwes.site/](https://alumno11.dwes.site/)

## ¿Qué hace la aplicación?

La aplicación permite a los usuarios:
- **Explorar el Arsenal:** Ver un catálogo dinámico de suplementos deportivos con sus precios y descripciones.
- **Carrito de Compras:** Añadir productos al carrito, calcular el total y persistir los datos usando `LocalStorage`.
- **Inteligencia de Misión:** Visualizar datos en tiempo real provenientes de la base de datos, como el inventario actual y los usuarios registrados.
- **Alistamiento de Operativos:** Un formulario de registro que envía datos al servidor para guardar nuevos usuarios en la base de datos de forma asíncrona.
- **Autenticación:** Un modal interactivo para iniciar sesión o registrarse.
- **Modo Offline:** Un sistema de respaldo que utiliza datos simulados y almacenamiento local en caso de que no haya conexión con la base de datos o el servidor PHP.

## Tecnologías Utilizadas

### Frontend
- **HTML5:** Estructura semántica de la web en una arquitectura adaptada a "Single-Page".
- **CSS / Tailwind CSS:** Estilos implementados a través del CDN de Tailwind con configuración personalizada (colores, fuentes y modo oscuro). Se utiliza CSS puro para gradientes, animaciones y transiciones de los modales.
- **JavaScript (Vanilla):** Lógica del cliente, manipulación del DOM, peticiones AJAX mediante `fetch()` al backend, y manejo del carrito usando `LocalStorage`.
- **Fuentes e Iconos:** Google Fonts (Bebas Neue, Hanken Grotesk) y Google Material Symbols.

### Backend & Base de Datos
- **PHP:** Script `api.php` que actúa como una API sencilla devolviendo y procesando datos en formato JSON.
- **MySQL:** Base de datos relacional conectada mediante PDO para almacenar productos y usuarios (ver `database.sql`).

## ¿Cómo Instalarla?

Si deseas ejecutar esta aplicación en un entorno local, sigue estos pasos:

1. **Requisitos Previos:** Necesitas un entorno de servidor local como [XAMPP](https://www.apachefriends.org/), [WAMP](https://www.wampserver.com/) o [MAMP](https://www.mamp.info/) que incluya Apache, PHP y MySQL.
2. **Descargar el Repositorio:** Clona o descarga los archivos de este proyecto y colócalos en la carpeta de documentos de tu servidor web (por ejemplo, `htdocs` en XAMPP o `www` en WAMP).
3. **Configurar la Base de Datos:**
   - Abre `phpMyAdmin` (usualmente en `http://localhost/phpmyadmin`).
   - Crea una nueva base de datos.
   - Importa el archivo `database.sql` incluido en el proyecto para crear las tablas necesarias (`users`, `products`) y poblar los datos iniciales.
4. **Configurar la Conexión a la Base de Datos:**
   - Como el archivo de configuración real (`config.php`) no está incluido en el repositorio por motivos de seguridad (excluido en `.gitignore`), debes crear uno a partir de la plantilla.
   - Copia o renombra el archivo `config.example.php` a `config.php`:
     ```bash
     cp config.example.php config.php
     ```
   - Abre `config.php` y completa las variables con tus credenciales de base de datos local:
     ```php
     $host = '127.0.0.1';
     $db   = 'tu_nombre_de_bd';
     $user = 'tu_usuario';
     $pass = 'tu_contraseña';
     ```
5. **Ejecutar:** Abre tu navegador y navega a la ruta de tu proyecto local, por ejemplo: `http://localhost/AW-Alejandroadm-main/`.
