# Tutela DANA - Backend Kotlin + MySQL

Backend de la plataforma de ayuda a personas afectadas por la DANA. Esta version migra la logica principal del proyecto PHP a una API REST en Kotlin con Ktor y MySQL.

## Funcionalidades

- Registro e inicio de sesion.
- Contraseñas almacenadas con hash BCrypt.
- Consulta de usuarios sin exponer contraseñas.
- Listado y gestion de productos.
- Creacion e historial de pedidos por usuario.
- Envio y consulta de mensajes de contacto.
- Persistencia en MySQL mediante HikariCP.
- Configuracion mediante variables de entorno.

## Tecnologias

- Kotlin 1.9.24
- Ktor 2.3.12
- Gradle Wrapper 8.7
- MySQL 8+
- HikariCP
- BCrypt
- Logback

## Requisitos

- Java 21 (el proyecto compila con JVM target 21).
- MySQL 8+ instalado y ejecutandose en `localhost:3306`.
- MySQL Workbench es opcional y sirve para ejecutar el esquema.

## Crear la base de datos con MySQL Workbench

1. Abre una conexion a `127.0.0.1`, puerto `3306`, usuario `root` y la contraseña de tu instalacion de MySQL.
2. Abre `database/database.sql`.
3. Ejecuta todo el script con el boton del rayo.
4. Comprueba que existe la base `tele_dana` y las tablas `usuarios`, `productos`, `pedidos`, `pedidos_productos`, `contacto` y `mensajes`.

Tambien puedes ejecutar el script desde el cliente de MySQL:

```sql
SOURCE C:/ruta/absoluta/TutelaDANA-KotlinBackend/database/database.sql;
```

## Configurar y arrancar en Windows

Desde PowerShell, situado en `TutelaDANA-KotlinBackend`:

```powershell
$env:DB_URL="jdbc:mysql://127.0.0.1:3306/tele_dana?useSSL=false&allowPublicKeyRetrieval=true&serverTimezone=UTC"
$env:DB_USER="root"
$env:DB_PASSWORD="TU_CONTRASENA_MYSQL"
.\gradlew.bat run
```

Si el usuario `root` no tiene contraseña:

```powershell
$env:DB_PASSWORD=""
.\gradlew.bat run
```

Tambien puedes usar el script incluido:

```powershell
.\start-local.ps1
```

La API se inicia en `http://localhost:8080`.

## Comprobacion rapida

```powershell
Invoke-RestMethod http://localhost:8080/health
```

Respuesta esperada:

```json
{"status":"ok"}
```

## Endpoints

| Metodo | Ruta | Funcion |
|---|---|---|
| GET | `/health` | Comprueba que la API esta activa |
| POST | `/api/auth/register` | Registra un usuario |
| POST | `/api/auth/login` | Inicia sesion |
| GET | `/api/users` | Lista usuarios sin contraseñas |
| GET | `/api/products` | Lista productos |
| POST | `/api/orders` | Crea un pedido |
| POST | `/api/contact` | Guarda un mensaje de contacto |

## Probar registro y login

El registro exige una contraseña de al menos 8 caracteres:

```powershell
Invoke-RestMethod -Method Post `
  -Uri http://localhost:8080/api/auth/register `
  -ContentType "application/json" `
  -Body '{"nombre":"Ana","email":"ana@test.com","password":"12345678","tonkens":0}'
```

```powershell
Invoke-RestMethod -Method Post `
  -Uri http://localhost:8080/api/auth/login `
  -ContentType "application/json" `
  -Body '{"email":"ana@test.com","password":"12345678"}'
```

Consulta de productos:

```powershell
Invoke-RestMethod http://localhost:8080/api/products
```

## Comandos Gradle

```powershell
.\gradlew.bat compileKotlin
.\gradlew.bat test
.\gradlew.bat run
```

## Estructura

```text
TutelaDANA-KotlinBackend/
|-- database/
|   `-- database.sql
|-- src/main/kotlin/com/tuteladana/
|   |-- config/
|   |-- controller/
|   |-- model/
|   `-- repository/
|-- .env.example
|-- build.gradle.kts
|-- docker-compose.yml
|-- gradlew
|-- gradlew.bat
|-- start-local.ps1
`-- README.md
```

## Docker opcional

Si no quieres usar el MySQL instalado localmente, Docker Compose puede levantar una instancia independiente:

```powershell
docker compose up -d mysql
```

En ese caso utiliza `DB_USER=tele_dana` y `DB_PASSWORD=tele_dana_local`. No uses ambas instalaciones en el puerto 3306 al mismo tiempo.

## Seguridad y limites actuales

- Las contraseñas no se devuelven en las respuestas HTTP.
- Las contraseñas se almacenan con BCrypt.
- El endpoint de usuarios no incluye autorizacion de administrador; antes de publicar la API debe protegerse con autenticacion y roles.
- La API todavia no implementa tokens JWT ni un cliente web/movil.
