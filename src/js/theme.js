import "bootstrap/dist/js/bootstrap.bundle";
import "@splidejs/splide/dist/js/splide.min";
import "@fancyapps/fancybox/dist/jquery.fancybox";
import Splide from "@splidejs/splide";

// Composants Builder
import { initCardCibleCarousel } from "./components/card-cible.js";
import { initReassurance } from "./components/reassurance.js";
import { initSliderTemoignages } from "./components/slider-temoignages.js";
import { initFAQAccordion } from "./components/faq.js";
import "./components/megamenu.js";

// Templates de pages
import { initActualitesListePage } from "./pages/actualites-liste.js";
import "./components/liste-realisations-avec-filtre.js";
import "./components/liste-expertise-avec-filtre.js";
import { initListingProcess } from "./components/listing-process.js";
import { initFriseChronologique } from "./components/frise-chronologique.js";
import { initOngletAccordion } from "./components/onglet-accordion.js";
import { initChiffresCles } from "./components/chiffres-cles.js";

// Initialisation au chargement du DOM
document.addEventListener("DOMContentLoaded", function () {
  // ============================================
  // COMPOSANTS BUILDER
  // ============================================

  // Initialiser le carrousel Card Cible
  if (document.querySelector(".carrousel-track")) {
    initCardCibleCarousel();
  }

  // Réassurance
  if (document.querySelector(".reassurance-section")) {
    initReassurance();
  }

  // Slider témoignage
  if (document.querySelector(".temoignages-section")) {
    initSliderTemoignages();
  }

  // FAQ
  if (document.querySelector(".faq-section-modern")) {
    initFAQAccordion();
  }

  if (document.querySelector(".carrousel-track-process")) {
    initListingProcess();
  }

  if (document.querySelector(".frise-chronologique-section")) {
    initFriseChronologique();
  }

  // Onglet Accordéon à propos
  if (document.querySelector(".onglet-accordion-section")) {
    initOngletAccordion();
  }

  if (document.querySelector(".chiffres-cles-section")) {
    initChiffresCles();
  }
  // ============================================
  // TEMPLATES DE PAGES
  // ============================================

  // Page Actualités - Liste
  if (document.querySelector(".actualites-liste")) {
    initActualitesListePage();
  }
});

jQuery(document).ready(function ($) {
  // ============================================
  // MENU STICKY & AUTOHIDE
  // ============================================

  var el_autohide = document.querySelector(".autohide");
  if (el_autohide) {
    var last_scroll_top = 0;
    window.addEventListener("scroll", function () {
      let scroll_top = window.scrollY;
      if (scroll_top === 0) {
        el_autohide.classList.remove("scrolled-up");
        el_autohide.classList.remove("scrolled-down");
      } else if (scroll_top < last_scroll_top) {
        el_autohide.classList.remove("scrolled-down");
        el_autohide.classList.add("scrolled-up");
      } else {
        el_autohide.classList.remove("scrolled-up");
        el_autohide.classList.add("scrolled-down");
      }
      last_scroll_top = scroll_top;
    });
  }

  // ============================================
  // CAROUSELS SPLIDE
  // ============================================

  // Carousel Images
  if ($(".image-carousel").length != 0) {
    $(".image-carousel").each(function () {
      new Splide(this, {
        updateOnMove: true,
        type: "loop",
        arrows: true,
        padding: "150px",
        pagination: false,
        perPage: 3,
        breakpoints: {
          576: {
            perPage: 1,
            padding: "50px",
          },
          991: {
            perPage: 2,
            padding: "50px",
          },
        },
      }).mount();
    });
  }

  // Carousel Logos
  if ($(".logo-carousel").length != 0) {
    $(".logo-carousel").each(function () {
      new Splide(this, {
        updateOnMove: true,
        perPage: 7,
        type: "loop",
        arrows: true,
        pagination: false,
        breakpoints: {
          576: {
            perPage: 2,
            padding: "30px",
          },
        },
      }).mount();
    });
  }

  // Carousel Cards
  if ($(".cards-carousel").length != 0) {
    $(".cards-carousel").each(function () {
      new Splide(this, {
        updateOnMove: true,
        perPage: 5,
        type: "loop",
        arrows: true,
        pagination: false,
        breakpoints: {
          576: {
            perPage: 2,
          },
          768: {
            perPage: 3,
          },
          990: {
            perPage: 4,
          },
        },
      }).mount();
    });
  }

  // ============================================
  // DROPDOWNS MOBILE
  // ============================================

  $(".dropdown-toggle").click(function () {
    window.location.href = $(this).attr("href");
  });

  $(".mobile-toggler").click(function () {
    $(".dropdown-toggle")
      .not($(this).parent().find(".dropdown-toggle"))
      .removeClass("show");
    $(this).parent().find(".dropdown-toggle").toggleClass("show");
  });
});
