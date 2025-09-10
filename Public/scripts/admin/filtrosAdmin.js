// Módulo de filtros del dashboard admin

/**
 * Configura todos los filtros del dashboard
 */
export function configurarFiltros() {
    configurarFiltroProductos();
    configurarFiltroUsuarios();
    configurarFiltroVentas();
}

/**
 * Configura los filtros de la sección de productos
 */
function configurarFiltroProductos() {
    // Búsqueda de productos
    const busquedaProductos = document.getElementById('productSearch');
    if (busquedaProductos) {
        busquedaProductos.addEventListener('input', (e) => {
            filtrarProductos(e.target.value);
        });
    }

    // Filtro por categoría
    const filtroCategoria = document.getElementById('categoryFilter');
    if (filtroCategoria) {
        filtroCategoria.addEventListener('change', (e) => {
            filtrarPorCategoria(e.target.value);
        });
    }
}

/**
 * Configura los filtros de la sección de usuarios
 */
function configurarFiltroUsuarios() {
    // Búsqueda de usuarios
    const busquedaUsuarios = document.getElementById('userSearch');
    if (busquedaUsuarios) {
        busquedaUsuarios.addEventListener('input', (e) => {
            filtrarUsuarios(e.target.value);
        });
    }

    // Filtro por tipo de usuario
    const filtroTipoUsuario = document.getElementById('userTypeFilter');
    if (filtroTipoUsuario) {
        filtroTipoUsuario.addEventListener('change', (e) => {
            filtrarUsuariosPorTipo(e.target.value);
        });
    }
}

/**
 * Configura los filtros de la sección de ventas
 */
function configurarFiltroVentas() {
    // Búsqueda de ventas
    const busquedaVentas = document.getElementById('salesSearch');
    if (busquedaVentas) {
        busquedaVentas.addEventListener('input', (e) => {
            filtrarVentas(e.target.value);
        });
    }
}

/**
 * Filtra productos por término de búsqueda
 * @param {string} termino - El término de búsqueda
 */
function filtrarProductos(termino) {
    const productos = document.querySelectorAll('.product-card');
    const terminoMinuscula = termino.toLowerCase();
    
    productos.forEach(producto => {
        const nombre = producto.querySelector('h3').textContent.toLowerCase();
        const descripcion = producto.querySelector('.product-description').textContent.toLowerCase();
        
        if (nombre.includes(terminoMinuscula) || descripcion.includes(terminoMinuscula)) {
            producto.style.display = 'block';
        } else {
            producto.style.display = 'none';
        }
    });
}

/**
 * Filtra productos por categoría
 * @param {string} idCategoria - El ID de la categoría
 */
function filtrarPorCategoria(idCategoria) {
    const productos = document.querySelectorAll('.product-card');
    
    productos.forEach(producto => {
        const categoriaProducto = producto.dataset.category;
        
        if (idCategoria === 'todos' || categoriaProducto === idCategoria) {
            producto.style.display = 'block';
        } else {
            producto.style.display = 'none';
        }
    });
}

/**
 * Filtra usuarios por término de búsqueda
 * @param {string} termino - El término de búsqueda
 */
function filtrarUsuarios(termino) {
    const usuarios = document.querySelectorAll('.user-card');
    const terminoMinuscula = termino.toLowerCase();
    
    usuarios.forEach(usuario => {
        const nombre = usuario.querySelector('h3').textContent.toLowerCase();
        const email = usuario.querySelector('.user-meta span:first-child').textContent.toLowerCase();
        
        if (nombre.includes(terminoMinuscula) || email.includes(terminoMinuscula)) {
            usuario.style.display = 'block';
        } else {
            usuario.style.display = 'none';
        }
    });
}

/**
 * Filtra usuarios por tipo
 * @param {string} tipoUsuario - El tipo de usuario (admin, cliente, todos)
 */
function filtrarUsuariosPorTipo(tipoUsuario) {
    const usuarios = document.querySelectorAll('.user-card');
    
    usuarios.forEach(usuario => {
        const tipo = usuario.dataset.type;
        
        if (tipoUsuario === 'todos' || tipo === tipoUsuario) {
            usuario.style.display = 'block';
        } else {
            usuario.style.display = 'none';
        }
    });
}

/**
 * Filtra ventas por término de búsqueda
 * @param {string} termino - El término de búsqueda
 */
function filtrarVentas(termino) {
    const ventas = document.querySelectorAll('.sale-card');
    const terminoMinuscula = termino.toLowerCase();
    
    ventas.forEach(venta => {
        const idPedido = venta.querySelector('h3').textContent.toLowerCase();
        const cliente = venta.querySelector('.sale-meta span:first-child').textContent.toLowerCase();
        
        if (idPedido.includes(terminoMinuscula) || cliente.includes(terminoMinuscula)) {
            venta.style.display = 'block';
        } else {
            venta.style.display = 'none';
        }
    });
}