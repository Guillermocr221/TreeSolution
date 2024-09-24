<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - TreeSolution</title>
    <link rel="stylesheet" href="./estilos/Dashboard_admin.css">
    <link rel="icon" href="./images/favicon-32x32.png" type="images">
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
                    <button class="button__agregarAdmin" value="">Agregar Admin</button>
                </div>
                <table class="user-table">
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
                                <td style="text-align:center;"><img src="imagenes/user_generico.png" alt="Perfil" style="width: 60px; height: 60px; "></td>
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
                <h2>Productos</h2>
                <table class="product-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Stock</th>
                            <th>Precio unitario</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            foreach($productos as $key=>$producto){
                        ?>
                            <tr>
                                <td><?php echo $producto->ID_Producto; ?></td>
                                <td><?php echo $producto->nombre; ?></td>
                                <td>100</td>
                                <td>S/.<?php echo $producto->precio; ?></td>
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
    <script src="./scripts/Dashboard_admin.js"></script>
</body>
</html>
