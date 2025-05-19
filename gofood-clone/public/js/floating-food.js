document.addEventListener("DOMContentLoaded", () => {
    initFloatingFood();
});

function initFloatingFood() {
    const floatingFoodContainer = document.getElementById("floating-food");
    if (!floatingFoodContainer) return;

    // Food items with their SVG
    const foodItems = [
        {
            name: "burger",
            svg: `
                  <svg width="40" height="40" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M20,30 C20,20 35,10 50,10 C65,10 80,20 80,30 L20,30 Z" fill="#FF9A3C" />
                      <path d="M20,35 L80,35 L80,45 L20,45 Z" fill="#8B4513" />
                      <path d="M20,50 L80,50 L80,60 L20,60 Z" fill="#FFD700" />
                      <path d="M20,65 C20,75 35,85 50,85 C65,85 80,75 80,65 L20,65 Z" fill="#FF9A3C" />
                  </svg>
              `,
        },
        {
            name: "pizza",
            svg: `
                  <svg width="40" height="40" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M50,10 L90,80 L10,80 Z" fill="#FFA500" />
                      <circle cx="50" cy="30" r="5" fill="#FF0000" />
                      <circle cx="40" cy="50" r="5" fill="#FF0000" />
                      <circle cx="60" cy="50" r="5" fill="#FF0000" />
                      <circle cx="35" cy="65" r="5" fill="#FF0000" />
                      <circle cx="65" cy="65" r="5" fill="#FF0000" />
                  </svg>
              `,
        },
        {
            name: "noodles",
            svg: `
                  <svg width="40" height="40" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <circle cx="50" cy="60" r="30" fill="#F5DEB3" />
                      <path d="M30,40 Q50,20 70,40 M25,50 Q50,30 75,50 M30,60 Q50,40 70,60" stroke="#FFD700" stroke-width="3" fill="none" />
                      <circle cx="50" cy="60" r="5" fill="#FF0000" />
                  </svg>
              `,
        },
        {
            name: "coffee",
            svg: `
                  <svg width="40" height="40" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M30,30 L70,30 L65,80 L35,80 Z" fill="#8B4513" />
                      <path d="M30,30 L70,30 L70,40 L30,40 Z" fill="#D2B48C" />
                      <path d="M70,50 Q90,50 90,40 Q90,30 70,30" fill="none" stroke="#8B4513" stroke-width="5" />
                  </svg>
              `,
        },
    ];

    // Create 6 random food items
    for (let i = 0; i < 6; i++) {
        const foodItem = document.createElement("div");
        foodItem.className = "food-item";

        // Random position
        const x = Math.random() * 100;
        const y = Math.random() * 100;

        // Random movement values
        const tx = Math.random() * 100 - 50;
        const ty = Math.random() * 100 - 50;
        const tr = Math.random() * 360;
        const duration = 20 + Math.random() * 20;

        foodItem.style.cssText = `
              left: ${x}%;
              top: ${y}%;
              --tx: ${tx}px;
              --ty: ${ty}px;
              --tr: ${tr}deg;
              animation-duration: ${duration}s;
          `;

        // Random food
        const randomFood =
            foodItems[Math.floor(Math.random() * foodItems.length)];
        foodItem.innerHTML = randomFood.svg;

        floatingFoodContainer.appendChild(foodItem);
    }
}
