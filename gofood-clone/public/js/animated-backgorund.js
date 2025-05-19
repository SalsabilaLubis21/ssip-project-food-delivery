document.addEventListener("DOMContentLoaded", () => {
    // Food pattern
    const foodPattern = document.querySelector(".food-pattern");
    if (foodPattern) {
        foodPattern.innerHTML = createFoodPattern();
    }

    // Food particles
    initFoodParticles();

    // Delivery routes
    initDeliveryRoutes();
});

function createFoodPattern() {
    return `
          <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
              <pattern id="food-pattern" x="0" y="0" width="100" height="100" patternUnits="userSpaceOnUse">
                  <!-- Burger icon -->
                  <path d="M30,30 C30,25 35,20 45,20 C55,20 60,25 60,30 L30,30 Z" fill="#00AA13" transform="translate(0, 0)" />
                  <path d="M30,35 L60,35 L60,40 L30,40 Z" fill="#00AA13" transform="translate(0, 0)" />
                  <path d="M30,45 C30,50 35,55 45,55 C55,55 60,50 60,45 L30,45 Z" fill="#00AA13" transform="translate(0, 0)" />
  
                  <!-- Pizza slice -->
                  <path d="M80,20 L95,45 L65,45 Z" fill="#00AA13" transform="translate(0, 0)" />
                  <circle cx="80" cy="30" r="2" fill="#fff" />
                  <circle cx="75" cy="35" r="2" fill="#fff" />
                  <circle cx="85" cy="35" r="2" fill="#fff" />
  
                  <!-- Noodle bowl -->
                  <circle cx="25" cy="80" r="15" fill="none" stroke="#00AA13" stroke-width="2" />
                  <path d="M15,75 Q25,65 35,75 M15,80 Q25,70 35,80 M15,85 Q25,75 35,85" fill="none" stroke="#00AA13" stroke-width="1.5" />
  
                  <!-- Coffee cup -->
                  <path d="M75,75 L85,75 L83,95 L77,95 Z" fill="none" stroke="#00AA13" stroke-width="1.5" />
                  <path d="M85,80 Q90,80 90,75 Q90,70 85,70" fill="none" stroke="#00AA13" stroke-width="1.5" />
                  <path d="M77,70 L83,70" fill="none" stroke="#00AA13" stroke-width="1.5" />
              </pattern>
              <rect x="0" y="0" width="100%" height="100%" fill="url(#food-pattern)" />
          </svg>
      `;
}

function initFoodParticles() {
    const canvas = document.getElementById("food-particles");
    if (!canvas) return;

    const ctx = canvas.getContext("2d");
    if (!ctx) return;

    // Set canvas dimensions
    const resizeCanvas = () => {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
    };

    resizeCanvas();
    window.addEventListener("resize", resizeCanvas);

    // Food emoji to use - more variety and larger set
    const foodEmojis = [
        "🍔",
        "🍕",
        "🍜",
        "🍣",
        "🍱",
        "🍲",
        "🍛",
        "🍗",
        "🥗",
        "🌮",
        "🌯",
        "🍦",
        "🧁",
        "🍝",
        "🥘",
        "🍚",
        "🍤",
        "🍟",
        "🌭",
        "🥪",
        "🥙",
        "🍨",
        "🍰",
        "☕",
        "🥤",
        "🍹",
    ];

    // Particle class
    class Particle {
        constructor() {
            this.x = Math.random() * canvas.width;
            this.y = Math.random() * canvas.height;
            this.emoji =
                foodEmojis[Math.floor(Math.random() * foodEmojis.length)];
            this.size = 15 + Math.random() * 25; // Larger size
            this.speedX = (Math.random() - 0.5) * 0.5;
            this.speedY = (Math.random() - 0.5) * 0.5;
            this.opacity = 0.15 + Math.random() * 0.25; // Slightly more visible
            this.rotation = Math.random() * 360;
            this.rotationSpeed = (Math.random() - 0.5) * 0.5;
        }

        update() {
            this.x += this.speedX;
            this.y += this.speedY;
            this.rotation += this.rotationSpeed;

            // Wrap around screen
            if (this.x < 0) this.x = canvas.width;
            if (this.x > canvas.width) this.x = 0;
            if (this.y < 0) this.y = canvas.height;
            if (this.y > canvas.height) this.y = 0;
        }

        draw() {
            ctx.save();
            ctx.translate(this.x, this.y);
            ctx.rotate((this.rotation * Math.PI) / 180);
            ctx.globalAlpha = this.opacity;
            ctx.font = `${this.size}px Arial`;
            ctx.textAlign = "center";
            ctx.textBaseline = "middle";
            ctx.fillText(this.emoji, 0, 0);
            ctx.restore();
        }
    }

    // Create particles - more particles for a richer background
    const particles = [];
    const particleCount = Math.min(
        40,
        Math.floor((window.innerWidth * window.innerHeight) / 30000)
    );

    for (let i = 0; i < particleCount; i++) {
        particles.push(new Particle());
    }

    // Animation loop
    const animate = () => {
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        particles.forEach((particle) => {
            particle.update();
            particle.draw();
        });

        requestAnimationFrame(animate);
    };

    animate();
}

function initDeliveryRoutes() {
    const deliveryRoutes = document.getElementById("delivery-routes");
    if (!deliveryRoutes) return;

    // Create first scooter
    const scooter1 = document.createElement("div");
    scooter1.className = "delivery-scooter scooter-1";
    scooter1.innerHTML = `
          <svg width="60" height="40" viewBox="0 0 60 40" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M15,30 C15,25 20,25 20,30 C20,35 15,35 15,30 Z" fill="#00AA13" stroke="#008F10" stroke-width="1" />
              <path d="M40,30 C40,25 45,25 45,30 C45,35 40,35 40,30 Z" fill="#00AA13" stroke="#008F10" stroke-width="1" />
              <path d="M20,30 L40,30 L35,15 L25,15 Z" fill="#00AA13" stroke="#008F10" stroke-width="1" />
              <path d="M35,15 L45,15 L45,25" fill="none" stroke="#008F10" stroke-width="1" />
              <rect x="25" y="5" width="10" height="10" fill="#FF4D00" stroke="#008F10" stroke-width="1" />
          </svg>
          <div class="delivery-trail"></div>
      `;
    scooter1.style.cssText = `
          position: absolute;
          top: 30%;
          left: -100px;
          animation: drive-right 20s linear infinite;
      `;

    // Create second scooter
    const scooter2 = document.createElement("div");
    scooter2.className = "delivery-scooter scooter-2";
    scooter2.innerHTML = `
          <svg width="60" height="40" viewBox="0 0 60 40" fill="none" xmlns="http://www.w3.org/2000/svg" style="transform: scaleX(-1)">
              <path d="M15,30 C15,25 20,25 20,30 C20,35 15,35 15,30 Z" fill="#00AA13" stroke="#008F10" stroke-width="1" />
              <path d="M40,30 C40,25 45,25 45,30 C45,35 40,35 40,30 Z" fill="#00AA13" stroke="#008F10" stroke-width="1" />
              <path d="M20,30 L40,30 L35,15 L25,15 Z" fill="#00AA13" stroke="#008F10" stroke-width="1" />
              <path d="M35,15 L45,15 L45,25" fill="none" stroke="#008F10" stroke-width="1" />
              <rect x="25" y="5" width="10" height="10" fill="#FF4D00" stroke="#008F10" stroke-width="1" />
          </svg>
          <div class="delivery-trail"></div>
      `;
    scooter2.style.cssText = `
          position: absolute;
          top: 70%;
          right: -100px;
          animation: drive-left 25s linear infinite;
      `;

    // Add scooters to the delivery routes
    deliveryRoutes.appendChild(scooter1);
    deliveryRoutes.appendChild(scooter2);

    // Add CSS animations
    const style = document.createElement("style");
    style.textContent = `
          @keyframes drive-right {
              0% { 
                  left: -100px; 
                  top: 30%;
              }
              20% {
                  top: 35%;
              }
              50% {
                  top: 25%;
              }
              80% {
                  top: 40%;
              }
              100% { 
                  left: calc(100% + 100px); 
                  top: 30%;
              }
          }
          
          @keyframes drive-left {
              0% { 
                  right: -100px; 
                  top: 70%;
              }
              20% {
                  top: 65%;
              }
              50% {
                  top: 75%;
              }
              80% {
                  top: 60%;
              }
              100% { 
                  right: calc(100% + 100px); 
                  top: 70%;
              }
          }
          
          .delivery-trail {
              position: absolute;
              top: 50%;
              right: 100%;
              width: 80px;
              height: 4px;
              background: linear-gradient(to right, transparent, rgba(0, 170, 19, 0.2));
              animation: trail-fade 2s infinite;
          }
          
          @keyframes trail-fade {
              0% { opacity: 0; }
              50% { opacity: 0.5; }
              100% { opacity: 0; }
          }
      `;
    document.head.appendChild(style);
}
