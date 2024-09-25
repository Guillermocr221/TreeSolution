


paypal.Buttons({
    style: {
      layout: 'vertical',
      color:  'white',
      shape:  'rect',
      label:  'paypal',
      
    },

    
    createOrder: async function(data, actions) {

        // Obtener la tasa de cambio de Soles (PEN) a Dólares (USD)
        let tasa;
        
        // Esperar a que la solicitud fetch termine antes de continuar
        const response = await fetch("https://api.exchangerate-api.com/v4/latest/USD");
        const dataFetch = await response.json();
        
        // Obtener la tasa de PEN a USD
        tasa = dataFetch.rates['PEN'];
        console.log('Tasa de cambio PEN a USD:', tasa);
    

        var totalPedido = document.getElementById("totalPrice");
        let stringPrecioTotal;
        let precioACobrar;
        stringPrecioTotal = totalPedido.textContent;
        precioACobrar = parseFloat(stringPrecioTotal.match(/[0-9]+\.[0-9]+/)[0]);
        
         // Calcular el precio en dólares (dividiendo por la tasa de cambio)
        let precioEnDolares = (precioACobrar / tasa).toFixed(2);
        
        return actions.order.create({
            purchase_units: [{
                amount: {
                    value: `${precioEnDolares}` // Precio del producto
                }
            }]
        });
    },

    onApprove: function(data, actions){
        // Capturar el pago después de que el usuario lo aprueba
        return actions.order.capture().then(function(details) {
            console.log('Transaction completed by ' + details.payer.name.given_name);
            // Aquí podrías enviar detalles al servidor para registrar la venta
        });
    },

    onError: function(err) {
        console.error(err);
    }

  }).render('#paypal-button-container');

