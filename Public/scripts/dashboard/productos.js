let productosList ;

// Mapeo de categorías
const categoriesMap = {
    1: 'calzado',
    2: 'camisetas', 
    3: 'shorts',
    4: 'pants',
    5: 'abrigos'
};

const categories = [
    { value: "todos", label: "Todos los productos" },
    { value: "calzado", label: "Calzado" },
    { value: "camisetas", label: "Camisetas" },
    { value: "shorts", label: "Shorts" },
    { value: "pants", label: "Pants" },
    { value: "abrigos", label: "Abrigos" }
];

const sortOptionsList = [
    { value: "default", label: "Ordenar por" },
    { value: "price-asc", label: "Precio: Menor a Mayor" },
    { value: "price-desc", label: "Precio: Mayor a Menor" },
    { value: "name", label: "Nombre A-Z" }
];

let selectedCategory = "todos";
let sortBy = "default";

async function obtenerProductos(){
    try {
        const url = '/api/productos' ;
        const resultado = await fetch(url);
        let productos = await resultado.json();
        return productos;
    } catch (error) {
        console.log(error);
    }
}

let contenedorProductos = document.getElementById('productList');

function createCatalogHeader() {
    const headerContainer = document.createElement('div');
    headerContainer.className = 'catalog-header';
    
    headerContainer.innerHTML = `
        <div class="catalog-title-section">
            <h2 class="catalog-title">Catálogo de Productos</h2>
            <p class="catalog-subtitle">Encuentra el equipamiento deportivo perfecto para ti</p>
        </div>
        
        <div class="catalog-filters">
            <select id="categoryFilter" class="filter-select">
                ${categories.map(cat => `<option value="${cat.value}">${cat.label}</option>`).join('')}
            </select>
            
            <select id="sortFilter" class="filter-select">
                ${sortOptionsList.map(opt => `<option value="${opt.value}">${opt.label}</option>`).join('')}
            </select>
        </div>
    `;
    
    return headerContainer;
}

function getFilteredAndSortedProducts() {
    let filtered = productosList;

    // Filtrar por categoría
    if (selectedCategory !== "todos") {
        filtered = filtered.filter(product => {
            const productCategory = categoriesMap[product.categoria];
            return productCategory === selectedCategory;
        });
    }

    // Ordenar
    switch (sortBy) {
        case "price-asc":
            filtered = [...filtered].sort((a, b) => parseFloat(a.precio) - parseFloat(b.precio));
            break;
        case "price-desc":
            filtered = [...filtered].sort((a, b) => parseFloat(b.precio) - parseFloat(a.precio));
            break;
        case "name":
            filtered = [...filtered].sort((a, b) => a.nombre.localeCompare(b.nombre));
            break;
        default:
            break;
    }

    return filtered;
}

async function llenarProductos(){
    // Limpiar contenedor
    contenedorProductos.innerHTML = '';
    
    // Agregar header del catálogo
    const header = createCatalogHeader();
    contenedorProductos.appendChild(header);
    
    // Crear contenedor para los productos
    const productsGrid = document.createElement('div');
    productsGrid.className = 'products-grid';
    productsGrid.id = 'productsGrid';
    
    const filteredProducts = getFilteredAndSortedProducts();
    
    if (filteredProducts.length === 0) {
        const emptyMessage = document.createElement('div');
        emptyMessage.className = 'empty-products';
        emptyMessage.innerHTML = `
            <p>No se encontraron productos en esta categoría</p>
        `;
        productsGrid.appendChild(emptyMessage);
    } else {
        filteredProducts.forEach(producto => {
            let productoInsertado = crearProducto(producto);
            productsGrid.appendChild(productoInsertado);
        });
    }
    
    contenedorProductos.appendChild(productsGrid);
    
    // Configurar event listeners para filtros
    setupFilterListeners();
}

function setupFilterListeners() {
    const categoryFilter = document.getElementById('categoryFilter');
    const sortFilter = document.getElementById('sortFilter');
    
    if (categoryFilter) {
        categoryFilter.value = selectedCategory;
        categoryFilter.addEventListener('change', function() {
            selectedCategory = this.value;
            updateProductDisplay();
        });
    }
    
    if (sortFilter) {
        sortFilter.value = sortBy;
        sortFilter.addEventListener('change', function() {
            sortBy = this.value;
            updateProductDisplay();
        });
    }
}

function updateProductDisplay() {
    const productsGrid = document.getElementById('productsGrid');
    if (!productsGrid) return;
    
    // Limpiar grid
    productsGrid.innerHTML = '';
    
    const filteredProducts = getFilteredAndSortedProducts();
    
    if (filteredProducts.length === 0) {
        const emptyMessage = document.createElement('div');
        emptyMessage.className = 'empty-products';
        emptyMessage.innerHTML = `
            <p>No se encontraron productos en esta categoría</p>
        `;
        productsGrid.appendChild(emptyMessage);
    } else {
        filteredProducts.forEach(producto => {
            let productoInsertado = crearProducto(producto);
            productsGrid.appendChild(productoInsertado);
        });
    }
    
    // Reconfigurar event listeners para productos
    funcionalidadModalProducto();
}

async function inicio(){
    productosList = await obtenerProductos();
    await llenarProductos();
    funcionalidadModalProducto();
}

inicio();

function crearProducto(producto) {
    const productCard = document.createElement('div');
    productCard.classList.add('product-card');
    productCard.dataset.id = producto.ID_Producto;
    productCard.dataset.name = producto.nombre;
    productCard.dataset.price = producto.precio;
    productCard.dataset.categoria = producto.categoria;

    const categoryName = categoriesMap[producto.categoria] || 'general';
    
    productCard.innerHTML = `
        <div class="product-card-content">
            <div class="product-image-container">
                <img src="/imagenes/store/${producto.imagen}" alt="${producto.nombre}" class="product-image">
                <div class="product-badge">TreeSolution</div>
            </div>
            
            <div class="product-info">
                <div class="product-details">
                    <h3 class="product-name">${producto.nombre}</h3>
                    <div class="product-rating">
                        <svg class="star-icon" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                        <span class="rating-text">4.5</span>
                        <span class="reviews-text">(120)</span>
                    </div>
                </div>
                
                <div class="product-footer">
                    <div class="product-price-section">
                        <span class="product-price">S/ ${producto.precio}</span>
                        <button class="add-to-cart-btn" data-id="${producto.ID_Producto}">
                            <svg class="cart-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                                <line x1="3" y1="6" x2="21" y2="6"></line>
                                <path d="m16 10-4 4-4-4"></path>
                            </svg>
                            Agregar
                        </button>
                    </div>
                    
                    <div class="product-colors">
                        <span class="color-badge">Negro</span>
                        <span class="color-badge">Blanco</span>
                        <span class="color-badge">+2</span>
                    </div>
                </div>
            </div>
        </div>
    `;

    return productCard;
}

function funcionalidadModalProducto(){
    const productModal = document.getElementById('productModal');
    
    // Event listener para abrir modal desde las tarjetas de producto
    document.querySelectorAll('.product-card').forEach(product => {
        product.addEventListener('click', function (e) {
            // Evitar que se abra el modal si se hace click en el botón de agregar
            if (e.target.closest('.add-to-cart-btn')) {
                return;
            }
            
            const name = product.getAttribute('data-name');
            const price = product.getAttribute('data-price');
            const id = product.getAttribute('data-id');
            const imgSrc = product.querySelector('.product-image').getAttribute('src');

            const modalProduct = document.getElementById('productModal');
            modalProduct.setAttribute('data-id', id); 

            document.getElementById('modalImage').setAttribute('src', imgSrc);
            document.getElementById('modalName').textContent = name;
            
            // Configurar el modal con los datos del producto
            const productData = {
                id: id,
                name: name,
                price: price,
                image: imgSrc
            };
            
            // Usar la función setupProductModal del módulo modales
            if (window.setupProductModal) {
                window.setupProductModal(productData);
            }
            
            productModal.style.display = 'block';
            overlay.style.display = 'block';
            document.body.style.overflow = 'hidden';
        });
    });
    
    // Event listener para botones de agregar al carrito
    document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation(); // Evitar que se abra el modal
            
            const productCard = this.closest('.product-card');
            const name = productCard.getAttribute('data-name');
            const price = productCard.getAttribute('data-price');
            const id = productCard.getAttribute('data-id');
            const imgSrc = productCard.querySelector('.product-image').getAttribute('src');
            
            // Agregar directamente al carrito con cantidad 1
            const productToAdd = {
                idproducto: id,
                nombre: name,
                precio: parseFloat(price),
                imagenProducto: imgSrc,
                cantidad: 1
            };
            
            // Importar y usar la función addToCart del módulo carrito
            import('./carrito.js').then(carritoModule => {
                carritoModule.addToCart(productToAdd);
            });
        });
    });
}
