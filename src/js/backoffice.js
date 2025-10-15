/**
 * Backoffice Scripts - TinyMCE Plugins
 *
 * @package churchill
 */

(function () {
  "use strict";

  /**
   * Vérifier si TinyMCE est disponible
   */
  function isTinyMCEReady() {
    return typeof tinymce !== "undefined" && tinymce.PluginManager;
  }

  /**
   * Initialiser tous les plugins TinyMCE
   */
  function initTinyMCEPlugins() {
    console.log("🔧 Churchill TinyMCE Plugins - Initialisation...");

    // =========================================
    // PLUGIN : Bouton
    // =========================================
    tinymce.PluginManager.add(
      "add_mce_shortcode_button",
      function (editor, url) {
        editor.addButton("add_mce_shortcode_button", {
          text: "Bouton",
          title: "",
          icon: "mce-ico mce-i-link",
          onclick: function () {
            var wptExtLinkGetSelection = tinyMCE.activeEditor.selection;
            var wptExtLinkSelectedText = wptExtLinkGetSelection.getContent({
              format: "text",
            });
            var wptExtLinkGetHref = wptExtLinkGetSelection
              .getNode()
              .getAttribute("href");
            var wptExtLinkGetTarget = wptExtLinkGetSelection
              .getNode()
              .getAttribute("target");
            var wptExtLinkGetDownload = wptExtLinkGetSelection
              .getNode()
              .getAttribute("download");

            var wptexl_TargetChecked = !!wptExtLinkGetTarget;
            var wptexl_DownloadChecked = !!wptExtLinkGetDownload;

            editor.windowManager.open({
              title: "Insérer un bouton",
              body: [
                {
                  type: "listbox",
                  name: "wptexl_ButtonType",
                  label: "Style",
                  disabled: false,
                  values: [
                    { text: "Bleu foncé", value: "dark" },
                    { text: "Bleu clair", value: "blue" },
                  ],
                },
                {
                  type: "textbox",
                  name: "wptexl_LinkText",
                  label: "Texte",
                  value: wptExtLinkSelectedText,
                  minWidth: 600,
                },
                {
                  type: "textbox",
                  name: "wptexl_URL",
                  label: "URL",
                  value: wptExtLinkGetHref,
                  minWidth: 600,
                },
                {
                  type: "checkbox",
                  name: "wptexl_Target",
                  label: "Ouvrir dans un nouvel onglet",
                  maxWidth: 30,
                  checked: wptexl_TargetChecked,
                },
                {
                  type: "checkbox",
                  name: "wptexl_Download",
                  label: "Proposer le téléchargement",
                  maxWidth: 30,
                  tooltip: "Téléchargement direct si le lien est un fichier",
                  checked: wptexl_DownloadChecked,
                },
              ],
              onsubmit: function (e) {
                var wptexlAttrTarget =
                  e.data.wptexl_Target === true ? 'new_tab="true"' : "";
                var wptexlAttrDownload =
                  e.data.wptexl_Download === true ? 'download="true"' : "";

                editor.insertContent(
                  '[button class="' +
                    e.data.wptexl_ButtonType +
                    '" text="' +
                    e.data.wptexl_LinkText +
                    '" href="' +
                    e.data.wptexl_URL +
                    '" ' +
                    wptexlAttrDownload +
                    " " +
                    wptexlAttrTarget +
                    "]"
                );
              },
            });
          },
        });
      }
    );

    // =========================================
    // PLUGIN : Tableau
    // =========================================
    tinymce.PluginManager.add(
      "add_mce_shortcode_table",
      function (editor, url) {
        editor.addButton("add_mce_shortcode_table", {
          text: "Tableau",
          title: "",
          icon: "mce-ico mce-i-alignjustify",
          onclick: function () {
            editor.windowManager.open({
              title: "Insérer un tableau",
              body: [
                {
                  type: "listbox",
                  name: "wptexl_TableID",
                  label: "Tableau",
                  disabled: false,
                  values:
                    typeof php_vars !== "undefined" && php_vars.tables
                      ? php_vars.tables
                      : [],
                },
              ],
              onsubmit: function (e) {
                editor.insertContent(
                  '[table id="' + e.data.wptexl_TableID + '"]'
                );
              },
            });
          },
        });
      }
    );

    // =========================================
    // PLUGIN : Vidéo
    // =========================================
    tinymce.PluginManager.add(
      "add_mce_shortcode_video",
      function (editor, url) {
        editor.addButton("add_mce_shortcode_video", {
          text: "Vidéo",
          title: "",
          icon: "mce-ico mce-i-wp-media-library",
          onclick: function () {
            editor.windowManager.open({
              title: "Insérer une vidéo",
              body: [
                {
                  type: "textbox",
                  name: "wptexl_UrlVideo",
                  label: "URL de la vidéo",
                  minWidth: 600,
                },
                {
                  type: "textbox",
                  name: "wptexl_Image",
                  label: "URL de l'image de couverture",
                  minWidth: 600,
                },
              ],
              onsubmit: function (e) {
                editor.insertContent(
                  '[modal_video url="' +
                    e.data.wptexl_UrlVideo +
                    '" image="' +
                    e.data.wptexl_Image +
                    '"]'
                );
              },
            });
          },
        });
      }
    );

    // =========================================
    // PLUGIN : Étapes
    // =========================================
    tinymce.PluginManager.add(
      "add_mce_shortcode_steps",
      function (editor, url) {
        editor.addButton("add_mce_shortcode_steps", {
          text: "Etape",
          title: "",
          icon: "mce-ico mce-i-numlist",
          onclick: function () {
            editor.windowManager.open({
              title: "Insérer une étape",
              body: [
                {
                  type: "textbox",
                  name: "wptexl_StepNumber",
                  label: "Numéro",
                  minWidth: 600,
                },
                {
                  type: "textbox",
                  name: "wptexl_StepTitle",
                  label: "Titre",
                  minWidth: 600,
                },
                {
                  type: "textbox",
                  name: "wptexl_StepText",
                  label: "Texte",
                  minWidth: 600,
                  multiline: true,
                },
              ],
              onsubmit: function (e) {
                editor.insertContent(
                  '[step number="' +
                    e.data.wptexl_StepNumber +
                    '" title="' +
                    e.data.wptexl_StepTitle +
                    '" text="' +
                    e.data.wptexl_StepText +
                    '"]'
                );
              },
            });
          },
        });
      }
    );

    // =========================================
    // PLUGIN : Titre avec icône
    // =========================================
    tinymce.PluginManager.add(
      "add_mce_shortcode_title_icon",
      function (editor, url) {
        editor.addButton("add_mce_shortcode_title_icon", {
          text: "Icône & Titre",
          title: "",
          icon: "mce-ico mce-i-emoticons",
          onclick: function () {
            var wptExtLinkGetSelection = tinyMCE.activeEditor.selection;
            var wptExtLinkSelectedText = wptExtLinkGetSelection.getContent({
              format: "text",
            });

            editor.windowManager.open({
              title: "Insérer un titre avec icône",
              body: [
                {
                  type: "listbox",
                  name: "wptexl_Icon",
                  label: "Icône",
                  disabled: false,
                  values:
                    typeof php_vars !== "undefined" && php_vars.icons
                      ? php_vars.icons
                      : [],
                },
                {
                  type: "textbox",
                  name: "wptexl_LinkText",
                  label: "Texte",
                  value: wptExtLinkSelectedText,
                  minWidth: 600,
                },
              ],
              onsubmit: function (e) {
                editor.insertContent(
                  '[title_icon icon="' +
                    e.data.wptexl_Icon +
                    '" text="' +
                    e.data.wptexl_LinkText +
                    '"]'
                );
              },
            });
          },
        });
      }
    );

    console.log("✅ Churchill TinyMCE Plugins - Tous les plugins chargés");
  }

  // =========================================
  // STRATÉGIE DE CHARGEMENT
  // =========================================

  // Vérifier immédiatement si TinyMCE est prêt
  if (isTinyMCEReady()) {
    initTinyMCEPlugins();
  } else {
    // Attendre l'événement WordPress
    if (typeof jQuery !== "undefined") {
      jQuery(document).on("tinymce-editor-init", function (event, editor) {
        if (!window.churchillTinyMCELoaded) {
          window.churchillTinyMCELoaded = true;
          initTinyMCEPlugins();
        }
      });
    }

    // Fallback: Polling si jQuery n'est pas disponible
    var attempts = 0;
    var maxAttempts = 30; // 15 secondes max

    var checkInterval = setInterval(function () {
      attempts++;

      if (isTinyMCEReady()) {
        clearInterval(checkInterval);
        if (!window.churchillTinyMCELoaded) {
          window.churchillTinyMCELoaded = true;
          initTinyMCEPlugins();
        }
      } else if (attempts >= maxAttempts) {
        clearInterval(checkInterval);
        console.error(
          "❌ TinyMCE non chargé après " + maxAttempts + " tentatives"
        );
      }
    }, 500);
  }
})();
