# Tutela La DANA

Plataforma web orientada a ofrecer apoyo y recursos a las personas afectadas por la DANA, facilitando la gestión de ayudas, servicios esenciales y la participación de la comunidad en acciones solidarias. El proyecto combina un frontend desarrollado en PHP con una API backend en Kotlin y MySQL, creando una solución completa para la gestión de usuarios, pedidos, mensajes y recursos de ayuda.

## ¿Qué es este proyecto?

Tutela La DANA es una iniciativa pensada para conectar a personas afectadas por la DANA con servicios de apoyo, información y asistencia práctica. La plataforma permite a los usuarios:

- Registrarse e iniciar sesión de forma segura.
- Consultar y solicitar servicios de alimentos, limpieza y ropa.
- Gestionar pedidos de ayuda y materiales esenciales.
- Mantener comunicación con el equipo a través de mensajes de contacto.
- Revisar su perfil, historial de pedidos y actividad en la plataforma.
- Acceder a una experiencia de uso clara y orientada a la ayuda humanitaria.

## Características principales

- Página principal informativa con enfoque solidario y de concienciación.
- Sistema de registro e inicio de sesión para usuarios.
- Catálogo de servicios disponibles con posibilidad de solicitud.
- Carrito de compra para gestionar pedidos de apoyo.
- Perfil de usuario con información personal y actividad.
- Gestión de mensajes y contacto con soporte.
- Integración con una API REST en Kotlin para la lógica de negocio y acceso a datos.
- Base de datos MySQL con estructura preparada para gestionar usuarios, productos, pedidos y mensajes.
- Panel de administracion para gestionar estados de pedidos y stock.
- Arquitectura dividida entre frontend y backend para facilitar mantenimiento y escalabilidad.

## Capturas de pantalla

Aún no se han añadido capturas del proyecto en este repositorio, pero se recomienda incluir:

- pantalla principal o landing page
- vista de servicios disponibles
- formulario de login y registro
- perfil de usuario y historial
- apartado de contacto o mensajes
- flujo de pedido y carrito de compra

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

El archivo es idempotente: sirve tanto para una base nueva como para actualizar una base `tele_dana` existente sin borrar sus datos.

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

En Windows con XAMPP, el comando anterior usa directamente el PHP incluido en XAMPP y no requiere modificar el `PATH`. Si PHP ya esta añadido al `PATH`, tambien puedes usar `php -S localhost:8000`.

## Scripts disponibles

| Script | Comando | Descripción |
|---|---|---|
| Backend | `cd TutelaDANA-KotlinBackend; .\gradlew.bat run` | Inicia la API en Kotlin |
| Frontend | `cd TutelaFinalVersion; C:\xampp\php\php.exe -S localhost:8000` | Ejecuta la aplicación web localmente |
| Base de datos | `mysql` + `SOURCE .../database/database.sql` | Crea o actualiza la estructura de la base de datos |
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
- Consulta de servicios disponibles
- Solicitud de ayuda y gestión de pedidos
- Añadir productos al carrito
- Envío de mensajes de contacto
- Consulta de perfil y historial de actividades
- Acceso al panel de administracion con una cuenta `ADMIN`

## Estructura del proyecto

```text
.
├── README.md
├── TutelaDANA-KotlinBackend/
│   ├── build.gradle.kts
│   ├── gradlew
│   ├── gradlew.bat
│   ├── settings.gradle.kts
│   ├── database/
│   │   └── database.sql
│   └── src/
│       └── main/
│           └── kotlin/
│               └── com/
│                   └── tuteladana/
│                       ├── config/
│                       ├── controller/
│                       ├── model/
│                       └── repository/
├── TutelaFinalVersion/
│   ├── assets/
│   ├── carrito/
│   ├── contacto/
│   ├── emails/
│   ├── includes/
│   ├── mensajes/
│   ├── pedidos/
│   ├── users/
│   ├── index.php
│   ├── login.php
│   ├── register.php
│   ├── servicios.php
│   ├── servicios_alimentos.php
│   ├── servicios_limpieza.php
│   ├── servicios_ropa.php
│   ├── quienes_somos.php
│   └── logout.php
└── ...
```

## Cómo usar la aplicación

1. Accede a la landing page principal.
2. Registra una cuenta o inicia sesión si ya tienes usuario.
3. Explora los servicios disponibles para ayuda y apoyo.
4. Selecciona los productos o recursos necesarios y añádelos al carrito.
5. Completa el proceso de pedido.
6. Consulta tu perfil, historial y mensajes dentro de la plataforma.
7. Usa la herramienta como una solución para la coordinación de ayuda y asistencia humanitaria.

## Guardado del progreso

La aplicación mantiene la información del usuario en la base de datos MySQL y utiliza sesiones PHP para conservar el estado de navegación y la autenticación. Esto permite que el usuario acceda de forma persistente a su perfil, pedidos, mensajes y contexto de ayuda dentro de la plataforma.

## Créditos

Proyecto desarrollado con un enfoque solidario y social para apoyar a las personas afectadas por la DANA, combinando una experiencia web accesible con una API moderna en Kotlin para gestionar la lógica del sistema y los datos de la aplicación.
