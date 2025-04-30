<?php
session_start();
include("includes/header.php");
/*
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}
    */
?>
<section id="servicio-comida" class="wrapper style1">
    <div class="container">
        <header class="major">
            <h2>Servicios de Comida</h2>
            <p>Alimentos disponibles para personas afectadas por la DANA. Puedes solicitar cada producto individualmente según tus necesidades.</p>
        </header>

        <div class="box alt">
            <div class="row uniform 50%">

                <div class="4u 12u$(medium)">
                    <span class="image fit"><img src="images/comida_preparada.jpg" alt="Comida preparada" /></span>
                    <h4>Comida preparada (listo para calentar)</h4>
                    <a href="formulario_solicitud.php?tipo=comida_preparada" class="button small">Solicitar</a>
                </div>

                <div class="4u 12u$(medium)">
                    <span class="image fit"><img src="images/conservas.jpg" alt="Latas de conserva" /></span>
                    <h4>Latas de conserva (atún, legumbres, sopa)</h4>
                    <a href="formulario_solicitud.php?tipo=conservas" class="button small">Solicitar</a>
                </div>

                <div class="4u 12u$(medium)">
                    <span class="image fit"><img src="images/pan_galletas.jpg" alt="Pan y galletas" /></span>
                    <h4>Pan y galletas secas</h4>
                    <a href="formulario_solicitud.php?tipo=pan_galletas" class="button small">Solicitar</a>
                </div>

                <div class="4u 12u$(medium)">
                    <span class="image fit"><img src="images/leche.jpg" alt="Leche en polvo" /></span>
                    <h4>Leche en polvo o UHT</h4>
                    <a href="formulario_solicitud.php?tipo=leche" class="button small">Solicitar</a>
                </div>

                <div class="4u 12u$(medium)">
                    <span class="image fit"><img src="images/agua.jpg" alt="Agua potable" /></span>
                    <h4>Agua potable embotellada (1L o 5L)</h4>
                    <a href="formulario_solicitud.php?tipo=agua" class="button small">Solicitar</a>
                </div>

                <div class="4u 12u$(medium)">
                    <span class="image fit"><img src="images/frutas.jpg" alt="Frutas" /></span>
                    <h4>Frutas no perecederas</h4>
                    <a href="formulario_solicitud.php?tipo=frutas" class="button small">Solicitar</a>
                </div>

                <div class="4u 12u$(medium)">
                    <span class="image fit"><img src="images/arroz_pasta.jpg" alt="Arroz y pasta" /></span>
                    <h4>Paquetes de arroz y pasta</h4>
                    <a href="formulario_solicitud.php?tipo=arroz_pasta" class="button small">Solicitar</a>
                </div>

            </div>
        </div>

    </div>
</section>

<?php include("includes/footer.php"); ?>
