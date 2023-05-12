const calculatePrice = async (
   e
) => {
   e.preventDefault();
   consoleToBuy = getValue("lblConsole")
   price = getValue("lblPrice")
   if (consoleToBuy.length<=20) {  
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
      document.getElementById('lblShowText').textContent = `Valor a cobrar`;
      document.getElementById('lblShowPrice').textContent = `${valorACobrar}`;
    });

    insertSale(e);

   }else{
      window.alert("The console name cannot be longer than 20 characters.")
   }
   
}
const insertSale = async (
   e
) => {   
   e.preventDefault();
   consoleToBuy = getValue("lblConsole")
   price = getValue("lblPrice")
   final_price = getValue("lblShowPrice")
   await fetch('http://localhost/DISCOUNTCALCULATOR-API/backend/sales', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({console:consoleToBuy,price:price,final_price:final_price})
    })
    .then(response => response.json())
}   

btnCalculatePrice.addEventListener("click", calculatePrice)

//function to get a value with the ElementById
function getValue(id) {
   return document.getElementById(id).value;
}
