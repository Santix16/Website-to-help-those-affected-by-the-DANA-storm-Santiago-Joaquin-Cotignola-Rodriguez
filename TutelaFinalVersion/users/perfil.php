<?php
session_start();

// Verificar que el usuario esté autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit();
}

$usuario = $_SESSION['usuario']; // Ya es seguro acceder a esta variable
?>

<!DOCTYPE HTML>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Perfil - TELE-DANA</title>
    <link rel="stylesheet" href="../assets/css/main.css">
</head>
<body class="landing">

    <!-- Incluir el encabezado -->
    <?php include("../includes/header.php"); ?>

    <!-- Banner -->
    <section id="banner">
        <h2>Bienvenido, <?php echo htmlspecialchars($usuario['nombre']); ?></h2>
        <p>Estos son tus datos de perfil. Puedes editarlos en cualquier momento.</p>
    </section>

    <!-- Contenido principal del perfil -->
    <section id="main-content" class="wrapper style1">
        <div class="container">
            <h3>Tu Información:</h3>
            <div class="row 200%">
                <div class="6u 12u$(medium)">
                    <p><strong>Nombre:</strong> <?php echo htmlspecialchars($usuario['nombre']); ?></p>
                </div>
                <div class="6u$ 12u$(medium)">
                    <p><strong>Correo Electrónico:</strong> <?php echo htmlspecialchars($usuario['email']); ?></p>
                </div>
            </div>
            <div class="row 200%">
                <div class="6u 12u$(medium)">
                    <p><strong>Teléfono:</strong> <?php echo isset($usuario['telefono']) ? htmlspecialchars($usuario['telefono']) : 'No disponible'; ?></p>
                </div>
                <div class="6u$ 12u$(medium)">
                    <p><strong>Sobre mí:</strong> <?php echo isset($usuario['sobre_mi']) ? htmlspecialchars($usuario['sobre_mi']) : 'No disponible'; ?></p>
                </div>
            </div>
            <div class="row 200%">
                <div class="6u 12u$(medium)">
                    <p><strong>Valoración:</strong> <?php echo isset($usuario['valoracion']) ? htmlspecialchars($usuario['valoracion']) : 'No disponible'; ?></p>
                </div>
                <div class="6u$ 12u$(medium)">
                    <p><strong>Productos en venta:</strong> <?php echo isset($usuario['productos']) ? htmlspecialchars(implode(", ", $usuario['productos'])) : 'No disponible'; ?></p>
                </div>
            </div>

            <!-- Enlace al perfil privado -->
            <a href="perfil_privado.php" class="button special big">Actualizar Perfil</a>
        </div>
    </section>

    <footer id="footer">
        <div class="container">
            <ul class="icons">
                <li><a href="#" class="icon fa-facebook"></a></li>
                <li><a href="#" class="icon fa-twitter"></a></li>
                <li><a href="#" class="icon fa-instagram"></a></li>
            </ul>
        </div>
    </footer>

    <div class="copyright">
        &copy; 2025 Tutela La DANA. Todos los derechos reservados.
    </div>

</body>
</html>










