/**
 * Slider Témoignages - Carrousel
 *
 * @package churchill
 */

export function initSliderTemoignages() {
    
    const track = document.querySelector('.carrousel-track-temoignages');
    
    if (!track) return;
    
    const prevBtn = document.querySelector('.carrousel-prev-temoignages');
    const nextBtn = document.querySelector('.carrousel-next-temoignages');
    const slides = track.querySelectorAll('.temoignage-carte');
    const totalSlides = slides.length;
    
    if (totalSlides === 0) return;
    
    let currentIndex = 0;
    
    /**
     * Calculer le décalage
     */
    function updatePosition() {
        if (slides.length === 0) return;
        
        const slideWidth = slides[0].offsetWidth;
        const gap = 24; // Gap entre les cartes
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
        prevBtn.addEventListener('click', () => {
            if (currentIndex > 0) {
                currentIndex--;
                updatePosition();
            }
        });
    }
    
    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            if (currentIndex < totalSlides - 1) {
                currentIndex++;
                updatePosition();
            }
        });
    }
    
    // Initial position
    updatePosition();
    
    // Recalculer au redimensionnement
    window.addEventListener('resize', updatePosition);
    
    console.log('✅ Slider Témoignages initialisé');
}