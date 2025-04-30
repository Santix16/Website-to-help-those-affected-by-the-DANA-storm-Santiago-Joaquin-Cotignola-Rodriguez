<?php session_start(); ?>
<?php include("includes/header.php"); ?>

<!-- Banner -->
<section id="banner">
    <h2>Nuestros Servicios</h2>
    <p>Accede a apoyo alimentario, productos esenciales y más, todo en un solo lugar.</p>
    <ul class="actions">
        <li><a href="#servicios" class="button special big">Explorar Servicios</a></li>
    </ul>
</section>

<!-- Sección de Categorías -->
<section id="servicios" class="wrapper style2 special">
    <div class="container">
        <header class="major">
            <h2>Categorías Principales</h2>
            <p>Selecciona el tipo de servicio que necesitas</p>
        </header>
        <div class="row 150%">
            <!-- Alimentos -->
            <div class="4u 12u$(medium)">
                <div class="image fit captioned">
                    <img src="images/alimentos.jpg" alt="Alimentos" />
                    <h3>Alimentos</h3>
                    <p>Agua potable, comidas preparadas, frutas y verduras.</p>
                    <?php if (isset($_SESSION['usuario_id'])): ?>
                        <a href="servicio_alimentos.php" class="button small">Solicitar</a>
                    <?php else: ?>
                        <a href="login.html" class="button small">Solicitar</a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Limpieza -->
            <div class="4u 12u$(medium)">
                <div class="image fit captioned">
                    <img src="images/limpieza.jpg" alt="Limpieza" />
                    <h3>Limpieza</h3>
                    <p>Productos de higiene personal y limpieza del hogar.</p>
                    <?php if (isset($_SESSION['usuario_id'])): ?>
                        <a href="servicio_limpieza.php" class="button small">Solicitar</a>
                    <?php else: ?>
                        <a href="login.html" class="button small">Solicitar</a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Ropa -->
            <div class="4u 12u$(medium)">
                <div class="image fit captioned">
                    <img src="images/ropa.jpg" alt="Ropa" />
                    <h3>Ropa</h3>
                    <p>Ropa donada, mantas y calzado de emergencia.</p>
                    <?php if (isset($_SESSION['usuario_id'])): ?>
                        <a href="servicio_ropa.php" class="button small">Solicitar</a>
                    <?php else: ?>
                        <a href="login.html" class="button small">Solicitar</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include("includes/footer.php"); ?>
