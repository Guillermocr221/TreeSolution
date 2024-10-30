<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="/estilos/Dashboard2.css">
    <link rel="icon" href="/imagenes/favicon-32x32.png" type="images">
    <script
            src="https://www.paypal.com/sdk/js?client-id=AQloEfRlpaWaapUG4gFKg5MP7mbe2ULQTKTjQdObq-3BtrbnvthZlJG9UEtY2n0QE6unEk5cZsCGRCZk&buyer-country=US&currency=USD&components=buttons&enable-funding=venmo&disable-funding=paylater"
            data-sdk-integration-source="developer-studio"
    ></script>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
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
                                                    
                                                    if($_SESSION == []){
                                                        echo "display:none;";
                                                    } 
                                                    ?>" >
            <div class="dropdown-menu" id="userMenu">
                <a id="verPerfil">Ver perfil</a>
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
    <?php 

        // debuguear($usuario);
    ?>     
    <!-- HTML para el modal de Ver Perfil -->
    <div class="modal" id="verPerfilModal">
        <div class="modal-content">
            <span class="close" id="closeVerPerfilModal">&times;</span>
            <h2 class="titulo__verPerfil">Ver Perfil</h2>
            <h2 class="titulo__editarPerfil ">Editar Perfil</h2>   
                                                
            <form id="verPerfilForm" method="POST" enctype="multipart/form-data">

                <div class="div1--perfil">

                    <div class=" perfil--imagen">
                        <input type="file" name="imagen" id="profile_image" accept="image/*">

                        <picture class="perfil--picture">
                            <?php 
                                $nombreImagen =$usuario->imagen;
                            ?>
                            <img id="imagenVistaPrevia" src='/imagenes/uploads/<?php echo $nombreImagen; ?>' alt="Imagen de usuario">
                        </picture>                                                                 
                    </div>                                            

                    <fieldset class="perfil__div perfil--datosPersonales">
                        
                        <legend>Datos Personales</legend> 
                    
                        <label for="nombres">Nombres:</label>
                        <input type="text" id="nombres" name="nombre" value ='<?php echo $usuario->nombre ?>' readonly>
                        
                        <label for="apellidos">Apellidos:</label>
                        <input type="text" id="apellidos" name="apellido" value='<?php echo $usuario->apellido ?>' readonly>
                        
                        <label for="dni">DNI:</label>
                        <input type="text" id="edad" name="dni" value='<?php echo $usuario->dni ?>' readonly maxlength="8"> 
                    </fieldset>       
                </div>                                        

                <fieldset class="perfil__div perfil--contacto">
                    
                    <legend>Contacto</legend> 
                
                    <label for="correo">Correo:</label>
                    <input type="email" id="correo" name="email" value='<?php echo $usuario->email?>' readonly>
                    
                    <label for="celular">Celular:</label>
                    <input type="text" id="celular" name="telefono" value='<?php echo $usuario->telefono?>' readonly maxlength="9">
                </fieldset>
                
                <fieldset class="perfil__div perfil--direccion">
                    
                    <legend>Dirección </legend> 
                
                    <label for="pais">País:</label>
                    <input type="text" id="pais" name="pais" value="Peru" readonly>
                    
                    <label for="provincia">Provincia:</label>
                    <input type="text" id="provincia" name="provincia" value="Lima" readonly>
                    
                    <label for="distrito">Distrito:</label>
                    <input type="text" id="distrito" name="distrito" value="SMP" readonly>
                    
                    <label for="direccion">Dirección:</label>
                    <input type="text" id="direccion" name="direccion" value="CALLE X LOTE 5 URB X MZ X" readonly>
                </fieldset>
                
                <div class="botones">
                    <button type="button" id="modificarPerfilBtn" >Modificar</button>
                    <button type="submit" class="botonActualizarPerfil" style="display: none;">Actualizar Datos</button>
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
            <div id="paypal-button-container" style="max-width:1000px;"></div>
        </div>
        
    </div>

    <footer class="footer">
        <p>&copy; 2024 TreeSolution. Todos los derechos reservados.</p>
    </footer>
    
    <script src='//cdn.jsdelivr.net/npm/sweetalert2@11'></script>
	<script>

		let session;
		session = <?php echo $usuario->ID_Usuario ?? 'false' ?> ;

	</script>
							
    <script type="module" src="/scripts/Dashboard2.js"></script>

</body>
</html>