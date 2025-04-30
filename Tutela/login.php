<?php
session_start();

// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'tele_dana');

if ($conn->connect_error) {
    die('Error de conexión: ' . $conn->connect_error);
}

// Obtener datos del formulario
$email = $_POST['email'];
$password = $_POST['password'];

// Buscar usuario por email
$sql = "SELECT * FROM usuarios WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();

// Validar existencia del usuario
if ($result->num_rows === 1) {
    $usuario = $result->fetch_assoc();

    // Verificar contraseña
    if (password_verify($password, $usuario['contraseña'])) {
        // Guardar todos los datos relevantes en la sesión
        $_SESSION['usuario'] = [
            'id' => $usuario['id'],
            'nombre' => $usuario['nombre'],
            'email' => $usuario['email'],
            'telefono' => $usuario['telefono'],
            'sobre_mi' => $usuario['sobre_mi'],
            'rol' => $usuario['rol']
        ];

        header('Location: ../perfil/perfil.php');
        exit();
    } else {
        // Contraseña incorrecta
        header('Location: login.html?error=1');
        exit();
    }
} else {
    // Usuario no encontrado
    header('Location: login.html?error=1');
    exit();
}
?>

