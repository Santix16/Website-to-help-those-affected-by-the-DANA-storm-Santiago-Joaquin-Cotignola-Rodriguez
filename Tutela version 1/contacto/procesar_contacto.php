<?php
// Configuración de la base de datos
$host = "localhost";
$usuario = "root";       // Ajusta según tu configuración de XAMPP
$contrasena = "";        // Por defecto, XAMPP usa contraseña vacía para "root"
$base_datos = "tele_dana";

// Crear conexión
$conexion = new mysqli($host, $usuario, $contrasena, $base_datos);

// Verificar conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Recoger datos del formulario
$nombre = $_POST['nombre'];
$email = $_POST['email'];
$mensaje = $_POST['mensaje'];

// Preparar la consulta
$stmt = $conexion->prepare("INSERT INTO contacto (nombre, email, mensaje) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $nombre, $email, $mensaje);

// Ejecutar la inserción
if ($stmt->execute()) {
    // Redirigir a contacto.php con el parámetro success=1
    header("Location: contacto.php?success=1");
    exit;
} else {
    echo "Error al guardar el mensaje: " . $stmt->error;
}

$stmt->close();
$conexion->close();
?>
