$env:APP_HOST = "0.0.0.0"
$env:APP_PORT = "8080"
$env:DB_URL = "jdbc:mysql://localhost:3306/tele_dana?useSSL=false&allowPublicKeyRetrieval=true&serverTimezone=UTC"
$env:DB_USER = "root"
$env:DB_PASSWORD = ""

Write-Host "Base de datos: tele_dana"
Write-Host "API: http://localhost:8080"
Write-Host "Health: http://localhost:8080/health"
Write-Host "Arrancando backend..."

.\gradlew.bat run
