// Pastikan elemen-elemen sudah dimuat
document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("reviewModal");
    const closeModal = document.querySelector(".close-modal");
    const restaurantNameModal = document.getElementById("restaurantNameModal");
    const restaurantIdInput = document.getElementById("restaurantIdInput");
    const ratingStars = document.querySelectorAll(".rating-star");
    const ratingInput = document.getElementById("ratingInput");

    // Pastikan modal ada
    if (!modal) {
        console.error("Modal tidak ditemukan!");
        return;
    }

    // Fungsi untuk membuka modal review
    window.openReviewModal = function (restaurantId, restaurantName) {
        console.log("openReviewModal dipanggil", restaurantId, restaurantName);

        // Set nilai ke form
        if (restaurantNameModal)
            restaurantNameModal.textContent = restaurantName;
        if (restaurantIdInput) restaurantIdInput.value = restaurantId;

        // Reset rating
        if (ratingStars) {
            ratingStars.forEach((star) => star.classList.remove("selected"));
        }
        if (ratingInput) ratingInput.value = "";

        // Tampilkan modal
        modal.style.display = "flex";
    };

    // Tambahkan event listener ke tombol review
    document.querySelectorAll(".review-button").forEach((button) => {
        button.addEventListener("click", function () {
            const restaurantId = this.getAttribute("data-restaurant-id");
            const restaurantName = this.getAttribute("data-restaurant-name");

            console.log("Tombol review diklik", restaurantId, restaurantName);
            openReviewModal(restaurantId, restaurantName);
        });
    });

    // Tutup modal saat klik tombol close
    if (closeModal) {
        closeModal.addEventListener("click", function () {
            console.log("Tombol close diklik");
            modal.style.display = "none";
        });
    } else {
        console.error("Tombol close modal tidak ditemukan!");
    }

    // Tutup modal saat klik di luar modal
    window.addEventListener("click", function (event) {
        if (event.target === modal) {
            console.log("Klik di luar modal");
            modal.style.display = "none";
        }
    });

    // Tutup modal dengan tombol escape
    document.addEventListener("keydown", function (event) {
        if (event.key === "Escape" && modal.style.display === "flex") {
            console.log("Tombol Escape ditekan");
            modal.style.display = "none";
        }
    });

    // Handling rating stars
    if (ratingStars) {
        ratingStars.forEach((star) => {
            star.addEventListener("click", function () {
                const rating = parseInt(this.getAttribute("data-rating"));
                if (ratingInput) ratingInput.value = rating;

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
    }
});
