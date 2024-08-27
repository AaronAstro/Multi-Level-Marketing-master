// JavaScript for toggle button
document.addEventListener("DOMContentLoaded", function () {
  const menuToggle = document.querySelector(".menu-toggle");
  const navLinks = document.querySelector(
    ".navigation-bar .wrapper nav .nav-links"
  );

  menuToggle.addEventListener("click", function () {
    navLinks.classList.toggle("active");
  });
});

// JavaScript for dropdown toggle
document.addEventListener("DOMContentLoaded", function () {
  const userIcon = document.querySelector(".user-icon");
  const dropdown = document.querySelector(".dropdown");

  userIcon.addEventListener("click", function () {
    dropdown.classList.toggle("active");
  });

  // Close dropdown when clicking outside
  document.addEventListener("click", function (event) {
    if (!dropdown.contains(event.target) && !userIcon.contains(event.target)) {
      dropdown.classList.remove("active");
    }
  });
});

// Wait for the DOM to fully load
document.addEventListener("DOMContentLoaded", function () {
  // Get the elements
  const toggleButton = document.getElementById("toggleButton");
  const categoryList = document.getElementById("categoryList");

  // Function to toggle the display of the category list
  function toggleCategoryList() {
    if (
      categoryList.style.display === "none" ||
      categoryList.style.display === ""
    ) {
      categoryList.style.display = "block";
    } else {
      categoryList.style.display = "none";
    }
  }

  // Add click event listeners
  toggleButton.addEventListener("click", toggleCategoryList);
});

/* CART */

document.addEventListener("DOMContentLoaded", () => {
  const MIN_VALUE = 1;

  // Function to calculate and display the total items in cart
  function updateTotalSum() {
    const numberInputs = document.querySelectorAll(".number-input");
    let total = 0;

    numberInputs.forEach((input) => {
      total += parseInt(input.value, 10) || 0;
    });

    document.getElementById("total-sum").innerHTML = total;
  }

  //remove an item
  function handleItemRemoval(container) {
    if (confirm("Do you want to delete this item?")) {
      const productId = container
        .closest(".cart-item")
        .getAttribute("data-product-id");

      container.closest(".cart-item").remove();
      //updateTotalSum(); // Update the total items after removing an item

      fetch("update_cart.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({ action: "remove", id: productId }),
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            container.closest(".cart-item").remove();
            updateTotalSum(); // Update the total sum after removing an item
            updateCartTotal();
          } else {
            console.error("Error removing item:", data.message);
          }
        })
        .catch((error) => console.error("Error:", error));

      sendUpdateToServer("remove", productId); // Handle removal if quantity is 1
    }
  }

  const containers = document.querySelectorAll(".number-input-container");
  //const MIN_VALUE = 1; // Assuming the minimum value is 1

  const delContainers = document.querySelectorAll(".cart-item-actions");
  delContainers.forEach((container) => {
    const deleteBtn = container.querySelector(".delete");

    function deleteItem(container) {
      handleItemRemoval(container);
    }

    deleteBtn.addEventListener("click", () => deleteItem(container));
  });

  containers.forEach((container) => {
    // Find the increment and decrement buttons and number input within this container
    const incrementButton = container.querySelector(
      'button[data-action="increment"]'
    );
    const decrementButton = container.querySelector(
      'button[data-action="decrement"]'
    );
    const numberInput = container.querySelector(".number-input");

    function updateValue(increment) {
      let currentValue = parseInt(numberInput.value, 10);
      const productId = container
        .closest(".cart-item")
        .getAttribute("data-product-id");

      const MAX_VAL = container
        .closest(".cart-item")
        .getAttribute("data-product-stock-number");

      console.log("Max-val = " + MAX_VAL);

      if (increment) {
        if (currentValue < MAX_VAL) {
          numberInput.value = currentValue + 1;
          sendUpdateToServer("increment", productId);
        } else {
          alert("We currently have " + --currentValue + " in stock");
        }
      } else {
        if (currentValue <= MIN_VALUE) {
          numberInput.value = MIN_VALUE; // Reset to minimum if less than or equal to MIN_VALUE
          handleItemRemoval(container); // Optionally remove the item from the DOM
        } else {
          numberInput.value = currentValue - 1;
          sendUpdateToServer("decrement", productId);
        }
      }
      updateTotalSum(); // Update the sum every time a button is clicked
      updateCartTotal();
    }

    function sendUpdateToServer(action, id) {
      fetch("update_cart.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({ action: action, id: id }),
      })
        .then((response) => response.json())
        .then((data) => {
          if (!data.success) {
            console.error("Error updating item:", data.message);
          }
        })
        .catch((error) => console.error("Error:", error));
    }

    // Add event listeners to buttons
    incrementButton.addEventListener("click", () => updateValue(true));
    decrementButton.addEventListener("click", () => updateValue(false));

    numberInput.addEventListener("keydown", (event) => {
      if (event.key === "ArrowUp" || event.key === "ArrowDown") {
        event.preventDefault();
      }
    });
  });

  updateTotalSum(); // Initialize the sum on page load
});

//add to cart
document.addEventListener("DOMContentLoaded", () => {
  const addToCartButtons = document.querySelectorAll(".add-to-cart");

  addToCartButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const productId = this.getAttribute("data-product-id");
      const productName = this.getAttribute("data-product-name");
      const productPrice = this.getAttribute("data-product-price");
      const productDescription = this.getAttribute("data-product-description");
      const productImage = this.getAttribute("data-product-image");
      const productStockNumber = this.getAttribute("data-product-stock-number");

      // Create an object to store the product details
      const productData = {
        id: productId,
        name: productName,
        price: productPrice,
        description: productDescription,
        image: productImage,
        stockNumber: productStockNumber,
      };

      // Send the product data to the server to update the session
      fetch("update_cart.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(productData),
      })
        .then((response) => response.json())
        .then((data) => {
          console.log("Cart updated:", data);
          //TODO: show slight view of cart on the
          alert(
            "Added to cart\n" +
              productName +
              "\nPrice: " +
              productPrice +
              "\nQuantity: +1" +
              "in Stock " +
              productStockNumber
          );
          // Optionally, you can update the UI to show the cart status
        })
        .catch((error) => console.error("Error:", error));
    });
  });
});

// calculate total
function updateCartTotal() {
  fetch("calculate_cart_total.php")
    .then((response) => response.json())
    .then((data) => {
      if (data && data.total) {
        // Update the total in the UI
        const subtotalElement = document.getElementById("cart-subtotal");
        const totalElement = document.getElementById("cart-total");
        if (totalElement && subtotalElement) {
          subtotalElement.textContent = `E${data.total}`;
          totalElement.textContent = `E${data.total}`;
        }
      } else {
        console.error("Error fetching cart total");
      }
    })
    .catch((error) => console.error("Error:", error));
}

// Call the function to update total on page load
document.addEventListener("DOMContentLoaded", updateCartTotal);
