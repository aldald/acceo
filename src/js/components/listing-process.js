/**
 * Listing Process - Carrousel
 *
 * @package churchill
 */

export function initListingProcess() {
  const track = document.querySelector(".carrousel-track-process");

  if (!track) return;

  const prevBtn = document.querySelector(".carrousel-prev-process");
  const nextBtn = document.querySelector(".carrousel-next-process");
  const slides = track.querySelectorAll(".process-carte");
  const totalSlides = slides.length;

  if (totalSlides === 0) return;

  let currentIndex = 0;

  /**
   * Calculer le décalage
   */
  function updatePosition() {
    if (slides.length === 0) return;

    const slideWidth = slides[0].offsetWidth;
    const gap =
      window.innerWidth > 1199 ? 32 : window.innerWidth > 860 ? 24 : 20;
    const offset = currentIndex * (slideWidth + gap);

    track.style.transform = `translateX(-${offset}px)`;

    // Désactiver les boutons si nécessaire
    prevBtn.disabled = currentIndex === 0;
    nextBtn.disabled = currentIndex >= totalSlides - 1;
  }

  /**
   * Navigation
   */
  if (prevBtn) {
    prevBtn.addEventListener("click", () => {
      if (currentIndex > 0) {
        currentIndex--;
        updatePosition();
      }
    });
  }

  if (nextBtn) {
    nextBtn.addEventListener("click", () => {
      if (currentIndex < totalSlides - 1) {
        currentIndex++;
        updatePosition();
      }
    });
  }

  // Initial position
  updatePosition();

  // Recalculer au redimensionnement
  let resizeTimer;
  window.addEventListener("resize", () => {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(updatePosition, 150);
  });
}
