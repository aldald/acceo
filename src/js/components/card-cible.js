/**
 * Carrousel Card Cible
 *
 * @package churchill
 */
export function initCardCibleCarousel() {
  function initCarousel(carousel) {
    const carouselId = carousel.id;

    // Chercher les boutons dans la section parente
    const section = carousel.closest(".vous-etes-section");
    if (!section) {
      console.error(
        "Section .vous-etes-section not found for carousel:",
        carouselId
      );
      return;
    }

    // Chercher les boutons sans l'attribut data-carousel (plus simple)
    const prevBtn = section.querySelector(".carrousel-prev");
    const nextBtn = section.querySelector(".carrousel-next");
    const cards = carousel.querySelectorAll(".vous-etes-carte");

    if (!prevBtn || !nextBtn || cards.length === 0) {
      console.error("Carrousel init failed:", {
        carouselId,
        prevBtn: !!prevBtn,
        nextBtn: !!nextBtn,
        cardsCount: cards.length,
      });
      return;
    }

    let currentIndex = 0;
    const cardWidth = 302;
    const gap = 24;
    const totalCards = cards.length;

    function getVisibleCards() {
      const containerWidth = carousel.parentElement.offsetWidth;
      return Math.floor(containerWidth / (cardWidth + gap));
    }

    function updateCarousel() {
      const offset = currentIndex * (cardWidth + gap);
      carousel.style.transform = `translateX(-${offset}px)`;
      carousel.style.transition = "transform 0.3s ease";

      const visibleCards = getVisibleCards();

      // Gérer l'état des boutons
      prevBtn.disabled = currentIndex === 0;
      nextBtn.disabled = currentIndex >= totalCards - visibleCards;

      // Classes visuelles
      prevBtn.classList.toggle("disabled", currentIndex === 0);
      nextBtn.classList.toggle(
        "disabled",
        currentIndex >= totalCards - visibleCards
      );
    }

    function goPrev() {
      if (currentIndex > 0) {
        currentIndex--;
        updateCarousel();
      }
    }

    function goNext() {
      const visibleCards = getVisibleCards();
      if (currentIndex < totalCards - visibleCards) {
        currentIndex++;
        updateCarousel();
      }
    }

    // Event listeners
    prevBtn.addEventListener("click", goPrev);
    nextBtn.addEventListener("click", goNext);

    // Resize handler
    let resizeTimer;
    window.addEventListener("resize", () => {
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(() => {
        currentIndex = 0;
        updateCarousel();
      }, 250);
    });

    // Touch support
    let touchStartX = 0;
    let touchEndX = 0;

    carousel.addEventListener(
      "touchstart",
      (e) => {
        touchStartX = e.changedTouches[0].screenX;
      },
      { passive: true }
    );

    carousel.addEventListener(
      "touchend",
      (e) => {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
      },
      { passive: true }
    );

    function handleSwipe() {
      const swipeThreshold = 50;
      const diff = touchStartX - touchEndX;

      if (Math.abs(diff) > swipeThreshold) {
        if (diff > 0) {
          goNext();
        } else {
          goPrev();
        }
      }
    }

    // Initial setup
    updateCarousel();
  }

  // Initialiser tous les carrousels
  const carousels = document.querySelectorAll(".carrousel-track");
  console.log("Found carousels:", carousels.length);

  carousels.forEach((carousel) => {
    if (carousel.id) {
      initCarousel(carousel);
    } else {
      console.error("Carousel missing ID:", carousel);
    }
  });
}
