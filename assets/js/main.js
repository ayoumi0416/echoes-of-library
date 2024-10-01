document.addEventListener("DOMContentLoaded", function () {
    const menuIcon = document.getElementById("menu-icon");
    const closeIcon = document.getElementById("close-icon");
    const sidebar = document.getElementById("sidebar");
    const overlay = document.getElementById("overlay");
  
    // Toggle sidebar open and close
    menuIcon.addEventListener("click", function () {
      sidebar.style.left = "0"; // Show the sidebar
      overlay.classList.remove("hidden"); // Show the overlay
    });
  
    closeIcon.addEventListener("click", function () {
      sidebar.style.left = "-100%"; // Hide the sidebar
      overlay.classList.add("hidden"); // Hide the overlay
    });
  
    // Hide sidebar when clicking on the overlay
    overlay.addEventListener("click", function () {
      sidebar.style.left = "-100%"; // Hide the sidebar
      overlay.classList.add("hidden"); // Hide the overlay
    });
  });
  
  // Function to filter food items by type
  function filterType(category) {
    const foodCards = document.querySelectorAll('.food-card');
  
    foodCards.forEach((card) => {
      if (category === 'all') {
        card.style.display = 'block'; // Show all items
      } else if (card.classList.contains(category)) {
        card.style.display = 'block'; // Show items matching the category
      } else {
        card.style.display = 'none'; // Hide items not matching the category
      }
    });
  }
  
  // Function to filter food items by price
  function filterPrice(price) {
    const foodCards = document.querySelectorAll('.food-card');
  
    foodCards.forEach((card) => {
      const itemPrice = card.querySelector('span').textContent;
      if (price === itemPrice) {
        card.style.display = 'block'; // Show items matching the price
      } else {
        card.style.display = 'none'; // Hide items not matching the price
      }
    });
  }
  