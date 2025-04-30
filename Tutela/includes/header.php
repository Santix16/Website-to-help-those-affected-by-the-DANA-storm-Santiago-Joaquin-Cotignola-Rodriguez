<?php
if (session_status() == PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutela La Dana</title>
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="landing">
<!-- Header -->
<header id="header" class="alt">
  <h1><strong><a href="index.html">Tutela La DANA</a></strong></h1>
  <nav id="nav">
    <ul>
      <li><a href="index.php">Inicio</a></li>
      <li><a href="servicios.php">Servicios</a></li>
      <li><a href="quienes_somos.html">Quiénes Somos</a></li>
      <li><a href="contacto/contacto.php">Contacto</a></li>
      <li><a href="login.html">Login</a></li>
    </ul>
  </nav>
</header>
<a href="#menu" class="navPanelToggle"><span class="fa fa-bars"></span></a>