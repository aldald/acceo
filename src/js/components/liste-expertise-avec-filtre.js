document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.expertises-filters-sidebar .filter-btn');
    const expertiseItems = document.querySelectorAll('.expertise-item');

    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const filterValue = this.getAttribute('data-filter');

            // Retirer la classe active de tous les boutons
            filterButtons.forEach(btn => btn.classList.remove('active'));
            
            // Ajouter la classe active au bouton cliqué
            this.classList.add('active');

            // Filtrer les expertises
            expertiseItems.forEach(item => {
                if (filterValue === 'all' || item.classList.contains(filterValue.replace('cat-', 'cat-'))) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
});