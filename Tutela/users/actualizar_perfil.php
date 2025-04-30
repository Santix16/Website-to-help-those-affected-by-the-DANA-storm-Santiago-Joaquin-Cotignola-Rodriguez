<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario'])) {
    // Si el usuario no está logueado, redirigir a la página de inicio de sesión
    header("Location: ../login.html");
    exit;
}

// Obtener los datos enviados por el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validación de los datos recibidos
    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    $telefono = trim($_POST['telefono']);
    $valoracion = floatval($_POST['valoracion']); // Convertir a número flotante
    $productos = explode(",", trim($_POST['productos'])); // Convertir la cadena en un arreglo
    $password = trim($_POST['password']);

    // Asegurarse de que la valoración esté entre 1 y 5
    if ($valoracion < 1) {
        $valoracion = 1;
    } elseif ($valoracion > 5) {
        $valoracion = 5;
    }

    // Actualizar la información del usuario en la sesión
    $_SESSION['usuario']['nombre'] = $nombre;
    $_SESSION['usuario']['email'] = $email;
    $_SESSION['usuario']['telefono'] = $telefono;
    $_SESSION['usuario']['valoracion'] = $valoracion;
    $_SESSION['usuario']['productos'] = $productos;

    // Si el usuario ha ingresado una nueva contraseña, actualizarla (esto debería ser más seguro en producción)
    if (!empty($password)) {
        $_SESSION['usuario']['password'] = password_hash($password, PASSWORD_DEFAULT); // Utilizamos hash para seguridad
    }

    // Redirigir al perfil con un mensaje de éxito
    header("Location: perfil_privado.php?actualizado=true");
    exit;
}
?>

