/**
 * Onglet Accordéon - Module
 * Même logique que le composant FAQ
 */

export function initOngletAccordion() {
  // ============================================
  // Configuration
  // ============================================
  
  const accordionItems = document.querySelectorAll('.onglet-item');
  
  if (!accordionItems.length) return;
  
  // ============================================
  // Fonctions
  // ============================================
  
  /**
   * Fermer tous les accordéons
   */
  function closeAllAccordions() {
    accordionItems.forEach(item => {
      const toggle = item.querySelector('.onglet-toggle');
      const content = item.querySelector('.onglet-content');
      
      if (toggle && content) {
        toggle.setAttribute('aria-expanded', 'false');
        content.setAttribute('aria-hidden', 'true');
        content.style.display = 'none';
      }
    });
  }
  
  /**
   * Ouvrir un accordéon spécifique
   */
  function openAccordion(item) {
    const toggle = item.querySelector('.onglet-toggle');
    const content = item.querySelector('.onglet-content');
    
    if (toggle && content) {
      toggle.setAttribute('aria-expanded', 'true');
      content.setAttribute('aria-hidden', 'false');
      content.style.display = 'block';
    }
  }
  
  /**
   * Toggle un accordéon
   */
  function toggleAccordion(item) {
    const toggle = item.querySelector('.onglet-toggle');
    const isExpanded = toggle.getAttribute('aria-expanded') === 'true';
    
    // Fermer tous les autres
    closeAllAccordions();
    
    // Si celui-ci était fermé, l'ouvrir
    if (!isExpanded) {
      openAccordion(item);
    }
  }
  
  // ============================================
  // Event Listeners
  // ============================================
  
  accordionItems.forEach(item => {
    const toggle = item.querySelector('.onglet-toggle');
    
    if (toggle) {
      toggle.addEventListener('click', () => {
        toggleAccordion(item);
      });
      
      // Accessibilité clavier
      toggle.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          toggleAccordion(item);
        }
      });
    }
  });
  
  // ============================================
  // Initialisation
  // ============================================
  
  // Le premier accordéon est déjà ouvert par défaut dans le PHP
  // Pas besoin d'action supplémentaire ici
}