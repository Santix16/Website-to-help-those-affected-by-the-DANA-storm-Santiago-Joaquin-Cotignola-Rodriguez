# Tutela La DANA

Plataforma web orientada a ofrecer apoyo y recursos a las personas afectadas por la DANA, facilitando la gestión de ayudas, servicios esenciales y la participación de la comunidad en acciones solidarias. El proyecto combina un frontend desarrollado en PHP con una API backend en Kotlin y MySQL, creando una solución completa para la gestión de usuarios, pedidos, mensajes y recursos de ayuda.

## ¿Qué es este proyecto?

Tutela La DANA es una iniciativa pensada para conectar a personas afectadas por la DANA con servicios de apoyo, información y asistencia práctica. La plataforma permite a los usuarios:

- Registrarse e iniciar sesión de forma segura.
- Consultar y solicitar servicios de alimentos, limpieza y ropa.
- Solicitar productos de ayuda, que generan un pedido asociado a su cuenta.
- Donar productos indicando dirección y teléfono para su recogida.
- Mantener comunicación con el equipo a través de mensajes de contacto, con hilos de conversación por usuario.
- Revisar su perfil, editarlo y consultar su historial de pedidos.
- Acceder a una experiencia de uso clara y orientada a la ayuda humanitaria.

## Características principales

- Página principal informativa con enfoque solidario y de concienciación.
- Sistema de registro e inicio de sesión para usuarios (contraseñas con hash `password_hash`/`password_verify`).
- Catálogo de servicios por categoría (alimentos, limpieza, ropa) con solicitud directa de cada producto.
- Formulario de solicitud que registra el pedido asociándolo al usuario y, cuando existe, al producto real de la base de datos.
- Formulario de donaciones con dirección y teléfono de recogida.
- Perfil de usuario: consulta de datos y edición (nombre, email, teléfono y cambio de contraseña opcional).
- Historial de pedidos por usuario y vista de detalle de cada pedido.
- Sistema de mensajes de contacto en formato de hilo/chat, tanto para el usuario como para el administrador.
- Panel de administración para gestionar donaciones, pedidos, stock de productos y mensajes de contacto.
- Integración con una API REST en Kotlin para la lógica de negocio y acceso a datos.
- Base de datos MySQL con estructura preparada para gestionar usuarios, productos, pedidos, donaciones y mensajes.
- Arquitectura dividida entre frontend y backend para facilitar mantenimiento y escalabilidad.

## Tecnologías utilizadas

- PHP
- HTML5
- CSS3
- JavaScript
- MySQL
- Kotlin
- Ktor
- Gradle
- HikariCP
- BCrypt

## Requisitos previos

Necesitarás tener instalado:

- PHP 8 o superior
- MySQL 8 o superior
- Java JDK 21
- Gradle
- Kotlin

## Instalación

1. Clona el repositorio:

```bash
git clone https://github.com/Santix16/Website-to-help-those-affected-by-the-DANA-storm-Santiago-Joaquin-Cotignola-Rodriguez.git
cd Website-to-help-those-affected-by-the-DANA-storm-Santiago-Joaquin-Cotignola-Rodriguez
```

2. Configura la base de datos MySQL:

```sql
CREATE DATABASE IF NOT EXISTS tele_dana;
USE tele_dana;
SOURCE TutelaDANA-KotlinBackend/database/database.sql;
```

El archivo es idempotente: sirve tanto para una base nueva como para actualizar una base `tele_dana` existente sin borrar sus datos. También puedes importarlo desde phpMyAdmin (`http://localhost/phpmyadmin`, pestaña **Importar**) en lugar de usar la línea de comandos; consulta el README del backend para el detalle paso a paso.

3. Ajusta la conexión del backend en la configuración de Kotlin:

- Revisa `TutelaDANA-KotlinBackend/src/main/kotlin/com/tuteladana/config/AppConfig.kt`.
- Modifica `DB_URL`, `DB_USER` y `DB_PASSWORD` según tu entorno local.

4. Inicia el backend:

```powershell
cd TutelaDANA-KotlinBackend
.\gradlew.bat run
```

5. Levanta la parte web desde `TutelaFinalVersion` con un servidor local:

```powershell
cd TutelaFinalVersion
$env:DB_HOST="127.0.0.1"
$env:DB_NAME="tele_dana"
$env:DB_USER="root"
$env:DB_PASSWORD="TU_CONTRASENA_MYSQL"
C:\xampp\php\php.exe -S localhost:8000
```

En Windows con XAMPP, el comando anterior usa directamente el PHP incluido en XAMPP y no requiere modificar el `PATH`. Si PHP ya esta añadido al `PATH`, tambien puedes usar `php -S localhost:8000`. Si prefieres usar Apache y MySQL de XAMPP en lugar del servidor embebido de PHP, recuerda tenerlos ambos **activos** desde el panel de control de XAMPP antes de acceder a la aplicación o a phpMyAdmin.

## Scripts disponibles

| Script | Comando | Descripción |
|---|---|---|
| Backend | `cd TutelaDANA-KotlinBackend; .\gradlew.bat run` | Inicia la API en Kotlin |
| Frontend | `cd TutelaFinalVersion; C:\xampp\php\php.exe -S localhost:8000` | Ejecuta la aplicación web localmente |
| Base de datos | `mysql` + `SOURCE .../database/database.sql`, o importar el mismo archivo desde phpMyAdmin | Crea o actualiza la estructura de la base de datos |
| Compilación | `cd TutelaDANA-KotlinBackend && ./gradlew build` | Genera la build del backend |

## Cómo ejecutar la aplicación

### 1) Crear la base de datos

Ejecuta el esquema disponible en:

```bash
TutelaDANA-KotlinBackend/database/database.sql
```

Asegúrate de que la base de datos se llama `tele_dana` y de que la configuración del backend coincide con ese nombre.

### 2) Iniciar el backend

```bash
cd TutelaDANA-KotlinBackend
.\gradlew.bat run
```

La API quedará disponible normalmente en:

```text
http://localhost:8080
```

### 3) Iniciar la aplicación web

```powershell
cd TutelaFinalVersion
$env:DB_HOST="127.0.0.1"
$env:DB_NAME="tele_dana"
$env:DB_USER="root"
$env:DB_PASSWORD="TU_CONTRASENA_MYSQL"
C:\xampp\php\php.exe -S localhost:8000
```

Accede desde:

```text
http://localhost:8000
```

### 4) Probar las funcionalidades principales

- Registro e inicio de sesión
- Consulta de servicios disponibles por categoría (alimentos, limpieza, ropa)
- Solicitud de ayuda (genera un pedido) y consulta de su historial
- Envío de una donación con dirección y teléfono de recogida
- Envío y respuesta de mensajes de contacto (hilo de conversación)
- Consulta y edición de perfil
- Acceso al panel de administración con una cuenta `ADMIN`

### Cuenta de administración por defecto

Para probar el panel de administración y las funcionalidades avanzadas, puedes utilizar la siguiente cuenta ya creada por defecto:

- **Email:** `admin@tuteladana.local`
- **Contraseña:** `AdminDANA2026!`

## Estructura del proyecto

```text
TutelaFinalVersion/
|-- donar.php
|-- formulario_solicitud.php
|-- index.php
|-- login.php
|-- logout.php
|-- quienes_somos.php
|-- register.php
|-- servicios.php
|-- servicios_alimentos.php
|-- servicios_limpieza.php
|-- servicios_ropa.php
|
|-- admin/
|   |-- donaciones.php
|   |-- index.php
|   |-- logout.php
|   |-- mensajes.php
|   |-- nav.php
|   |-- pedidos.php
|   `-- stock.php
|
|-- assets/
|   |-- css/
|   |   |-- font-awesome.min.css
|   |   |-- main.css
|   |   `-- images/
|   |       `-- overlay.png
|   |-- fonts/
|   |   `-- fontawesome-webfont.* (eot, svg, ttf, woff, woff2)
|   `-- js/
|       |-- jquery.min.js
|       |-- main.js
|       |-- skel.min.js
|       `-- util.js
|
|-- contacto/
|   |-- contacto.php
|   |-- mis_mensajes.php
|   `-- procesar_contacto.php
|
|-- css/                      
|   |-- font-awesome.min.css
|   |-- skel.css
|   |-- style-xlarge.css
|   |-- style.css
|   `-- images/
|       `-- overlay.png
|
|-- emails/
|   |-- enviar_mensaje.php
|   `-- enviar_pedido.php
|
|-- images/
|   |-- alimentos.jpg
|   |-- comunidad.jpg
|   |-- empatia.jpg
|   |-- facil.jpg
|   |-- limpieza.jpg
|   |-- ropa.jpg
|   `-- transparencia.jpg
|
|-- includes/
|   |-- db.php
|   |-- footer.php
|   `-- header.php
|
|-- js/                       
|   |-- html5shiv.js
|   |-- init.js
|   |-- jquery.min.js
|   |-- skel-layers.min.js
|   `-- skel.min.js
|
|-- mensajes/
|   |-- enviar.php
|   `-- inbox.php
|
|-- pedidos/
|   |-- historial.php
|   `-- pedido.php
|
`-- users/
    |-- actualizar_perfil.php
    |-- perfil.php
    `-- perfil_privado.php
```

## Cómo usar la aplicación

1. Accede a la landing page principal.
2. Registra una cuenta o inicia sesión si ya tienes usuario.
3. Explora los servicios disponibles por categoría (alimentos, limpieza, ropa).
4. Selecciona el producto que necesitas y confirma la solicitud desde `formulario_solicitud.php`; esto crea un pedido asociado a tu cuenta con estado `pendiente`.
5. Si en cambio quieres aportar algo, usa `donar.php` para registrar una donación indicando dirección y teléfono de recogida.
6. Consulta tu perfil, tu historial de pedidos y tus mensajes dentro de la plataforma.
7. Usa la herramienta como una solución para la coordinación de ayuda y asistencia humanitaria.

## Guardado del progreso

La aplicación mantiene la información del usuario en la base de datos MySQL y utiliza sesiones PHP para conservar el estado de navegación y la autenticación. Esto permite que el usuario acceda de forma persistente a su perfil, pedidos, donaciones, mensajes y contexto de ayuda dentro de la plataforma.

## Créditos

Proyecto desarrollado con un enfoque solidario y social para apoyar a las personas afectadas por la DANA, combinando una experiencia web accesible con una API moderna en Kotlin para gestionar la lógica del sistema y los datos de la aplicación.