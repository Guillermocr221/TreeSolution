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
        <!-- El contenedor sort-container se ha removido ya que ahora está integrado en el catálogo -->
        <div id="productList" class="product-list">                   
        </div>
    </main>


    <div id="productModal" class="modal product-detail-modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            
            <div class="product-detail-header">
                <h1 class="product-detail-title" id="modalName">Producto</h1>
            </div>

            <div class="product-detail-content">
                <!-- Imagen del producto -->
                <div class="product-detail-image-container">
                    <div class="product-detail-image-wrapper">
                        <img id="modalImage" src="" alt="Product Image" class="product-detail-image">
                        <div class="product-detail-badge">TreeSolution</div>
                    </div>
                </div>

                <!-- Detalles del producto -->
                <div class="product-detail-info">
                    <div class="product-detail-rating-section">
                        <div class="product-detail-rating">
                            <div class="product-detail-stars">
                                <svg class="product-detail-star" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                                <svg class="product-detail-star" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                                <svg class="product-detail-star" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                                <svg class="product-detail-star" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                                <svg class="product-detail-star empty" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                            </div>
                            <span class="product-detail-rating-number">4.5</span>
                            <span class="product-detail-reviews">(120 reseñas)</span>
                        </div>
                        <div class="product-detail-price" id="modalPrice">S/ 0.00</div>
                    </div>

                    <div class="product-description-section">
                        <h3>Descripción</h3>
                        <p class="product-description" id="productDescription">
                            Descubre la excelencia en equipamiento deportivo con este producto de TreeSolution. 
                            Diseñado para atletas que buscan rendimiento y comodidad excepcionales. Con tecnología 
                            avanzada y materiales de primera calidad, este producto te ayudará a alcanzar tus objetivos deportivos.
                        </p>
                    </div>

                    <div class="product-features-section">
                        <h3>Características principales</h3>
                        <ul class="product-features-list">
                            <li class="product-feature-item">
                                <div class="product-feature-bullet"></div>
                                Materiales de alta calidad y durabilidad
                            </li>
                            <li class="product-feature-item">
                                <div class="product-feature-bullet"></div>
                                Diseño ergonómico para máximo confort
                            </li>
                            <li class="product-feature-item">
                                <div class="product-feature-bullet"></div>
                                Tecnología avanzada de rendimiento
                            </li>
                            <li class="product-feature-item">
                                <div class="product-feature-bullet"></div>
                                Resistente al desgaste y uso intensivo
                            </li>
                            <li class="product-feature-item">
                                <div class="product-feature-bullet"></div>
                                Garantía de satisfacción del fabricante
                            </li>
                        </ul>
                    </div>

                    <div class="product-options-grid">
                        <div class="product-option-group">
                            <label class="product-option-label">Color</label>
                            <select class="product-select" id="modalColorSelect">
                                <option value="">Selecciona un color</option>
                                <option value="negro">Negro</option>
                                <option value="blanco">Blanco</option>
                                <option value="azul">Azul</option>
                                <option value="rojo">Rojo</option>
                            </select>
                        </div>

                        <div class="product-option-group">
                            <label class="product-option-label">Talla</label>
                            <select class="product-select" id="modalSizeSelect">
                                <option value="">Selecciona una talla</option>
                                <option value="S">S</option>
                                <option value="M">M</option>
                                <option value="L">L</option>
                                <option value="XL">XL</option>
                            </select>
                        </div>
                    </div>

                    <div class="product-quantity-section">
                        <label class="product-option-label">Cantidad</label>
                        <div class="product-quantity-controls">
                            <button type="button" class="quantity-control-btn" id="decreaseQuantity">-</button>
                            <span class="quantity-display-large" id="quantity">1</span>
                            <button type="button" class="quantity-control-btn" id="increaseQuantity">+</button>
                        </div>
                    </div>

                    <!-- Botones de acción -->
                    <div class="product-actions">
                        <button id="addToCart" class="product-add-to-cart">
                            <svg class="product-action-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                                <line x1="3" y1="6" x2="21" y2="6"></line>
                                <path d="m16 10-4 4-4-4"></path>
                            </svg>
                            <span id="addToCartText">Agregar al carrito - S/ 0.00</span>
                        </button>

                        <div class="product-secondary-actions">
                            <button type="button" class="product-secondary-btn">
                                <svg class="product-action-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                                </svg>
                                Favoritos
                            </button>
                            <button type="button" class="product-secondary-btn">
                                <svg class="product-action-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"></path>
                                    <path d="M16 6l-4-4-4 4"></path>
                                    <line x1="12" y1="2" x2="12" y2="15"></line>
                                </svg>
                                Compartir
                            </button>
                        </div>
                    </div>

                    <div class="product-guarantees">
                        <p class="product-guarantee-item">✓ Envío gratis en pedidos superiores a S/ 100</p>
                        <p class="product-guarantee-item">✓ Devoluciones gratuitas en 30 días</p>
                        <p class="product-guarantee-item">✓ Garantía del fabricante incluida</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div id="cartModal" class="modal">
        <div class="modal-content cart-modal-content">
            <!-- Header del carrito -->
            <div class="cart-header">
                <div class="cart-header-left">
                    <svg class="cart-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <path d="m16 10-4 4-4-4"></path>
                    </svg>
                    <h2 class="cart-title">Tu Carrito de Compras</h2>
                </div>
                <button class="close cart-close-btn" type="button">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            <!-- Contenido scrolleable del carrito -->
            <div class="cart-content">
                <!-- Imagen de la tienda -->
                <div class="store-banner">
                    <img src="/imagenes/cart-background.jpg" alt="TreeSolution Store" class="store-image">
                    <div class="store-overlay">
                        <h3 class="store-name">TreeSolution - Tu Tienda de Confianza</h3>
                    </div>
                </div>

                <!-- Lista de productos del carrito -->
                <div class="cart-items-section">
                    <div id="cartItemsContainer" class="cart-items-list">
                        <!-- Los items se generarán dinámicamente aquí -->
                    </div>
                    
                    <!-- Mensaje cuando el carrito está vacío -->
                    <div id="emptyCartMessage" class="empty-cart" style="display: none;">
                        <svg class="empty-cart-icon" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <path d="m16 10-4 4-4-4"></path>
                        </svg>
                        <p>Tu carrito está vacío</p>
                    </div>
                </div>

                <!-- Resumen del pedido -->
                <div id="orderSummary" class="order-summary" style="display: none;">
                    <h3 class="summary-title">Resumen del Pedido</h3>
                    <div class="summary-details">
                        <div class="summary-row">
                            <span>Subtotal</span>
                            <span id="subtotalAmount">S/ 0.00</span>
                        </div>
                        <div class="summary-row">
                            <span>Envío</span>
                            <span id="shippingAmount">Gratis</span>
                        </div>
                        <div id="freeShippingNote" class="free-shipping-note" style="display: none;">
                            ¡Envío gratis por compras superiores a S/ 100!
                        </div>
                        <div class="summary-divider"></div>
                        <div class="summary-row summary-total">
                            <span>Total</span>
                            <span id="totalPrice" class="total-amount">S/ 0.00</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botones de acción -->
            <div id="cartActions" class="cart-actions" style="display: none;">
                <button id="checkout" class="btn-primary btn-paypal" type="button">
                    <svg class="btn-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                        <line x1="1" y1="10" x2="23" y2="10"></line>
                    </svg>
                    Pagar con PayPal
                </button>
                
                <div class="cart-bottom-actions">
                    <button id="cancel" class="btn-secondary" type="button">Continuar Comprando</button>
                    <button id="finalizeOrder" class="btn-primary" type="button">Finalizar Compra</button>
                </div>
            </div>
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