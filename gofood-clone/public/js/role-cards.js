document.addEventListener("DOMContentLoaded", () => {
    const roleCards = document.querySelectorAll(".role-card");

    roleCards.forEach((card) => {
        card.addEventListener("mouseenter", function () {
            const roleId = this.getAttribute("data-role");

            // Add hover class to the current card
            this.classList.add("hovered");

            // Update URL parameter without page reload
            const url = new URL(window.location.href);
            url.searchParams.set("hover", roleId);
            window.history.replaceState({}, "", url);
        });

        card.addEventListener("mouseleave", function () {
            // Remove hover class
            this.classList.remove("hovered");

            // Remove URL parameter without page reload
            const url = new URL(window.location.href);
            url.searchParams.delete("hover");
            window.history.replaceState({}, "", url);
        });
    });

    // Check if there's a hover parameter in the URL
    const urlParams = new URLSearchParams(window.location.search);
    const hoverParam = urlParams.get("hover");

    if (hoverParam) {
        const cardToHover = document.querySelector(
            `.role-card[data-role="${hoverParam}"]`
        );
        if (cardToHover) {
            cardToHover.classList.add("hovered");
        }
    }
});
