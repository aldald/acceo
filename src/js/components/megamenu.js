// ============================================
// Mega Menu Component
// ============================================

document.addEventListener('DOMContentLoaded', function() {
    
    const vousEtesMenu = document.querySelector('.vous-etes-menu');
    if (vousEtesMenu && window.innerWidth >= 1200) {
        const megaMenu = vousEtesMenu.querySelector('.mega-menu-wrapper');
        let timeout;
        
        vousEtesMenu.addEventListener('mouseenter', () => {
            clearTimeout(timeout);
            if (megaMenu) {
                megaMenu.style.display = 'block';
                setTimeout(() => {
                    megaMenu.classList.add('show');
                }, 10);
            }
        });
        
        vousEtesMenu.addEventListener('mouseleave', () => {
            timeout = setTimeout(() => {
                if (megaMenu) {
                    megaMenu.classList.remove('show');
                    setTimeout(() => {
                        megaMenu.style.display = 'none';
                    }, 300);
                }
            }, 200);
        });
    }
    
    // ============================================
    // MOBILE MENU FIX (< 1200px)
    // ============================================
    if (window.innerWidth < 1200) {
        setupMobileMenu();
    }
    
    function setupMobileMenu() {
        const dropdownItems = document.querySelectorAll('.navbar-nav .dropdown');
        
        dropdownItems.forEach(item => {
            const link = item.querySelector('.nav-link');
            const submenu = item.querySelector('.dropdown-menu, .mega-menu-wrapper');
            
            if (!link || !submenu) return;
            
            // IMPORTANT: Forcer le positionnement correct des sous-menus
            submenu.style.position = 'static';
            submenu.style.display = 'none';
            
            // Créer un bouton toggle si nécessaire
            let toggler = item.querySelector('.mobile-toggler');
            if (!toggler) {
                toggler = document.createElement('span');
                toggler.className = 'mobile-toggler';
                toggler.setAttribute('aria-label', 'Toggle submenu');
                item.appendChild(toggler);
            }
            
            // Gérer le clic sur le toggle
            toggler.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                
                const isOpen = item.classList.contains('show');
                
                // Fermer tous les autres sous-menus
                dropdownItems.forEach(otherItem => {
                    if (otherItem !== item) {
                        otherItem.classList.remove('show');
                        const otherToggler = otherItem.querySelector('.mobile-toggler');
                        if (otherToggler) {
                            otherToggler.classList.remove('show');
                        }
                        const otherSubmenu = otherItem.querySelector('.dropdown-menu, .mega-menu-wrapper');
                        if (otherSubmenu) {
                            otherSubmenu.style.display = 'none';
                        }
                    }
                });
                
                // Toggle ce sous-menu
                if (!isOpen) {
                    item.classList.add('show');
                    toggler.classList.add('show');
                    submenu.style.display = 'block';
                    
                    // Animation d'ouverture
                    submenu.style.maxHeight = '0';
                    submenu.style.overflow = 'hidden';
                    setTimeout(() => {
                        submenu.style.maxHeight = submenu.scrollHeight + 'px';
                        setTimeout(() => {
                            submenu.style.maxHeight = 'none';
                            submenu.style.overflow = 'visible';
                        }, 300);
                    }, 10);
                } else {
                    item.classList.remove('show');
                    toggler.classList.remove('show');
                    
                    // Animation de fermeture
                    submenu.style.maxHeight = submenu.scrollHeight + 'px';
                    submenu.style.overflow = 'hidden';
                    setTimeout(() => {
                        submenu.style.maxHeight = '0';
                        setTimeout(() => {
                            submenu.style.display = 'none';
                        }, 300);
                    }, 10);
                }
            });
            
            // Permettre le clic sur le lien principal aussi
            link.addEventListener('click', (e) => {
                if (window.innerWidth < 1200 && item.classList.contains('dropdown')) {
                    e.preventDefault();
                    toggler.click();
                }
            });
        });
    }
    
    // Gérer le changement de taille de fenêtre
    let resizeTimer;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
            location.reload(); // Simple reload pour réinitialiser
        }, 250);
    });
    
});