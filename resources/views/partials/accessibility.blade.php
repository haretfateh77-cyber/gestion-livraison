{{--
    Partial accessibilité : à inclure sur CHAQUE page de l'application
    (une seule fois, juste avant </body>) avec :

        @include('partials.accessibility')

    Ce partial NE contient PAS les boutons de réglage (ils ne vivent que
    sur la page d'accueil) — seulement le CSS qui définit l'apparence du
    mode contraste élevé / de la taille du texte, et le script qui lit
    les préférences enregistrées (localStorage) et les applique au
    chargement de la page.
--}}

<style>

/* =========================================================
   CONTRASTE ELEVE — styles génériques pour les pages internes
   (sidebar / main / table), communs à l'espace admin et livreur.
========================================================= */

body.contrast-mode {
    background: #000 !important;
    color: #fff !important;
}

body.contrast-mode .main {
    background: #000 !important;
    color: #fff !important;
}

body.contrast-mode .table {
    background: #111 !important;
    color: #fff !important;
    border: 2px solid #fff;
}

body.contrast-mode h1,
body.contrast-mode h2,
body.contrast-mode h3,
body.contrast-mode strong,
body.contrast-mode p,
body.contrast-mode span,
body.contrast-mode label,
body.contrast-mode li,
body.contrast-mode td,
body.contrast-mode th {
    color: #fff !important;
}

body.contrast-mode input,
body.contrast-mode select,
body.contrast-mode textarea {
    background: #000 !important;
    color: #fff !important;
    border: 2px solid #fff !important;
}

body.contrast-mode input::placeholder {
    color: #ddd !important;
}

body.contrast-mode button {
    background: #fff !important;
    color: #000 !important;
    border: 2px solid #fff !important;
}

body.contrast-mode .accessibility-option,
body.contrast-mode .password-rules,
body.contrast-mode .validation-success,
body.contrast-mode .validation-errors,
body.contrast-mode .two-factor-active,
body.contrast-mode .two-factor-disabled,
body.contrast-mode .stat-card,
body.contrast-mode .card,
body.contrast-mode .panel {
    background: #000 !important;
    color: #fff !important;
    border: 2px solid #fff !important;
}

body.contrast-mode .sidebar {
    background: #000 !important;
    color: #fff !important;
    border-right: 2px solid #fff;
}

body.contrast-mode .sidebar li,
body.contrast-mode .sidebar li a {
    color: #fff !important;
}

body.contrast-mode footer {
    color: #fff !important;
    border-top: 2px solid #fff !important;
}

body.contrast-mode table {
    border: 2px solid #fff !important;
}

body.contrast-mode table th,
body.contrast-mode table td {
    border-color: #fff !important;
}


/* =========================================================
   TAILLE DU TEXTE
========================================================= */

body.text-size-small {
    font-size: 14px;
}

body.text-size-normal {
    font-size: 16px;
}

body.text-size-large {
    font-size: 19px;
}

body.text-size-small h1,
body.text-size-normal h1,
body.text-size-large h1 {
    font-size: 2em;
}

body.text-size-small h2,
body.text-size-normal h2,
body.text-size-large h2 {
    font-size: 1.5em;
}

body.text-size-small input,
body.text-size-small button,
body.text-size-small select,
body.text-size-large input,
body.text-size-large button,
body.text-size-large select {
    font-size: 1em;
}

</style>


<script>

/* =========================================================
   ACCESSIBILITE — application des préférences enregistrées
   (les boutons de réglage se trouvent sur la page d'accueil ;
   ce script se contente d'appliquer ce qui est déjà choisi).
========================================================= */

function applyContrastMode() {
    const enabled =
        localStorage.getItem("contrastMode") === "enabled";

    document.body.classList.toggle("contrast-mode", enabled);

    if (typeof updateContrastButton === "function") {
        updateContrastButton();
    }
}

function toggleContrast() {
    const enabled =
        !document.body.classList.contains("contrast-mode");

    localStorage.setItem(
        "contrastMode",
        enabled ? "enabled" : "disabled"
    );

    applyContrastMode();
}

function updateContrastButton() {
    const button = document.getElementById("contrastButton");

    if (button) {
        button.textContent =
            document.body.classList.contains("contrast-mode")
                ? "✓ Activé"
                : "Activer";
    }
}

function setTextSize(size) {
    document.body.classList.remove(
        "text-size-small",
        "text-size-normal",
        "text-size-large"
    );

    document.body.classList.add("text-size-" + size);

    localStorage.setItem("textSize", size);

    if (typeof updateTextSizeButtons === "function") {
        updateTextSizeButtons();
    }
}

function updateTextSizeButtons() {
    const size = localStorage.getItem("textSize") || "normal";

    const buttons = {
        small: document.getElementById("textSmall"),
        normal: document.getElementById("textNormal"),
        large: document.getElementById("textLarge")
    };

    Object.values(buttons).forEach(button => {
        if (button) {
            button.style.outline = "none";
        }
    });

    if (buttons[size]) {
        buttons[size].style.outline = "3px solid #ffcc00";
    }
}

document.addEventListener("DOMContentLoaded", function () {
    applyContrastMode();
    setTextSize(localStorage.getItem("textSize") || "normal");
});

</script>