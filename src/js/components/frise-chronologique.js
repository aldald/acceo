/**
 * Frise Chronologique - Module
 */

export function initFriseChronologique() {
  // ============================================
  // Configuration
  // ============================================
  
  const track = document.querySelector('.frise-carrousel-track');
  const prevBtn = document.querySelector('.carrousel-prev-frise');
  const nextBtn = document.querySelector('.carrousel-next-frise');
  const timelinePoints = document.querySelectorAll('.timeline-point');
  
  if (!track || !prevBtn || !nextBtn) return;
  
  const totalSlides = parseInt(track.dataset.totalSlides) || 0;
  let currentSlide = 0;
  
  // ============================================
  // Fonctions
  // ============================================
  
  /**
   * Déplacer vers une slide spécifique
   */
  function goToSlide(index) {
    if (index < 0 || index >= totalSlides) return;
    
    currentSlide = index;
    const offset = currentSlide * -100;
    track.style.transform = `translateX(${offset}%)`;
    
    // Mettre à jour les boutons
    updateButtons();
    
    // Mettre à jour les points de la timeline
    updateTimelinePoints();
  }
  
  /**
   * Slide suivante
   */
  function nextSlide() {
    if (currentSlide < totalSlides - 1) {
      goToSlide(currentSlide + 1);
    }
  }
  
  /**
   * Slide précédente
   */
  function prevSlide() {
    if (currentSlide > 0) {
      goToSlide(currentSlide - 1);
    }
  }
  
  /**
   * Mettre à jour l'état des boutons
   */
  function updateButtons() {
    // Désactiver/Activer le bouton précédent
    if (currentSlide === 0) {
      prevBtn.disabled = true;
      prevBtn.style.opacity = '0.3';
      prevBtn.style.cursor = 'not-allowed';
    } else {
      prevBtn.disabled = false;
      prevBtn.style.opacity = '1';
      prevBtn.style.cursor = 'pointer';
    }
    
    // Désactiver/Activer le bouton suivant
    if (currentSlide === totalSlides - 1) {
      nextBtn.disabled = true;
      nextBtn.style.opacity = '0.3';
      nextBtn.style.cursor = 'not-allowed';
    } else {
      nextBtn.disabled = false;
      nextBtn.style.opacity = '1';
      nextBtn.style.cursor = 'pointer';
    }
  }
  
  /**
   * Mettre à jour les points de la timeline
   */
  function updateTimelinePoints() {
    timelinePoints.forEach((point, index) => {
      if (index === currentSlide) {
        point.classList.add('active');
      } else {
        point.classList.remove('active');
      }
    });
  }
  
  // ============================================
  // Events Listeners
  // ============================================
  
  // Boutons navigation
  prevBtn.addEventListener('click', prevSlide);
  nextBtn.addEventListener('click', nextSlide);
  
  // Points de la timeline
  timelinePoints.forEach((point, index) => {
    point.addEventListener('click', () => {
      goToSlide(index);
    });
  });
  
  // Navigation clavier
  document.addEventListener('keydown', (e) => {
    if (e.key === 'ArrowLeft') {
      prevSlide();
    } else if (e.key === 'ArrowRight') {
      nextSlide();
    }
  });
  
  // Swipe sur mobile
  let touchStartX = 0;
  let touchEndX = 0;
  
  track.addEventListener('touchstart', (e) => {
    touchStartX = e.changedTouches[0].screenX;
  });
  
  track.addEventListener('touchend', (e) => {
    touchEndX = e.changedTouches[0].screenX;
    handleSwipe();
  });
  
  function handleSwipe() {
    const swipeThreshold = 50;
    const diff = touchStartX - touchEndX;
    
    if (Math.abs(diff) > swipeThreshold) {
      if (diff > 0) {
        // Swipe gauche → suivant
        nextSlide();
      } else {
        // Swipe droite → précédent
        prevSlide();
      }
    }
  }
  
  // ============================================
  // Initialisation
  // ============================================
  
  updateButtons();
  updateTimelinePoints();
}