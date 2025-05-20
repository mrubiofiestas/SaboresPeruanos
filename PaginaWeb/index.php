<?php
session_start();

$logueado = isset($_SESSION['email']);
$nombreUsuario = $logueado ? $_SESSION['nombre'] : '';

$boton_carrito = $logueado ? '<button class="btn-agregar">Agregar al carrito</button>' : '';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sabores Peruanos</title>
    <link rel="stylesheet" href="./CSS/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@700&family=Poppins&display=swap" rel="stylesheet">
</head>

<body>
    <!-- Cabecera -->
    <header>
        <img src="./img/logo_SP.png" alt="Logo Sabores Peruanos" class="logo">
        <nav>
            <a href="index.php">Inicio</a>
            <a href="./Vista/galeria.html">Galería</a>
            <a href="./Vista/menu.html">Menú</a>
            <a href="./Vista/contacto.html">Contacto</a>

            <?php if (!$logueado): ?>
                <a href="./Vista/login.html">Login</a>
            <?php else: ?>
                <div class="perfil-usuario">
                    <span><?= htmlspecialchars($nombreUsuario) ?> ⬇</span>
                    <ul class="menu-perfil">
                        <li><a href="#">Mi cuenta</a></li>
                        <li><a href="./Controlador/controlador_logout.php">Cerrar sesión</a></li>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if ($logueado): ?>
                <a href="./Vista/carrito.php">Carrito</a>
            <?php endif; ?>
        </nav>
    </header>

    <!-- Bienvenida -->
    <main>
        <div class="imagen_centro">
            <h1>Sabores Peruanos - Bar Tapas</h1>
        </div>

        <!-- Galería de Platos -->
        <section class="galeria-inicio">
            <h3>Platos Destacados</h3>
            <div class="fila-platos">
                <div>
                    <img src="img/ceviche.jpg" alt="Ceviche">
                    <?= $boton_carrito ?>
                </div>
                <div>
                    <img src="img/lomo_a_la_huancaina.jpg" alt="Lomo a la Huancaína">
                    <?= $boton_carrito ?>
                </div>
                <div>
                    <img src="img/trio_marino.jpg" alt="Trío Marino">
                    <?= $boton_carrito ?>
                </div>
                <div>
                    <img src="img/pollo_a_la_brasa.jpg" alt="Pollo a la brasa">
                    <?= $boton_carrito ?>
                </div>
            </div>
            <a href="./Vista/galeria.html" class="boton-vermenu">Ver más</a>
        </section>

        <!-- Historia -->
        <section class="historia">
            <h3>Nuestra Historia</h3>
            <p>Sabores Peruanos nació en 2018 con la idea de traer los sabores auténticos del Perú a nuestra comunidad. Desde entonces, hemos sido un espacio donde la comida une culturas y crea momentos inolvidables.</p>
            <p>Detrás de cada plato está Silvia Fiestas, una apasionada chef peruana que decidió compartir las recetas tradicionales de su familia. Su amor por la cocina se refleja en cada detalle del restaurante.</p>
            <a href="./Vista/galeria.html" class="boton-vermenu">Conocer más</a>
        </section>

        <!-- Ubicación -->
        <section class="ubicacion">
            <div class="ubicacion-texto">
                <h2>¿Dónde estamos?</h2>
                <p>Nos encontramos en el corazón de la ciudad, ofreciendo lo mejor de la gastronomía peruana. ¡Ven a visitarnos y vive la experiencia Sabores Peruanos!</p>
            </div>
            <div class="ubicacion-mapa">
                <iframe src="https://www.google.com/maps/embed?pb=..." width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 Sabores Peruanos - Todos los derechos reservados</p>
    </footer>
</body>

</html>