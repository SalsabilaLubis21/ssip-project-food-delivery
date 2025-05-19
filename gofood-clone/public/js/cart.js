document.addEventListener("DOMContentLoaded", function () {
    let cart = [];

    function addToCart(menuId, menuName, price) {
        cart.push({ menuId, menuName, price });
        console.log("Added to cart:", menuName);
    }

    document.querySelectorAll(".add-to-cart").forEach((button) => {
        button.addEventListener("click", function () {
            const menuId = this.dataset.menuId;
            const menuName = this.dataset.menuName;
            const price = parseFloat(this.dataset.price);

            addToCart(menuId, menuName, price);
        });
    });
});
