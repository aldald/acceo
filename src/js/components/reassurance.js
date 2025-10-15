/**
 * Réassurance - Animation Chiffres (une seule fois)
 *
 * @package churchill
 */

export function initReassurance() {
  let hasAnimated = false;

  /**
   * Animation d'incrémentation des chiffres
   */
  function animateCounter(element) {
    const target = element.getAttribute("data-target");
    // Extraire le nombre et les caractères non numériques
    const numMatch = target.match(/[\d\s]+/);
    const suffixMatch = target.match(/[^\d\s]+$/);
    const targetNumber = numMatch
      ? parseInt(numMatch[0].replace(/\s/g, ""))
      : 0;
    const suffix = suffixMatch ? suffixMatch[0] : "";

    const duration = 2000;
    const startTime = performance.now();

    const updateCounter = (currentTime) => {
      const elapsed = currentTime - startTime;
      const progress = Math.min(elapsed / duration, 1);
      const easeOut = 1 - Math.pow(1 - progress, 4);
      const currentNumber = Math.floor(easeOut * targetNumber);
      const formattedNumber = currentNumber.toLocaleString("fr-FR");

      element.textContent = formattedNumber + suffix;

      if (progress < 1) {
        requestAnimationFrame(updateCounter);
      } else {
        element.textContent = target;
      }
    };

    requestAnimationFrame(updateCounter);
  }

  /**
   * Animer toutes les boxes avec un délai
   */
  function animateAllBoxes() {
    const boxes = document.querySelectorAll(".reassurance-box");

    boxes.forEach((box, index) => {
      // Ajouter la classe fade-ready si pas déjà présente
      if (!box.classList.contains("fade-ready")) {
        box.classList.add("fade-ready");
      }

      // Animer chaque box avec un délai
      setTimeout(() => {
        box.classList.add("animated", "fade-in");
      }, index * 100);
    });
  }

  /**
   * Animer tous les compteurs
   */
  function animateAllCounters() {
    const counters = document.querySelectorAll("[data-counter]");

    counters.forEach((counter, index) => {
      // Ajouter un léger délai entre chaque compteur pour un effet cascade
      setTimeout(() => {
        if (!counter.classList.contains("counted")) {
          counter.classList.add("counted");
          animateCounter(counter);
        }
      }, index * 150);
    });
  }

  /**
   * Observer la section entière (une seule fois)
   */
  function initSectionObserver() {
    // Chercher la section de réassurance
    const section = document.querySelector(
      ".reassurance-section, .section-reassurance, [data-section='reassurance']"
    );

    if (!section) {
      console.log("Section reassurance non trouvée");
      return;
    }

    // Créer l'observer pour la section
    const sectionObserver = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          // Si la section est visible ET qu'on n'a pas encore animé
          if (entry.isIntersecting && !hasAnimated) {
            hasAnimated = true; // Marquer comme animé

            // Lancer toutes les animations
            animateAllBoxes();
            animateAllCounters();

            // IMPORTANT: Déconnecter l'observer pour ne plus observer
            sectionObserver.unobserve(entry.target);
            sectionObserver.disconnect();
          }
        });
      },
      {
        threshold: 0.2, // Se déclenche quand 20% de la section est visible
        rootMargin: "0px 0px -100px 0px", // Déclenche un peu avant d'arriver au centre
      }
    );

    // Observer la section
    sectionObserver.observe(section);
  }

  /**
   * Alternative : Observer avec un flag par élément
   * (si vous préférez garder l'observation individuelle)
   */
  function initIndividualObservers() {
    const counters = document.querySelectorAll("[data-counter]");
    const boxes = document.querySelectorAll(".reassurance-box");

    if (!counters.length && !boxes.length) return;

    // Observer pour les compteurs
    const counterObserver = new IntersectionObserver(
      (entries, observer) => {
        entries.forEach((entry) => {
          if (
            entry.isIntersecting &&
            !entry.target.classList.contains("counted")
          ) {
            entry.target.classList.add("counted");
            animateCounter(entry.target);

            // DÉCONNECTER cet élément spécifique après animation
            observer.unobserve(entry.target);
          }
        });
      },
      {
        threshold: 0.5,
        rootMargin: "0px",
      }
    );

    // Observer pour les boxes
    const boxObserver = new IntersectionObserver(
      (entries, observer) => {
        entries.forEach((entry) => {
          if (
            entry.isIntersecting &&
            !entry.target.classList.contains("animated")
          ) {
            const boxIndex =
              parseInt(entry.target.getAttribute("data-box-index")) || 0;

            setTimeout(() => {
              entry.target.classList.add("animated", "fade-in");
            }, boxIndex * 100);

            // DÉCONNECTER cet élément spécifique après animation
            observer.unobserve(entry.target);
          }
        });
      },
      {
        threshold: 0.1,
        rootMargin: "0px",
      }
    );

    // Observer chaque élément
    counters.forEach((counter) => counterObserver.observe(counter));
    boxes.forEach((box) => {
      box.classList.add("fade-ready");
      boxObserver.observe(box);
    });
  }

  /**
   * Méthode pour réinitialiser les animations (utile pour le debug)
   */
  window.resetReassuranceAnimations = function () {
    hasAnimated = false;

    // Retirer les classes d'animation
    document.querySelectorAll("[data-counter].counted").forEach((el) => {
      el.classList.remove("counted");
      el.textContent = "0";
    });

    document.querySelectorAll(".reassurance-box.animated").forEach((el) => {
      el.classList.remove("animated", "fade-in");
    });

    // Réinitialiser l'observer
    initSectionObserver();
  };

  // Initialiser avec la méthode de section globale
  initSectionObserver();

  // OU utiliser la méthode individuelle avec déconnexion
  // initIndividualObservers();
}
