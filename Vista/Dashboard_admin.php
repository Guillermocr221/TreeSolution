<?php

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - TreeSolution</title>
    <link rel="stylesheet" href="./estilos/Dashboard_admin.css">
    <link rel="icon" href="./images/favicon-32x32.png" type="images">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

    
</head>
<body>
    <header class="header">
        <div class="header__logo">TreeSolution</div>
        <nav class="header__nav">
            <ul class="header__nav-list">
                <li class="header__nav-item"><a href="/logout" class="header__nav-link" id="logoutButton">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>


    <!-- HTML para el overlay -->
    <div id="overlay"></div>

    <!-- MODALES -->
    <div class="modal" id="addProductModal">
        <div class="modal-content">
            <span class="close" id="closeaddProductModal">&times;</span>
            <h2 class="titulo__verPerfil">Agregar Producto</h2>
            <form id="añadirProductForm" action="/admin/registrarProducto" method="POST" enctype="multipart/form-data">

                <div class="div1--product">
                    <div class=" product--imagen">
                        <input type="file" name="imagen" id="product_imagen" accept="image/*">

                        <picture class="product--picture">
                            <img id="imagenVistaPrevia" src='/imagenes/store/productUndefined.png' alt="Imagen de producto">
                        </picture>
                    </div>                                            

                    <fieldset class="product__div product--datos">
                        
                        <legend>Datos del Producto</legend> 
                    
                        <label for="nombre">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" required autocomplete="off">
                        
                        <label for="descripcion">Descripcion:</label>
                        <input type="text" id="descripcion" name="descripcion" required autocomplete="off">
                        
                        <label for="precio">Precio (S/.):</label>
                        <input type="text" id="precio" name="precio" maxlength="4" pattern="\d*" required autocomplete="off"> 
                        
                        <label>Categoria:</label>
                        <select name="categoria" id="categoria-select">
                            <option value="" selected disabled>Seleccionar Categoria</option>
                        </select>


                        <label for="stock">Stock:</label>
                        <input type="text" id="stock" name="stock" maxlength="4" pattern="\d*" required autocomplete="off"> 
                    </fieldset>       
                </div>                                        
                
                <div class="botones">
                    <button type="submit" id="modificarPerfilBtn" >Añadir</button>
                    <!-- <button type="submit" class="botonActualizarPerfil" style="display: none;">Actualizar Datos</button> -->
                </div>
            </form>
        </div>
    </div>
    
    <div class="modal" id="addAdminModal">
        <div class="modal-content">
            <span class="close" id="closeaddAdminModal">&times;</span>
            <h2 class="titulo__verPerfil">Agregar Administrador</h2>
            <form id="añadirAdminForm" action="/admin/registrarAdmin" method="POST" enctype="multipart/form-data">

                <div class="div1--admin">
                    <div class=" admin--imagen">
                        <input type="file" name="imagen" id="admin_imagen" accept="image/*">

                        <picture class="admin--picture">
                            <img id="imagenAdminVistaPrevia" src='/imagenes/uploads/user_generico.png'>
                        </picture>
                    </div>                                            

                    <fieldset class="admin__div admin--datos">
                        
                        <legend>Datos</legend> 
                    
                        <label for="nombres">Nombre:</label>
                        <input type="text" id="nombres" name="nombre" required autocomplete="off">

                        <label for="correo">Correo:</label>
                        <input type="email" id="correo" name="email"  required autocomplete="off"> 

                        <label for="password">Contraseña:</label>
                        <input type="password" id="password" name="contrasena"  required autocomplete="off"> 
                    </fieldset>       
                </div>                                        
                
                <div class="botones">
                    <button type="submit" id="submit_addAdmin" >Añadir</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal" id="modificarProductModal" data-idproducto="x">
        <div class="modal-content">
            <span class="close" id="closeaddProductModal">&times;</span>
            <h2 class="titulo__verPerfil">Modificar Producto</h2>
            
            <form id="modificarProductForm" action="/admin/modificarProducto" method="POST" enctype="multipart/form-data">
                <input type="hidden" name ="ID_Producto" id="inputIdProducto" value ="">

                <div class="div1--product">
                    <div class=" product--imagen">
                        <input type="file" name="imagen" id="producto_imagen" accept="image/*">

                        <picture class="product--picture">
                            <img id="imagenPVistaPrevia" src='/imagenes/store/productUndefined.png' alt="Imagen de producto">
                        </picture>
                    </div>                                            

                    <fieldset class="product__div product--datos">
                        
                        <legend>Datos del Producto</legend> 
                    
                        <label for="nombreNuevo">Nombre:</label>
                        <input type="text" id="nombreNuevo" name="nombre" required autocomplete="off">
                        
                        <label for="nuevaDescripcion">Descripcion:</label>
                        <input type="text" id="nuevaDescripcion" name="descripcion" required autocomplete="off">
                        
                        <label for="nuevoPrecio">Precio (S/.):</label>
                        <input type="number" id="nuevoPrecio" name="precio" maxlength="6" step="0.01" required autocomplete="off" />
                        
                        <label for="nuevaCategoria">Categoria:</label>
                        <!-- <input type="text" id="nuevaCategoria" name="categoria" maxlength="4" pattern="\d*" required autocomplete="off">  -->
                        <select name="categoria" id="nuevaCategoria">
                            <option value="" selected disabled>Seleccionar Categoria</option>
                        </select>

                        <label for="nuevoStock">Stock:</label>
                        <input type="text" id="nuevoStock" name="stock" maxlength="4" pattern="\d*" required autocomplete="off"> 
                    </fieldset>       
                </div>                                        
                
                <div class="botones">
                    <button type="submit" id="modificarProductBtn" >Añadir</button>
                    
                </div>
            </form>
        </div>
    </div>

    <main class="main">
        
        <aside class="sidebar">
            <ul class="sidebar__list">
                
                <li class="sidebar__item" id="productsButton">Productos</li> 
                <li class="sidebar__item sidebar__item--active" id="usersButton">Usuarios</li>
                <li class="sidebar__item" id="employeesButton">Pedidos</li>
            </ul>
        </aside>

        <section class="content" >
            <h1 class="titulo" id="tituloAnimado">Panel de Administración</h1>
            
            <div id="usersSection">
                <div class="usersSection__header">
                    <h2>Usuarios</h2>
                    <button id="button__agregarAdmin" class="button__agregarAdmin">Agregar Admin</button >
                </div>
                <table class="user-table ">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Imagen de perfil</th>
                            <th>Usuario</th>
                            <th>Correo</th>
                            <th>Contacto</th>
                            <!-- <th>Login con</th> -->
                            <th>Estado de verificación</th>
                            <!-- <th>Fecha de creación</th> -->
                            <th class="th__accion">Acción</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                            foreach($usuarios as $key=>$usuario){
                        ?> 
                            <tr>
                                <td class="id_usuario"><?php echo $usuario->ID_Usuario; ?></td>
                                <td style="text-align:center;"><img src="imagenes/uploads/<?php echo $usuario->imagen ?>" alt="Perfil" style="width: 60px; height: 60px; "></td>
                                <td><?php echo $usuario->nombre.' '.$usuario->apellido ; ?></td>
                                <td><?php echo $usuario->email; ?></td>
                                <td><?php echo $usuario->telefono; ?></td>
                                <td><?php echo $usuario->usuario; ?></td>

                                <td class="row__button">
                                    <!-- <button>Ver</button> -->
                                    <button class="button__activarUsuario">Habilitar</button>
                                    <button class="button__eliminarUsuario">Deshabilidar</button>
                                </td>
                            </tr>
                        <?php
                            }
                        ?>
                        
                        
                    </tbody>
                </table>
            </div>

            <div id="productsSection" style="display: none;">
                <div class="usersSection__header">
                    <h2>Productos</h2>
                    <button class="button__agregarAdmin" id="button_agregarProducto" value="">Añadir Producto</button>
                </div>
                <table class="product-table product--td">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Imagen</th>
                            <th>Nombre</th>
                            <th>Stock</th>
                            <th>Precio unitario</th>
                            <th colspan="2"> Accion</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            foreach($productos as $key=>$producto){
                                if($producto->estado == 'deshabilitado') continue;
                        ?>
                            <tr>
                                <td class="id_producto"><?php echo $producto->ID_Producto; ?></td>
                                <td class="tdimg"><img src="/imagenes/store/<?php echo $producto->imagen ?>" alt="ImgP"></td>
                                <td class="nombreProducto"><?php echo $producto->nombre; ?></td>
                                <td class="centrar"><?php echo $producto->stock; ?></td>
                                <td >S/.<?php echo $producto->precio; ?></td>
                                <td class="centrar">
                                    <span title="Editar producto" class="material-symbols-outlined symbol--editar">edit</span>
                                    </span>
                                </td>
                                <td class="admin_celda--accion centrar">
                                    <span title="Eliminar producto" class="material-symbols-outlined symbol-borrar">delete
                                </td>
                            </tr>    
                        <?php        
                            }
                        ?>
                    </tbody>
                </table>
            </div>
            
            <div id="employeesSection" style="display: none;">
                <h2>Pedidos</h2>

                <?php 
                    $ventasAgrupadas = [];
                    foreach ($ventas as $venta) {
                        $ventasAgrupadas[$venta->ID_Venta]['cliente'] = $venta->cliente;
                        $ventasAgrupadas[$venta->ID_Venta]['total'] = $venta->total;
                        $ventasAgrupadas[$venta->ID_Venta]['productos'][] = [
                            'nombre' => $venta->nombre,
                            'cantidad' => $venta->cantidad,
                            'precio_Unitario' => $venta->precio_Unitario,
                            'subtotal' => $venta->subtotal
                        ];
                    }
                ?>
                <table class="employee-table">
                    <thead>
                        <tr>
                            <th>ID Venta</th>
                            <th>Cliente</th>
                            <th>Productos</th>
                            <th>Total</th>
                        </tr>
                        
                    </thead>
                    <tbody>
                    <?php
                        foreach($ventasAgrupadas as $ID_Venta => $venta){
                            $productos = $venta['productos'];
                            $rowspan = count($productos);
                            $cliente = $venta['cliente'];
                            $total = $venta['total'];
                    ?>
                        <tr>
                            <td rowspan="<?php echo $rowspan; ?>"><?php echo $ID_Venta; ?></td>
                            <td rowspan="<?php echo $rowspan; ?>"><?php echo $cliente; ?></td>
                            <td>
                                <?php echo $productos[0]['nombre']; ?> - <?php echo $productos[0]['cantidad']; ?>un. - Precio(unidad): S/.<?php echo $productos[0]['precio_Unitario'];?> - Subtotal: S/.<?php echo $productos[0]['subtotal']; ?>
                            </td>
                            <td rowspan="<?php echo $rowspan; ?>">S/.<?php echo $total; ?></td>
                        </tr>
                        <?php for ($i = 1; $i < $rowspan; $i++) { ?>
                            <tr>
                                <td>
                                    <?php echo $productos[$i]['nombre']; ?> - <?php echo $productos[$i]['cantidad']; ?>un. - Precio(unidad): S/.<?php echo $productos[$i]['precio_Unitario'];?> - Subtotal: S/.<?php echo $productos[$i]['subtotal']; ?>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php
                        }
                    ?>
                    </tbody>
                    
                </table>
            </div>
        </section>
    </main>

    <footer class="footer">
        <p>&copy; 2024 TreeSolution. Todos los derechos reservados.</p>
    </footer>


    <script src='//cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script type="module" src="./scripts/Dashboard_admin.js"></script>
</body>
</html>
