const modal = document.getElementById("reviewModal");
const closeModal = document.querySelector(".close-modal");
const restaurantNameModal = document.getElementById("restaurantNameModal");
const restaurantIdInput = document.getElementById("restaurantIdInput");
const ratingStars = document.querySelectorAll(".rating-star");
const ratingInput = document.getElementById("ratingInput");

// Tambahkan event listener ke tombol review
document.querySelectorAll(".review-button").forEach((button) => {
    button.addEventListener("click", function () {
        const restaurantId = this.getAttribute("data-restaurant-id");
        const restaurantName = this.getAttribute("data-restaurant-name");

        // Set nilai ke form
        restaurantNameModal.textContent = restaurantName;
        restaurantIdInput.value = restaurantId;

        // Reset rating
        ratingStars.forEach((star) => star.classList.remove("selected"));
        ratingInput.value = "";

        // Tampilkan modal
        modal.style.display = "flex";
    });
});

// Tutup modal saat klik tombol close
closeModal.addEventListener("click", function () {
    modal.style.display = "none";
});

// Tutup modal saat klik di luar modal
window.addEventListener("click", function (event) {
    if (event.target === modal) {
        modal.style.display = "none";
    }
});

// Handling rating stars
ratingStars.forEach((star) => {
    star.addEventListener("click", function () {
        const rating = parseInt(this.getAttribute("data-rating"));
        ratingInput.value = rating;

        // Update tampilan bintang
        ratingStars.forEach((s) => {
            if (parseInt(s.getAttribute("data-rating")) <= rating) {
                s.classList.add("selected");
            } else {
                s.classList.remove("selected");
            }
        });
    });

    // Hover effect
    star.addEventListener("mouseover", function () {
        const rating = parseInt(this.getAttribute("data-rating"));

        ratingStars.forEach((s) => {
            if (parseInt(s.getAttribute("data-rating")) <= rating) {
                s.style.color = "#FFD700";
            }
        });
    });

    star.addEventListener("mouseout", function () {
        ratingStars.forEach((s) => {
            if (!s.classList.contains("selected")) {
                s.style.color = "#ddd";
            }
        });
    });
});
