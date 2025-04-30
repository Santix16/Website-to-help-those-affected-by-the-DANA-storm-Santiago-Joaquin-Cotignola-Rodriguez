<?php
session_start();
include("includes/header.php");

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}
?>

<section id="servicio-ropa" class="wrapper style1">
    <div class="container">
        <header class="major">
            <h2>Servicios de Ropa</h2>
            <p>Ropa de emergencia para personas afectadas por la DANA. Selecciona el tipo que necesitas.</p>
        </header>

        <div class="box alt">
            <div class="row uniform 50%">

                <div class="4u 12u$(medium)">
                    <span class="image fit"><img src="images/ropa_interior.jpg" alt="Ropa interior y calcetines" /></span>
                    <h4>Ropa interior y calcetines nuevos</h4>
                    <a href="formulario_solicitud.php?tipo=ropa_interior" class="button small">Solicitar</a>
                </div>

                <div class="4u 12u$(medium)">
                    <span class="image fit"><img src="images/camisetas_pantalones.jpg" alt="Camisetas y pantalones" /></span>
                    <h4>Camisetas y pantalones</h4>
                    <a href="formulario_solicitud.php?tipo=camisetas_pantalones" class="button small">Solicitar</a>
                </div>

                <div class="4u 12u$(medium)">
                    <span class="image fit"><img src="images/abrigos.jpg" alt="Abrigos y mantas" /></span>
                    <h4>Abrigos y mantas térmicas</h4>
                    <a href="formulario_solicitud.php?tipo=abrigos_mantas" class="button small">Solicitar</a>
                </div>

                <div class="4u 12u$(medium)">
                    <span class="image fit"><img src="images/ropa_cama.jpg" alt="Ropa de cama" /></span>
                    <h4>Ropa de cama (sábanas, toallas)</h4>
                    <a href="formulario_solicitud.php?tipo=ropa_cama" class="button small">Solicitar</a>
                </div>

                <div class="4u 12u$(medium)">
                    <span class="image fit"><img src="images/zapatos.jpg" alt="Zapatos cerrados" /></span>
                    <h4>Zapatos cerrados</h4>
                    <a href="formulario_solicitud.php?tipo=zapatos" class="button small">Solicitar</a>
                </div>

                <div class="4u 12u$(medium)">
                    <span class="image fit"><img src="images/ropa_ninos.jpg" alt="Ropa para niños" /></span>
                    <h4>Ropa para niños</h4>
                    <a href="formulario_solicitud.php?tipo=ropa_ninos" class="button small">Solicitar</a>
                </div>

            </div>
        </div>

    </div>
</section>

<?php include("includes/footer.php"); ?>
