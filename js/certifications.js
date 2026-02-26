const cards = document.querySelectorAll(".card");

        function updateClasses(activeIndex) {
            cards.forEach((card, index) => {
                card.classList.remove("active", "left", "right", "hidden");

                if (index === activeIndex) {
                    card.classList.add("active");
                } else if (index === activeIndex - 1) {
                    card.classList.add("left");
                } else if (index === activeIndex + 1) {
                    card.classList.add("right");
                } else {
                    card.classList.add("hidden");
                }
            });
        }

        cards.forEach((card, index) => {
            card.addEventListener("click", () => {
                updateClasses(index);
            });
        });

        // Initial state
        updateClasses(0);