let cartItems = [];
let addToCartButtons;

window.onload = (event) => {
    addToCartButtons = document.querySelectorAll(".add-to-cart")
    addToCartButtons.forEach(button => {
        button.addEventListener('click', addToCart);
    })

    if(document.querySelector(".selected-shoes-list").getElementsByTagName("li").length == 0){
        document.getElementById("buy-from-mini-cart").setAttribute("disabled", "true");
    }
    
};

function addToCart(event) {

    event.preventDefault();
    event.target.setAttribute("disabled", "true");
    document.getElementById("buy-from-mini-cart").removeAttribute("disabled");

    let selectedProduct = event.target.parentNode;
    let parentElement = selectedProduct.parentNode;

    let selectedShoeName = selectedProduct.querySelector('h3');
    let selectedShoePrice = selectedProduct.querySelector('.shoe-price');
    let ShoeSizes = selectedProduct.querySelectorAll('.size-options input[type="radio"]');

    let selectedShoeSize;
    for (const rb of ShoeSizes) {
        if (rb.checked) {
            selectedShoeSize = rb.value;
            break;
        }
    }
    
    let selectedShoeImg = parentElement.firstElementChild.src;

    let newItem = {
        name: selectedShoeName.innerHTML,
        img: selectedShoeImg,
        price: parseInt(selectedShoePrice.innerHTML),
        quantity: parseInt(selectedShoeSize)
    }

    cartItems.push(newItem);

    

    let list = document.querySelector(".selected-shoes-list");
    let size = list.getElementsByTagName("li").length;
    let li = document.createElement("li");
 
    li.className = "row";
    li.innerHTML =
        `
        <img src=${selectedShoeImg} alt="Selected Shoes" loading="lazy"
            width="100%" height="80%">

        <div class="shoe-info">
            <p>${selectedShoeName.innerHTML}</p>
            <span>Price: ${selectedShoePrice.innerHTML} </span>
            <span>Shoe Size: ${selectedShoeSize}</span>
            <button type="button" class="btn btn-outline-danger btn-sm">REMOVE</button>
            <hr>
        </div>    

        </li>`

    list.appendChild(li);

    let shoppingCartCount = document.querySelector('#lblCartCount');
    shoppingCartCount.innerHTML = cartItems.length;
}
