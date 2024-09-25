<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="/estilos/Dashboard2.css">
    <link rel="icon" href="/imagenes/favicon-32x32.png" type="images">
    <script src="https://www.paypal.com/sdk/js?client-id=BAA4-z0HoLKi6H13QbbRSaUyE-Sy_63PkNNLda0IJeug388lyPiPLxHG1fz-7FSqrfOnxoHfcUp4c9_Y1Y&components=hosted-buttons&disable-funding=venmo&currency=USD"></script>
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
            <input type="text" id="searchInput" class="header__search" placeholder="Buscar productos">
            <button class="header__search-button" id="searchButton"><img src="/imagenes/lupa.png" alt="Buscar" class="header__search-icon"></button>
        </div>
        
        
        <div class="header__actions">
            <img src="/imagenes/user.png" alt="Perfil" class="header__action-icon" 
                style="width: 30px; height: 30px; <?php
                                                    session_start();
                                                    if($_SESSION == []){
                                                        echo "display:none;";
                                                    } 
                                                    ?>" >
            <div class="dropdown-menu" id="userMenu">
                <a href="#" id="editarPerfil">Editar perfil</a>
                <a href="#" id="verPerfil">Ver perfil</a>
                <a href="/logout" id="logout">Cerrar sesión</a>
            </div>
            <div class="cart-icon-container" >
                <img src="/imagenes/Cart-icon.png" alt="Carrito" class="header__action-icon" id="cartIcon" style="width: 30px; height: 30px;">
                <span id="cartCount" class="cart-count">0</span>
            </div>
        </div>
    </header>
<!-- HTML para el overlay -->
<div id="overlay"></div>

<!-- HTML para el modal de Ver Perfil -->
<div class="modal" id="verPerfilModal">
    <div class="modal-content">
        <span class="close" id="closeVerPerfilModal">&times;</span>
        <h2>Ver Perfil</h2>
        <form id="verPerfilForm">
            <label for="nombres">Nombres:</label>
            <input type="text" id="nombres" name="nombres" readonly>
            <label for="apellidos">Apellidos:</label>
            <input type="text" id="apellidos" name="apellidos" readonly>
            <label for="edad">Edad:</label>
            <input type="text" id="edad" name="edad" readonly>
            <label for="correo">Correo:</label>
            <input type="email" id="correo" name="correo" readonly>
            <label for="celular">Celular:</label>
            <input type="text" id="celular" name="celular" readonly>
            <label for="pais">País:</label>
            <input type="text" id="pais" name="pais" readonly>
            <label for="provincia">Provincia:</label>
            <input type="text" id="provincia" name="provincia" readonly>
            <label for="distrito">Distrito:</label>
            <input type="text" id="distrito" name="distrito" readonly>
            <label for="direccion">Dirección:</label>
            <input type="text" id="direccion" name="direccion" readonly>
            <div class="botones">
                <button type="button" id="closeVerPerfilBtn">Cerrar</button>
            </div>
        </form>
    </div>
</div>

<!-- HTML para el modal de Editar Perfil -->
<div class="modal" id="editarPerfilModal">
    <div class="modal-content">
        <span class="close" id="closeEditarPerfilModal">&times;</span>
        <h2 style="text-align: center;">Editar Perfil</h2>
        <div style="text-align: center;">
            <img src="u1.jpg" alt="Imagen" style="width: 160px; height: 120px;">
        </div>
        <form method="post" action="" id="editarPerfilForm">
            <label for="nombres">Nombres:</label>
            <input type="text" id="nombres" name="nombres">
            <label for="apellidos">Apellidos:</label>
            <input type="text" id="apellidos" name="apellidos">
            <label for="edad">Edad:</label>
            <input type="number" id="edad" name="edad">
            <label for="correo">Correo:</label>
            <input type="email" id="correo" name="correo">
            <label for="celular">Celular:</label>
            <input type="tel" id="celular" name="celular">
            <label for="pais">País:</label>
            <input type="text" id="pais" name="pais">
            <label for="provincia">Provincia:</label>
            <input type="text" id="provincia" name="provincia">
            <label for="distrito">Distrito:</label>
            <input type="text" id="distrito" name="distrito">
            <label for="direccion">Dirección:</label>
            <input type="text" id="direccion" name="direccion">
            <div class="botones">
                <button type="submit" id="submitEditarPerfil">Aceptar</button>
                <button type="button" id="closeEditarPerfilBtn">Cerrar</button>
            </div>
        </form>
    </div>
</div>


    <h1 class="titulo" id="tituloAnimado">
        Bienvenido a nuestra tienda de ventas
    </h1>
    <br/>
    <div class="slider-container">
        <div class="slider">
          <div class="slides">
            <img src="/imagenes/s1.jpg" alt="Image 1">
            <img src="/imagenes/s2.jpg" alt="Image 2">
            <img src="/imagenes/s3.jpg" alt="Image 3">
            <img src="/imagenes/s4.jpg" alt="Image 4">
          </div>
          <button class="prevBtn"><img src="/imagenes/left-arrow.png" alt="Previous"></button>
          <button class="nextBtn"><img src="/imagenes/right-arrow.png" alt="Next"></button>
        </div>
        <div class="dots-container"></div>
      </div>

    <main class="container">
        <div class="sort-container">
            <label for="sortOptions">Ordenar por:</label>
            <select id="sortOptions">
                <option value="default">Seleccione</option>
                <option value="name">Nombre</option>
                <option value="price">Precio</option>
            </select>
        </div>

        <div id="productList" class="product-list">
            <div class="product" data-id= 1 data-name="Polo deportivo azul" data-price="49.90">
                <img src="/imagenes/producto1.jpg" alt="Polo deportivo azul">
                <div class="info">
                    <h3>GENÉRICO</h3>
                    <p>Polo deportivo azul</p>
                    <p>Por tienda y delivery</p>
                    <p>S/ 49.90</p>
                </div>
            </div>
            <div class="product" data-id= 2 data-name="Polo deportivo negro" data-price="49.90">
                <img src="/imagenes/producto2.jpg" alt="Polo deportivo negro">
                <div class="info">
                    <h3>Nike</h3>
                    <p>Polo deportivo negro</p>
                    <p>Por delivery</p>
                    <p class="price">
                        <span class="discount">S/ 34.90</span>
                        <span class="original-price">S/ 49.90</span>
                    </p>
                </div>
            </div>
            <div class="product" data-id= 3 data-name="Short deportivo negro" data-price="42">
                <img src="/imagenes/producto3.jpg" alt="Short deportivo negro">
                <div class="info">
                    <h3>Puma</h3>
                    <p>Short deportivo negro</p>
                    <p>Por tienda y delivery</p>
                    <p>S/ 42</p>
                </div>
            </div>
            <div class="product" data-id= 4 data-name="Casaca Hombre azul" data-price="119.90">
                <img src="/imagenes/producto4.jpg" alt="Casaca Hombre azul">
                <div class="info">
                    <h3>BEARCLIFF</h3>
                    <p>Casaca Hombre azul</p>
                    <p>Por tienda</p>
                    <p>S/ 119.90</p>
                </div>
            </div>
            <div class="product" data-id= 5 data-name="Zapatilla runner" data-price="129.90">
                <img src="/imagenes/producto5.jpg" alt="Zapatilla runner">
                <div class="info">
                    <h3>GENÉRICO</h3>
                    <p>Zapatilla runner</p>
                    <p>Por delivery</p>
                    <p class="price">
                        <span class="discount">S/ 129.90</span>
                        <span class="original-price">S/ 139.90</span>
                    </p>
                </div>
            </div>
            <div class="product" data-id= 6 data-name="Zapatilla runner blanca" data-price="159.90">
                <img src="/imagenes/producto6.jpg" alt="Zapatilla runner blanca">
                <div class="info">
                    <h3>GENÉRICO</h3>
                    <p>Zapatilla runner blanca</p>
                    <p>Por tienda y delivery</p>
                    <p class="price">
                        <span class="discount">S/ 159.90</span>
                        <span class="original-price">S/ 189.90</span>
                    </p>
                </div>
            </div>
            <div class="product" data-id= 7 data-name="Casaca roja para mujer" data-price="120">
                <img src="/imagenes/producto7.jpg" alt="Casaca roja para mujer">
                <div class="info">
                    <h3>GENÉRICO</h3>
                    <p>Casaca roja para mujer</p>
                    <p>Por tienda</p>
                    <p>S/ 120</p>
                </div>
            </div>
            <div class="product" data-id= 8 data-name="Conjunto deportivo para mujer" data-price="179.90">
                <img src="/imagenes/producto8.jpg" alt="Conjunto deportivo para mujer">
                <div class="info">
                    <h3>MANGO</h3>
                    <p>Conjunto deportivo para mujer</p>
                    <p>Por tienda y delivery</p>
                    <p class="price">
                        <span class="discount">S/ 179.90</span>
                        <span class="original-price">S/ 200.90</span>
                    </p>
                </div>
            </div>
        </div>
    </main>


    <div id="productModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <img id="modalImage" src="" alt="Product Image">
            <h3 id="modalName">Producto:</h3>
            <p id="modalPrice">Precio: S/ 0.00</p>
            <p id="modalColors">Tallas: S - M - L - XL</p>
            <label for="quantity">Cantidad: </label>
            <input type="number" id="quantity" name="quantity" min="1" value="1">
            <button id="addToCart">Añadir</button>
        </div>
    </div>
    <div id="cartModal" class="modal">
        <div class="modal-content">
            <img id="modalImage" src="/imagenes/comprando.jpg" alt="Car Image" style="width: 240px; height: 240px;">
            <span class="close">&times;</span>
            <h3>Carrito de Compras</h3>
            <ul id="cartItems"></ul>
            <p id="totalPrice">Total: S/ 0.00</p>
            <button id="checkout">Pagar</button>
            <button id="cancel">Cancelar</button>
        </div>
    </div>

    <div id="payModal" class="modal">
        <h2>Realizar pago</h2>
        <div class="modal-content">
            <!-- <input class="payInput payInput-nombre" type="text" placeholder="Ingrese su nombre" required>
            <input class="payInput payInput-direccion" type="text" placeholder="Ingrese direccion" required>
            <input class="payInput payInput-telefono" type="number" placeholder="Ingrese Numero de Celular" required>
            <input class="payInput payInput-tarjeta" type="numer" placeholder="Ingrese Numero de tarjeta de credito" required>
            <input type="number" class="payInput payInput-fechaVenc" placeholder="mm/yy" required>
            <input type="number" class="payInput payInput-cod" placeholder="csv" required>

            <button id="pagarPedido">Pagar</button> -->
        <div id="paypal-container-MFFA2E9T8BRS2" class="payModal_pagarPedido"></div>
            
        </div>
        
    </div>

    <footer class="footer">
        <p>&copy; 2024 TreeSolution. Todos los derechos reservados.</p>
    </footer>
    
    <script src='//cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script src="/scripts/Dashboard2.js"></script>
    <script>
        paypal.HostedButtons({
            hostedButtonId: "MFFA2E9T8BRS2",
        }).render("#paypal-container-MFFA2E9T8BRS2")
    </script>
    
</body>
</html>