<!DOCTYPE html>
<html lang="es">
<head>
    <!-- fzxczxczczxcqqqqqaaaaaaaaaaaaaaaaa -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TreeSolution</title>
    <link rel="stylesheet" href="/estilos/index.css">
</head>
<body>
    <header class="header">
        <div class="header__logo">TreeSolution</div>
        <nav class="header__nav">
            <ul class="header__nav-list">
                <li class="header__nav-item"><a href="#" class="header__nav-link">Inicio</a></li>
                <li class="header__nav-item"><a href="#" class="header__nav-link">Sobre nosotros</a></li>
                <li class="header__nav-item"><a href="#" class="header__nav-link">Contáctanos</a></li>
            </ul>
        </nav>
        <div class="header__actions">
            <input type="text" class="header__search" placeholder="Buscar productos">
            <button class="header__search-button"><img src="/imagenes/lupa.png" alt="Buscar" class="header__search-icon"></button>
            <button class="header__button" id="registrarButton" style="<?php
                                                    session_start();
                                                    if(!$_SESSION == []){
                                                        echo "display:none;";
                                                    } 
                                                    ?>">Registrarse</button>
            <button class="header__button" id="loginButton" style="<?php
                                                    session_start();
                                                    if(!$_SESSION == []){
                                                        echo "display:none;";
                                                    } 
                                                    ?>">Iniciar Sesión</button>
            <button class="header__cart-button"><img src="/imagenes/cart-icon.png" alt="Carrito" class="header__cart-icon"></button>
        </div>
    </header>
    <main class="main">
        <div class="main__overlay"></div>
        <section class="hero">
            <div class="hero__content">
                <h1 class="hero__title">Diseñada para los que no se rinden: supera tus metas con cada prenda, llevando estilo y funcionalidad al siguiente nivel</h1>
                <p class="hero__text">Descubre en nuestra tienda virtual una selección exclusiva de ropa deportiva diseñada para maximizar tu rendimiento y mantenerte a la vanguardia del estilo y la comodidad</p>
                <button class="hero__button" id="exploButton" onclick="redirectToProducts()">Explorar productos</button>
            </div>
        </section>
    </main>
    <footer class="footer">
        <p>&copy; 2024 TreeSolution. Todos los derechos reservados.</p>
    </footer>
    <script>
        function redirectToProducts() {
            <?php 
            session_start(); 
            if(empty($_SESSION)) {
                echo 'window.location.href = "/login";';
            } else {
                echo 'window.location.href = "/dashboard";';
            }
            ?>
        }
    </script>
    <script src="/scripts/index.js"></script>
</body>
</html>

