<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    include("includes/db.php");

    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    try {
        // Verificar si ya existe el email
        $stmt = $conexion->prepare("SELECT id_usuario FROM usuarios WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $error = "Este correo ya está registrado.";
        } else {
            // Insertar usuario nuevo
            $stmt = $conexion->prepare("
                INSERT INTO usuarios (nombre, email, contraseña, tonkens, fecha_registro)
                VALUES (:nombre, :email, :password, '', NOW())
            ");
            $stmt->execute([
                ':nombre' => $nombre,
                ':email' => $email,
                ':password' => $passwordHash
            ]);

            header("Location: login.php?registro=1");
            exit();
        }
    } catch (PDOException $e) {
        $error = "Error en la base de datos: " . $e->getMessage();
    }
}
?>



<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registro - Tutela La DANA</title>
  <link rel="stylesheet" href="assets/css/main.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body class="landing">

<!-- Header dinámico -->
<header id="header" class="alt">
  <h1><strong><a href="index.php">Tutela La DANA</a></strong></h1>
  <nav id="nav">
    <ul>
      <li><a href="index.php">Inicio</a></li>
      <li><a href="servicios.php">Servicios</a></li>
      <li><a href="quienes_somos.html">Quiénes Somos</a></li>
      <li><a href="contacto/contacto.php">Contacto</a></li>
      <li><a href="carrito/index.php">Carrito</a></li>
      <li><a href="users/perfil.php">Usuario</a></li>
      <li><a href="mensajes/inbox.php">Mensaje</a></li>
      <li><a href="pedidos/historial.php">Pedidos</a></li>
      <?php if (isset($_SESSION['usuario'])): ?>
        <li><a href="logout.php">Cerrar sesión</a></li>
      <?php else: ?>
        <li><a href="login.php">Login</a></li>
      <?php endif; ?>
    </ul>
  </nav>
</header>

<!-- Sección principal -->
<section id="main" class="wrapper style1" style="padding: 6em 0; display: flex; justify-content: center; align-items: center; min-height: 80vh;">
  <div class="container" style="max-width: 600px;">
    <header class="major special">
      <h2>Crear Cuenta</h2>
      <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
      <?php endif; ?>
      <p>Regístrate para acceder a todos los servicios de ayuda.</p>
    </header>

    <section>
      <form method="POST" action="register.php" class="alt">
        <div class="row uniform 50%">
          <div class="12u$">
            <input type="text" name="nombre" placeholder="Nombre completo" required />
          </div>
          <div class="12u$">
            <input type="email" name="email" placeholder="Correo electrónico" required />
          </div>
          <div class="12u$">
            <input type="password" name="password" placeholder="Contraseña" required />
          </div>
          <div class="12u$">
            <ul class="actions">
              <li><input type="submit" value="Registrarse" class="special" /></li>
            </ul>
          </div>
        </div>
      </form>
      <p style="text-align: center;">¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a></p>
    </section>
  </div>
</section>

<!-- Footer -->
<footer id="footer" style="padding: 0.8em 0; background: #f5f5f5; font-size: 0.8em; text-align: center;">
  <div class="container">
    <p style="margin: 0;">© 2025 Tutela La DANA. Todos los derechos reservados.</p>
    <a href="legal/legal.html">Términos de Uso</a> |
    <a href="legal/privacidad.html">Protección de Datos</a>
  </div>
</footer>

<!-- Scripts -->
<script src="js/jquery.min.js"></script>
<script src="js/skel.min.js"></script>
<script src="js/skel-layers.min.js"></script>
<script src="js/init.js"></script>

</body>
</html>
