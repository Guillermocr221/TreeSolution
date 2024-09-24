<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="/estilos/Dashboard.css">
</head>
<body>
    <header class="header">
        <div class="header__logo">TreeSolution</div>
        <nav class="header__nav">
            <ul class="header__nav-list">
                <li class="header__nav-item"><a href="/" class="header__nav-link">Inicio</a></li>
                <li class="header__nav-item"><a href="#" class="header__nav-link">Sobre nosotros</a></li>
                <li class="header__nav-item"><a href="#" class="header__nav-link">Contáctanos</a></li>
            </ul>
        </nav>
        <div class="header__search-container">
            <input type="text" class="header__search" placeholder="Buscar productos">
            <button class="header__search-button"><img src="/imagenes/lupa.png" alt="Buscar" class="header__search-icon"></button>
        </div>
        <div class="header__actions">
            <img src="/imagenes/user.png" alt="Perfil" class="header__action-icon" style="width: 30px; height: 30px;">
            <div class="dropdown-menu" id="userMenu">
                <a href="perfil.html">Ver perfil</a>
                <a href="/logout" id="logout">Cerrar sesión</a>
            </div>
            <div class="cart-icon-container">
                <img src="/imagenes/Cart-icon.png" alt="Carrito" class="header__action-icon" id="cartIcon" style="width: 30px; height: 30px;">
                <span id="cartCount" class="cart-count">0</span>
            </div>
        </div>
    </header>
 
    <main class="container">
        <div class="product" data-name="POLO BON STYLE SPACE" data-price="49.90">
            <img src="/imagenes/producto1.jpg" alt="Polo Bon Style Space">
            <div class="info">
                <h3>GENÉRICO</h3>
                <p>POLO BON STYLE SPACE</p>
                <p>Por Bon Style</p>
                <p>S/ 49.90</p>
            </div>
        </div>
        <div class="product" data-name="POLO BON STYLE PANDA VEC" data-price="49.90">
            <img src="/imagenes/producto1.jpg" alt="Polo Bon Style Panda Vec">
            <div class="info">
                <h3>GENÉRICO</h3>
                <p>POLO BON STYLE PANDA VEC</p>
                <p>Por Bon Style</p>
                <p class="price">
                    <span class="discount">S/ 34.90</span>
                    <span class="original-price">S/ 49.90</span>
                </p>
            </div>
        </div>
        <div class="product" data-name="Casaca Casual Hombre Mango" data-price="72">
            <img src="/imagenes/producto2.jpg" alt="Casaca Casual Hombre Mango">
            <div class="info">
                <h3>MANGO</h3>
                <p>Casaca Casual Hombre Mango</p>
                <p>Por Falabella</p>
                <p>S/ 72</p>
            </div>
        </div>
        <div class="product" data-name="Casaca Hombre Bearcliff" data-price="159.90">
            <img src="/imagenes/producto2.jpg" alt="Casaca Hombre Bearcliff">
            <div class="info">
                <h3>BEARCLIFF</h3>
                <p>Casaca Hombre Bearcliff</p>
                <p>Por Falabella</p>
                <p>S/ 159.90</p>
            </div>
        </div>
        <div class="product" data-name="POLO BON STYLE SPACE" data-price="49.90">
            <img src="/imagenes/producto1.jpg" alt="Polo Bon Style Space">
            <div class="info">
                <h3>GENÉRICO</h3>
                <p>POLO BON STYLE SPACE</p>
                <p>Por Bon Style</p>
                <p>S/ 49.90</p>
            </div>
        </div>
        <div class="product" data-name="POLO BON STYLE PANDA VEC" data-price="34.90">
            <img src="/imagenes/producto1.jpg" alt="Polo Bon Style Panda Vec">
            <div class="info">
                <h3>GENÉRICO</h3>
                <p>POLO BON STYLE PANDA VEC</p>
                <p>Por Bon Style</p>
                <p class="price">
                    <span class="discount">S/ 34.90</span>
                    <span class="original-price">S/ 49.90</span>
                </p>
            </div>
        </div>
        <div class="product" data-name="Casaca Casual Hombre Mango" data-price="75">
            <img src="/imagenes/producto2.jpg" alt="Casaca Casual Hombre Mango">
            <div class="info">
                <h3>MANGO</h3>
                <p>Casaca Casual Hombre Mango</p>
                <p>Por Falabella</p>
                <p>S/ 75</p>
            </div>
        </div>
        <div class="product" data-name="Casaca Hombre Bearcliff" data-price="120">
            <img src="/imagenes/producto2.jpg" alt="Casaca Hombre Bearcliff">
            <div class="info">
                <h3>BEARCLIFF</h3>
                <p>Casaca Hombre Bearcliff</p>
                <p>Por Falabella</p>
                <p>S/ 120</p>
            </div>
        </div>
        
    </main>
    <div id="productModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <img id="modalImage" src="" alt="Product Image">
            <h3 id="modalName">Product Name</h3>
            <p id="modalPrice">Price: S/ 0.00</p>
            <p id="modalColors">Available Colors: </p>
            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" min="1" value="1">
            <button id="addToCart">Add to Cart</button>
        </div>
    </div>
    <div id="cartModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h3>Carrito de Compras</h3>
            <ul id="cartItems"></ul>
            <p id="totalPrice">Total: S/ 0.00</p>
            <button id="checkout">Pagar</button>
            <button id="cancel">Cancelar</button>
        </div>
    </div>
    <footer class="footer">
        <p>&copy; 2024 TreeSolution. Todos los derechos reservados.</p>
    </footer>
    <script src="/scripts/Dashboard.js"></script>
</body>

</html>

