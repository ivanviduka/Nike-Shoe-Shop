let cartItems = [];
let addToCartButtons;

window.onload = (event) => {
    addToCartButtons = document.querySelectorAll(".add-to-cart")
    addToCartButtons.forEach(button => {
        button.addEventListener('click', addToCart);
    })

    if (document.querySelector(".selected-shoes-list").getElementsByTagName("li").length == 0) {
        document.getElementById("buy-from-mini-cart").setAttribute("disabled", "true");
    }


    if (document.getElementById("success-message")) {
        setTimeout(function () {
            document.getElementById("success-message").style.display = "none";
        }, 4000);
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

    let list = document.querySelector(".selected-shoes-list");
    let listSize = list.getElementsByTagName("li").length;
    let li = document.createElement("li");

    let newItem = {
        id: event.target.id,
        name: selectedShoeName.innerHTML,
        img: selectedShoeImg,
        price: parseInt(selectedShoePrice.innerHTML),
        shoeSize: parseInt(selectedShoeSize)
    }

    cartItems.push(newItem);



    li.className = "row";
    li.innerHTML =
        `<input type='hidden' name="shoesArray[${listSize}][ID]" value="${newItem.id}"/>
        <input type='hidden' name="shoesArray[${listSize}][name]" value="${newItem.name}"/>
        <input type='hidden' name="shoesArray[${listSize}][imgURL]" value="${newItem.img}"/>
        <input type='hidden' name="shoesArray[${listSize}][price]" value="${newItem.price}"/>
        <input type='hidden' name="shoesArray[${listSize}][shoeSize]" value="${newItem.shoeSize}"/>
        <img src=${selectedShoeImg} alt="Selected Shoes" loading="lazy"
            width="100%" height="80%">

        <div class="shoe-info">
            <p>${selectedShoeName.innerHTML}</p>
            <span>Price: ${selectedShoePrice.innerHTML} </span>
            <span>Shoe Size: ${selectedShoeSize}</span>
            <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeFromCart(event)">REMOVE</button>
            <hr>
        </div>    

        </li>`

    list.appendChild(li);

    let shoppingCartCount = document.querySelector('#lblCartCount');
    shoppingCartCount.innerHTML = cartItems.length;
}


function removeFromCart(event) {
    event.preventDefault();

    let selectedShoes = event.target.parentNode.parentNode;
    let listOfShoes = selectedShoes.parentNode;

    let index = Array.from(listOfShoes.children).indexOf(selectedShoes);
    let listItemID = cartItems[index].id
    cartItems.splice(index, 1);
    listOfShoes.removeChild(selectedShoes);

    let addToCartButton = document.getElementById(`${listItemID}`)
    addToCartButton.disabled = false

    let shoppingCartCount = document.querySelector('#lblCartCount');
    shoppingCartCount.innerHTML = cartItems.length;

    if (document.querySelector(".selected-shoes-list").getElementsByTagName("li").length == 0) {
        document.getElementById("buy-from-mini-cart").setAttribute("disabled", "true");
    }

}