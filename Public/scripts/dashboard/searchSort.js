 //? BUSQUEDA Y ORDENACION

 const searchButton = document.getElementById('searchButton');
 const searchInput = document.getElementById('searchInput');
 const productList = document.getElementById('productList');
 const sortOptions = document.getElementById('sortOptions');
 // Buscar productos
 
 searchButton.addEventListener('click', function () {
     const searchText = searchInput.value.toLowerCase();
     const products = document.querySelectorAll('.product');
     products.forEach(product => {
         const name = product.getAttribute('data-name').toLowerCase();
         if (name.includes(searchText)) {
             product.style.display = 'block';
         } else {
             product.style.display = 'none';
         }
     });
 });

 // Ordenar productos
 sortOptions.addEventListener('change', function () {
     const option = sortOptions.value;
     const productsArray = Array.from(document.querySelectorAll('.product'));

     if (option === 'name') {
         productsArray.sort((a, b) => {
             const nameA = a.getAttribute('data-name').toLowerCase();
             const nameB = b.getAttribute('data-name').toLowerCase();
             return nameA.localeCompare(nameB);
         });
     } else if (option === 'price') {
         productsArray.sort((a, b) => {
             const priceA = parseFloat(a.getAttribute('data-price'));
             const priceB = parseFloat(b.getAttribute('data-price'));
             return priceA - priceB;
         });
     }

     productsArray.forEach(product => {
         productList.appendChild(product);
     });
 });