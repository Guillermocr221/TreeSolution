document.addEventListener('DOMContentLoaded', function () {
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');
    const loginForm = document.getElementById('loginForm');
    const userIcon = document.querySelector('.header__action-icon');
    const userMenu = document.getElementById('userMenu');
    const cartIcon = document.getElementById('cartIcon');
    const cartModal = document.getElementById('cartModal');
    const cartItemsContainer = document.getElementById('cartItems');
    const totalPriceElement = document.getElementById('totalPrice');
    const cartCount = document.getElementById('cartCount');
    const productModal = document.getElementById('productModal');
    let cart = [];

    // Mostrar/Ocultar el menú desplegable
    userIcon.addEventListener('click', function () {
        userMenu.style.display = userMenu.style.display === 'block' ? 'none' : 'block';
    });

    // Redirigir al hacer clic en "Cerrar sesión"
    document.getElementById('logout').addEventListener('click', function () {
        window.location.href = 'Inicio.html';
    });

    // Ocultar el menú desplegable al hacer clic fuera de él
    window.addEventListener('click', function (event) {
        if (event.target !== userIcon && !userIcon.contains(event.target) && event.target !== userMenu && !userMenu.contains(event.target)) {
            userMenu.style.display = 'none';
        }
    });

    // Mostrar/Ocultar el modal del carrito
    cartIcon.addEventListener('click', function () {
        cartModal.style.display = 'block';
    });

    // Ocultar el modal al hacer clic fuera de él
    window.addEventListener('click', function (event) {
        if (event.target === cartModal || event.target === productModal) {
            event.target.style.display = 'none';
        }
    });

    // Mostrar detalles del producto en el modal al hacer clic en el card del producto
    document.querySelectorAll('.product').forEach(product => {
        product.addEventListener('click', function () {
            const name = product.getAttribute('data-name');
            const price = product.getAttribute('data-price');
            const imgSrc = product.querySelector('img').getAttribute('src');

            document.getElementById('modalImage').setAttribute('src', imgSrc);
            document.getElementById('modalName').textContent = name;
            document.getElementById('modalPrice').textContent = `Price: S/ ${price}`;
            productModal.style.display = 'block';
        });
    });

    // Añadir al carrito
    document.getElementById('addToCart').addEventListener('click', function () {
        const name = document.getElementById('modalName').textContent;
        const price = parseFloat(document.getElementById('modalPrice').textContent.replace('Price: S/ ', ''));
        const quantity = parseInt(document.getElementById('quantity').value);

        const existingProductIndex = cart.findIndex(product => product.name === name);

        if (existingProductIndex > -1) {
            cart[existingProductIndex].quantity += quantity;
        } else {
            cart.push({ name, price, quantity });
        }

        updateCart();
        productModal.style.display = 'none';
    });

    // Actualizar carrito
    function updateCart() {
        cartItemsContainer.innerHTML = '';
        let totalItems = 0;
        let total = 0;

        cart.forEach(product => {
            const item = document.createElement('li');
            item.textContent = `${product.name} - S/ ${product.price.toFixed(2)} x ${product.quantity}`;
            cartItemsContainer.appendChild(item);
            total += product.price * product.quantity;
            totalItems += product.quantity;
        });

        totalPriceElement.textContent = `Total: S/ ${total.toFixed(2)}`;
        cartCount.textContent = totalItems;
    }

    // Ocultar el modal del carrito y producto
    document.querySelectorAll('.close').forEach(closeBtn => {
        closeBtn.addEventListener('click', function () {
            cartModal.style.display = 'none';
            productModal.style.display = 'none';
        });
    });

    // Pagar
    document.getElementById('checkout').addEventListener('click', function () {
        alert('Gracias por su compra');
        cart = [];
        updateCart();
        cartModal.style.display = 'none';
    });

    // Cancelar
    document.getElementById('cancel').addEventListener('click', function () {
        cartModal.style.display = 'none';
    });


});
