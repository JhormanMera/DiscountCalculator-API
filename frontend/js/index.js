const calculatePrice = async (
   e
) => {
   e.preventDefault();
   
   consoleToBuy = getValue("lblConsole")
   price = getValue("lblPrice")
   console.log(JSON.stringify({console:consoleToBuy,price:price}))
   await fetch('http://localhost/DISCOUNTCALCULATOR-API/backend/discounts', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({console:consoleToBuy,price:price})
    })
    .then(response => response.json())
    .then(data => {
      valorACobrar = data.valorACobrar;
      document.getElementById('lblShowPrice').textContent = `Valor a cobrar: ${valorACobrar}`;
    });
}

btnCalculatePrice.addEventListener("click", calculatePrice)

//function to get a value with the ElementById
function getValue(id) {
   return document.getElementById(id).value;
}
