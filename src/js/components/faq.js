/**
 * FAQ Accordéon - Version multi-ouverture
 *
 * @package churchill
 */

export function initFAQAccordion() {
  const faqButtons = document.querySelectorAll("[data-faq-toggle]");

  if (faqButtons.length === 0) return;

  faqButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const targetId = this.getAttribute("data-faq-toggle");
      const targetAnswer = document.getElementById(`faq-answer-${targetId}`);
      const isExpanded = this.getAttribute("aria-expanded") === "true";

      // Toggle uniquement l'item actuel (sans fermer les autres)
      this.setAttribute("aria-expanded", !isExpanded);

      if (!isExpanded) {
        targetAnswer.classList.add("active");
      } else {
        targetAnswer.classList.remove("active");
      }
    });
  });

  // Ouvrir la première question par défaut
  if (faqButtons.length > 0) {
    const firstButton = faqButtons[0];
    const firstTargetId = firstButton.getAttribute("data-faq-toggle");
    const firstAnswer = document.getElementById(`faq-answer-${firstTargetId}`);

    firstButton.setAttribute("aria-expanded", "true");
    firstAnswer.classList.add("active");
  }
}
