/**
 * Template: Actualités - Liste
 * Gestion des filtres et animations pour la page actualités
 * 
 * @package churchill
 */

/**
 * Initialisation des filtres par catégorie
 */
export function initActualitesFilters() {
    const filterBtns = document.querySelectorAll('.actualites-filters .filter-btn');
    const actualiteItems = document.querySelectorAll('.actualite-item');

    if (filterBtns.length === 0 || actualiteItems.length === 0) {
        return;
    }

    // Événements sur les boutons de filtre
    filterBtns.forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Retirer la classe active de tous les boutons
            filterBtns.forEach(function(b) {
                b.classList.remove('active');
            });
            
            // Ajouter la classe active au bouton cliqué
            this.classList.add('active');
            
            // Récupérer le filtre
            const filter = this.getAttribute('data-filter');
            
            // Appliquer le filtre
            filterActualites(filter, actualiteItems);
        });
    });

    // Permettre le filtrage via URL (optionnel)
    // Ex: ?category=expertise
    const urlParams = new URLSearchParams(window.location.search);
    const categoryParam = urlParams.get('category');
    
    if (categoryParam) {
        const targetBtn = document.querySelector(`[data-filter="${categoryParam}"]`);
        if (targetBtn) {
            targetBtn.click();
        }
    }
}

/**
 * Fonction de filtrage des actualités
 */
function filterActualites(category, items) {
    let visibleCount = 0;

    items.forEach(function(item, index) {
        const itemCategory = item.getAttribute('data-category');
        
        if (category === '*' || itemCategory === category) {
            // Afficher l'item avec animation progressive
            item.classList.remove('hidden');
            
            setTimeout(function() {
                item.style.opacity = '1';
                item.style.transform = 'scale(1)';
            }, 50 * visibleCount); // Délai progressif
            
            visibleCount++;
        } else {
            // Masquer l'item
            item.style.opacity = '0';
            item.style.transform = 'scale(0.95)';
            
            setTimeout(function() {
                item.classList.add('hidden');
            }, 300);
        }
    });

    // Afficher un message si aucun résultat
    showNoResultsMessage(visibleCount);
}

/**
 * Afficher/masquer le message "Aucun résultat"
 */
function showNoResultsMessage(count) {
    const grid = document.getElementById('actualites-grid');
    if (!grid) return;

    let noResultsMsg = document.querySelector('.no-results-filter');

    if (count === 0) {
        if (!noResultsMsg) {
            noResultsMsg = document.createElement('div');
            noResultsMsg.className = 'col-12 no-results-filter';
            noResultsMsg.innerHTML = `
                <div class="alert alert-info text-center" role="alert">
                    <i class="bi bi-info-circle me-2"></i>
                    Aucune actualité ne correspond à ce filtre.
                </div>
            `;
            grid.appendChild(noResultsMsg);
        }
        noResultsMsg.style.display = 'block';
    } else {
        if (noResultsMsg) {
            noResultsMsg.style.display = 'none';
        }
    }
}

/**
 * Initialisation des animations au scroll
 */
export function initActualitesAnimations() {
    const actualiteItems = document.querySelectorAll('.actualite-item');
    
    if (actualiteItems.length === 0) return;

    // Options de l'observateur
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    // Créer l'observateur
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // Observer tous les items
    actualiteItems.forEach(function(item, index) {
        // État initial pour l'animation
        item.style.opacity = '0';
        item.style.transform = 'translateY(30px)';
        item.style.transition = `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
        
        observer.observe(item);
    });
}

/**
 * Initialisation complète de la page Actualités
 */
export function initActualitesListePage() {
    initActualitesFilters();
    initActualitesAnimations();
}