<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - TreeSolution</title>
    <link rel="stylesheet" href="/estilos/Dashboard_admin.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Symbols+Outlined" rel="stylesheet">
</head>

<body>
    <!-- Modal para agregar producto -->
    <div class="modal" id="addProductModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Añadir Nuevo Producto</h2>
                <span class="close" id="closeaddProductModal">&times;</span>
            </div>
            <form id="añadirProductForm" action="/admin/registrarProducto" method="POST" enctype="multipart/form-data">
                <div class="product-form-grid">
                    <div class="form-group">
                        <label for="nombre">Nombre del producto</label>
                        <input type="text" id="nombre" name="nombre" required autocomplete="off" placeholder="Ej: Zapatillas Nike Air Max">
                    </div>
                    
                    <div class="form-group">
                        <label for="precio">Precio (S/.)</label>
                        <input type="number" id="precio" name="precio" step="0.01" required autocomplete="off" placeholder="99.99">
                    </div>
                    
                    <div class="form-group full-width">
                        <label for="descripcion">Descripción</label>
                        <textarea id="descripcion" name="descripcion" required autocomplete="off" placeholder="Descripción detallada del producto..." rows="3"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="categoria">Categoría</label>
                        <select name="categoria" id="categoria" required>
                            <option value="" selected disabled>Seleccionar Categoria</option>
                            <?php foreach($categorias as $categoria): ?>
                                <option value="<?php echo $categoria->id; ?>"><?php echo ucfirst($categoria->nombre); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="stock">Stock inicial</label>
                        <input type="number" id="stock" name="stock" required autocomplete="off" placeholder="10" min="0">
                    </div>
                    
                    <div class="form-group full-width">
                        <label for="product_imagen">Imagen del producto</label>
                        <input type="file" name="imagen" id="product_imagen" accept="image/*">
                        <div class="image-preview">
                            <img id="imagenVistaPrevia" src="/imagenes/store/productUndefined.png" alt="Vista previa">
                        </div>
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Crear Producto</button>
                    <button type="button" class="btn btn-secondary" onclick="cerrarModal('addProductModal')">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal para modificar producto -->
    <div class="modal" id="modificarProductModal" data-idproducto="">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Editar Producto</h2>
                <span class="close" onclick="cerrarModal('modificarProductModal')">&times;</span>
            </div>
            <form id="modificarProductForm" action="/admin/modificarProducto" method="POST" enctype="multipart/form-data">
                <input type="hidden" id="ID_Producto" name="ID_Producto">
                
                <div class="product-form-grid">
                    <div class="form-group">
                        <label for="nombreNuevo">Nombre</label>
                        <input type="text" id="nombreNuevo" name="nombre" required autocomplete="off">
                    </div>
                    
                    <div class="form-group">
                        <label for="nuevoPrecio">Precio (S/.)</label>
                        <input type="number" id="nuevoPrecio" name="precio" step="0.01" required autocomplete="off">
                    </div>
                    
                    <div class="form-group full-width">
                        <label for="nuevaDescripcion">Descripción</label>
                        <textarea id="nuevaDescripcion" name="descripcion" required autocomplete="off" rows="3"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="nuevaCategoria">Categoría</label>
                        <select name="categoria" id="nuevaCategoria" required>
                            <option value="" disabled>Seleccionar Categoria</option>
                            <?php foreach($categorias as $categoria): ?>
                                <option value="<?php echo $categoria->id; ?>"><?php echo ucfirst($categoria->nombre); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="nuevoStock">Stock</label>
                        <input type="number" id="nuevoStock" name="stock" required autocomplete="off" min="0">
                    </div>
                    
                    <div class="form-group full-width">
                        <label for="nueva_imagen">Nueva imagen (opcional)</label>
                        <input type="file" name="imagen" id="nueva_imagen" accept="image/*">
                        <div class="image-preview">
                            <img id="imagenPVistaPrevia" src="/imagenes/store/productUndefined.png" alt="Vista previa">
                        </div>
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Actualizar Producto</button>
                    <button type="button" class="btn btn-secondary" onclick="cerrarModal('modificarProductModal')">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal para agregar administrador -->
    <div class="modal" id="addAdminModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Añadir Nuevo Administrador</h2>
                <span class="close" onclick="cerrarModal('addAdminModal')">&times;</span>
            </div>
            <form action="/admin/registrarAdmin" method="POST">
                <div class="product-form-grid">
                    <div class="form-group">
                        <label for="admin-nombre">Nombre completo</label>
                        <input type="text" id="admin-nombre" name="nombre" required placeholder="Ingresa el nombre completo">
                    </div>
                    
                    <div class="form-group">
                        <label for="admin-apellido">Apellidos</label>
                        <input type="text" id="admin-apellido" name="apellido" required placeholder="Ingresa los apellidos">
                    </div>
                    
                    <div class="form-group full-width">
                        <label for="admin-email">Correo electrónico</label>
                        <input type="email" id="admin-email" name="email" required placeholder="admin@treesolution.com">
                    </div>
                    
                    <div class="form-group full-width">
                        <label for="admin-password">Contraseña temporal</label>
                        <input type="password" id="admin-password" name="contrasena" required placeholder="Contraseña segura">
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Crear Administrador</button>
                    <button type="button" class="btn btn-secondary" onclick="cerrarModal('addAdminModal')">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <main class="admin-layout">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="sidebar-header">
                <h2>Panel de Administración</h2>
            </div>
            <nav class="sidebar-nav">
                <button class="nav-item" id="usersButton" data-section="users">
                    <span class="material-symbols-outlined">people</span>
                    <div class="nav-text">
                        <span class="nav-title">Gestión de Usuarios</span>
                        <span class="nav-desc">Administrar usuarios y permisos</span>
                    </div>
                </button>
                
                <button class="nav-item active" id="productsButton" data-section="products">
                    <span class="material-symbols-outlined">inventory_2</span>
                    <div class="nav-text">
                        <span class="nav-title">Gestión de Productos</span>
                        <span class="nav-desc">Administrar inventario y catálogo</span>
                    </div>
                </button>
                
                <button class="nav-item" id="salesButton" data-section="sales">
                    <span class="material-symbols-outlined">shopping_bag</span>
                    <div class="nav-text">
                        <span class="nav-title">Gestión de Ventas</span>
                        <span class="nav-desc">Ver pedidos y transacciones</span>
                    </div>
                </button>
            </nav>
        </aside>

        <!-- Content Area -->
        <section class="admin-content">
            <!-- Users Section -->
            <div id="usersSection" class="content-section" style="display: none;">
                <div class="section-header">
                    <div class="header-text">
                        <h1>Gestión de Usuarios</h1>
                        <p>Administra usuarios, permisos y accesos</p>
                    </div>
                    <button class="btn btn-primary" onclick="abrirModal('addAdminModal')">
                        <span class="material-symbols-outlined">person_add</span>
                        Añadir Administrador
                    </button>
                </div>

                <div class="filters">
                    <div class="search-box">
                        <span class="material-symbols-outlined">search</span>
                        <input type="text" id="userSearch" placeholder="Buscar por nombre o email...">
                    </div>
                    <select id="userTypeFilter">
                        <option value="todos">Todos los usuarios</option>
                        <option value="cliente">Clientes</option>
                        <option value="admin">Administradores</option>
                    </select>
                </div>

                <div class="users-grid">
                    <?php foreach($usuarios as $usuario): ?>
                        <div class="user-card" data-type="<?php echo $usuario->usuario; ?>">
                            <div class="user-info">
                                <div class="user-avatar">
                                    <img src="/imagenes/uploads/<?php echo $usuario->imagen; ?>" alt="Avatar">
                                </div>
                                <div class="user-details">
                                    <div class="user-header">
                                        <h3><?php echo $usuario->nombre . ' ' . $usuario->apellido; ?></h3>
                                        <span class="badge badge-<?php echo $usuario->usuario === 'admin' ? 'primary' : 'secondary'; ?>">
                                            <?php echo $usuario->usuario === 'admin' ? 'Administrador' : 'Cliente'; ?>
                                        </span>
                                    </div>
                                    <div class="user-meta">
                                        <span><span class="material-symbols-outlined">mail</span><?php echo $usuario->email; ?></span>
                                        <span><span class="material-symbols-outlined">phone</span><?php echo $usuario->telefono; ?></span>
                                    </div>
                                </div>
                            </div>
                            
                            <?php if($usuario->usuario !== 'admin'): ?>
                                <div class="user-actions">
                                    <button class="btn btn-sm btn-primary button__activarUsuario" data-id="<?php echo $usuario->ID_Usuario; ?>">
                                        Habilitar
                                    </button>
                                    <button class="btn btn-sm btn-danger button__eliminarUsuario" data-id="<?php echo $usuario->ID_Usuario; ?>">
                                        Deshabilitar
                                    </button>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Products Section -->
            <div id="productsSection" class="content-section">
                <div class="section-header">
                    <div class="header-text">
                        <h1>Gestión de Productos</h1>
                        <p>Administra tu inventario y catálogo de productos</p>
                    </div>
                    <button class="btn btn-primary" id="button_agregarProducto" onclick="abrirModal('addProductModal')">
                        <span class="material-symbols-outlined">add</span>
                        Añadir Producto
                    </button>
                </div>

                <div class="filters">
                    <div class="search-box">
                        <span class="material-symbols-outlined">search</span>
                        <input type="text" id="productSearch" placeholder="Buscar productos...">
                    </div>
                    <select id="categoryFilter">
                        <option value="todos">Todas las categorías</option>
                        <?php foreach($categorias as $categoria): ?>
                            <option value="<?php echo $categoria->id; ?>"><?php echo ucfirst($categoria->nombre); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="products-grid">
                    <?php foreach($productos as $producto): ?>
                        <div class="product-card" data-category="<?php echo $producto->categoria; ?>" data-estado="<?php echo $producto->estado; ?>">
                            <div class="product-image">
                                <img src="/imagenes/store/<?php echo $producto->imagen; ?>" alt="<?php echo $producto->nombre; ?>">
                                <div class="product-status">
                                    <span class="badge badge-<?php echo $producto->estado === 'habilitado' ? 'success' : 'danger'; ?>">
                                        <?php echo $producto->estado === 'habilitado' ? 'En stock' : 'Deshabilitado'; ?>
                                    </span>
                                </div>
                            </div>
                            
                            <div class="product-info">
                                <div class="product-header">
                                    <h3><?php echo $producto->nombre; ?></h3>
                                    <span class="product-category">
                                        <?php 
                                        $categoria_nombre = '';
                                        foreach($categorias as $cat) {
                                            if($cat->id == $producto->categoria) {
                                                $categoria_nombre = ucfirst($cat->nombre);
                                                break;
                                            }
                                        }
                                        echo $categoria_nombre;
                                        ?>
                                    </span>
                                </div>
                                
                                <p class="product-description"><?php echo $producto->descripcion; ?></p>
                                
                                <div class="product-meta">
                                    <div class="product-price">S/. <?php echo $producto->precio; ?></div>
                                    <div class="product-stock">Stock: <?php echo $producto->stock; ?></div>
                                </div>
                            </div>
                            
                            <div class="product-actions">
                                <button class="btn btn-sm btn-outline symbol--editar" 
                                        data-id="<?php echo $producto->ID_Producto; ?>"
                                        data-nombre="<?php echo htmlspecialchars($producto->nombre); ?>"
                                        data-descripcion="<?php echo htmlspecialchars($producto->descripcion); ?>"
                                        data-precio="<?php echo $producto->precio; ?>"
                                        data-categoria="<?php echo $producto->categoria; ?>"
                                        data-stock="<?php echo $producto->stock; ?>"
                                        data-imagen="<?php echo $producto->imagen; ?>">
                                    <span class="material-symbols-outlined">edit</span>
                                    Editar
                                </button>
                                
                                <?php if($producto->estado === 'habilitado'): ?>
                                    <button class="btn btn-sm btn-danger symbol-borrar" data-id="<?php echo $producto->ID_Producto; ?>">
                                        <span class="material-symbols-outlined">delete</span>
                                        Deshabilitar
                                    </button>
                                <?php else: ?>
                                    <button class="btn btn-sm btn-success symbol-habilitar" data-id="<?php echo $producto->ID_Producto; ?>">
                                        <span class="material-symbols-outlined">visibility</span>
                                        Habilitar
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <!-- Sales Section -->
            <div id="salesSection" class="content-section" style="display: none;">
                <div class="section-header">
                    <div class="header-text">
                        <h1>Gestión de Ventas</h1>
                        <p>Administra pedidos y transacciones</p>
                    </div>
                    <div class="stats-cards">
                        <div class="stat-card">
                            <span class="material-symbols-outlined">attach_money</span>
                            <div>
                                <div class="stat-label">Ventas Totales</div>
                                <div class="stat-value">S/. <?php 
                                    $total = 0;
                                    $ventasIds = [];
                                    foreach($ventas as $venta) {
                                        if(!in_array($venta->ID_Venta, $ventasIds)) {
                                            $total += $venta->total;
                                            $ventasIds[] = $venta->ID_Venta;
                                        }
                                    }
                                    echo number_format($total, 2);
                                ?></div>
                            </div>
                        </div>
                        <div class="stat-card">
                            <span class="material-symbols-outlined">shopping_bag</span>
                            <div>
                                <div class="stat-label">Pedidos Totales</div>
                                <div class="stat-value"><?php echo count(array_unique(array_column($ventas, 'ID_Venta'))); ?></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="filters">
                    <div class="search-box">
                        <span class="material-symbols-outlined">search</span>
                        <input type="text" id="salesSearch" placeholder="Buscar por cliente o ID de pedido...">
                    </div>
                    <select id="salesSort">
                        <option value="fecha-desc">Fecha (más reciente)</option>
                        <option value="fecha-asc">Fecha (más antigua)</option>
                        <option value="total-desc">Total (mayor a menor)</option>
                        <option value="total-asc">Total (menor a mayor)</option>
                    </select>
                </div>

                <div class="sales-grid">
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
                    
                    foreach($ventasAgrupadas as $ID_Venta => $venta):
                    ?>
                        <div class="sale-card">
                            <div class="sale-header">
                                <div class="sale-info">
                                    <h3>Pedido #<?php echo $ID_Venta; ?></h3>
                                    <div class="sale-meta">
                                        <span><span class="material-symbols-outlined">person</span><?php echo $venta['cliente']; ?></span>
                                        <span><span class="material-symbols-outlined">calendar_today</span>Reciente</span>
                                        <span><span class="material-symbols-outlined">credit_card</span>Tarjeta</span>
                                    </div>
                                    <div class="sale-summary">
                                        <span><?php echo count($venta['productos']); ?> producto<?php echo count($venta['productos']) > 1 ? 's' : ''; ?></span>
                                        <span class="sale-total">S/. <?php echo number_format($venta['total'], 2); ?></span>
                                    </div>
                                </div>
                                <button class="btn btn-sm btn-outline" onclick="alternarDetallesVenta(<?php echo $ID_Venta; ?>)">
                                    <span class="material-symbols-outlined">visibility</span>
                                    Ver Detalles
                                </button>
                            </div>
                            
                            <div class="sale-details" id="saleDetails<?php echo $ID_Venta; ?>" style="display: none;">
                                <h4>Productos del Pedido:</h4>
                                <?php foreach($venta['productos'] as $producto): ?>
                                    <div class="sale-product">
                                        <span class="product-name"><?php echo $producto['nombre']; ?></span>
                                        <span class="product-quantity"><?php echo $producto['cantidad']; ?> un.</span>
                                        <span class="product-price">S/. <?php echo $producto['precio_Unitario']; ?></span>
                                        <span class="product-subtotal">Subtotal: S/. <?php echo $producto['subtotal']; ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    </main>

    <footer class="admin-footer">
        <p>&copy; 2024 TreeSolution. Todos los derechos reservados.</p>
    </footer>

    <!-- Script principal como módulo ES6 -->
    <script type="module" src="/scripts/Dashboard_admin.js"></script>
</body>
</html>
