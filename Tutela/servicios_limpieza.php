<?php
session_start();
include("includes/header.php");

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}
?>

<section id="servicio-limpieza" class="wrapper style1">
    <div class="container">
        <header class="major">
            <h2>Servicios de Limpieza</h2>
            <p>Productos de higiene personal y limpieza del hogar para personas afectadas por la DANA.</p>
        </header>

        <div class="box alt">
            <div class="row uniform 50%">

                <div class="4u 12u$(medium)">
                    <span class="image fit"><img src="images/kit_higiene.jpg" alt="Kit de higiene personal" /></span>
                    <h4>Kit de higiene personal</h4>
                    <a href="formulario_solicitud.php?tipo=kit_higiene" class="button small">Solicitar</a>
                </div>

                <div class="4u 12u$(medium)">
                    <span class="image fit"><img src="images/toallitas_papel.jpg" alt="Toallas húmedas y papel higienico" /></span>
                    <h4>Toallas húmedas y papel higienico</h4>
                    <a href="formulario_solicitud.php?tipo=toallitas_papel" class="button small">Solicitar</a>
                </div>

                <div class="4u 12u$(medium)">
                    <span class="image fit"><img src="images/detergente.jpg" alt="Detergente multiusos" /></span>
                    <h4>Detergente multiusos</h4>
                    <a href="formulario_solicitud.php?tipo=detergente" class="button small">Solicitar</a>
                </div>

                <div class="4u 12u$(medium)">
                    <span class="image fit"><img src="images/guantes.jpg" alt="Guantes de limpieza" /></span>
                    <h4>Guantes de limpieza</h4>
                    <a href="formulario_solicitud.php?tipo=guantes" class="button small">Solicitar</a>
                </div>

                <div class="4u 12u$(medium)">
                    <span class="image fit"><img src="images/esponjas_bolsas.jpg" alt="Esponjas y bolsas de basura" /></span>
                    <h4>Esponjas y bolsas de basura</h4>
                    <a href="formulario_solicitud.php?tipo=esponjas_bolsas" class="button small">Solicitar</a>
                </div>

                <div class="4u 12u$(medium)">
                    <span class="image fit"><img src="images/desinfectante.jpg" alt="Desinfectante" /></span>
                    <h4>Desinfectante (lejía, amoníaco, alcohol)</h4>
                    <a href="formulario_solicitud.php?tipo=desinfectante" class="button small">Solicitar</a>
                </div>

                <div class="4u 12u$(medium)">
                    <span class="image fit"><img src="images/mascarillas_gel.jpg" alt="Mascarillas y gel" /></span>
                    <h4>Mascarillas y gel hidroalcohólico</h4>
                    <a href="formulario_solicitud.php?tipo=mascarillas_gel" class="button small">Solicitar</a>
                </div>

            </div>
        </div>

    </div>
</section>

<?php include("includes/footer.php"); ?>