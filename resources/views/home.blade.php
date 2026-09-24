<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Carrefour | Gestion des livraisons</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

</head>


<body>


    <!-- =========================
         HEADER
    ========================= -->

    <header class="home-header">

        <a href="{{ route('home') }}" class="home-logo">

            <div class="home-logo-box">
                C
            </div>

            <div class="home-logo-text">
                Carrefour
            </div>

        </a>


        <nav class="home-nav">

            <a href="#accueil">
                Accueil
            </a>

            <a href="#services">
                Fonctionnalités
            </a>

            <a href="#contact">
                À propos
            </a>

            <a
                href="{{ route('login') }}"
                class="home-login-button"
            >
                Se connecter
            </a>

        </nav>

    </header>


    <!-- =========================
         CONTENU PRINCIPAL
    ========================= -->

    <main id="accueil">


        <!-- HERO -->

        <section class="hero">

            <div class="hero-content">

                <div class="badge">
                    Plateforme interne Carrefour
                </div>


                <h1>
                    La gestion des livraisons,
                    <span>simplifiée.</span>
                </h1>


                <p>
                    Une plateforme pour organiser,
                    suivre et gérer efficacement les livraisons
                    Carrefour et l'activité des livreurs.
                </p>


                <div class="hero-buttons">

                    <a
                        href="{{ route('login') }}"
                        class="primary-button"
                    >
                        Accéder à mon espace →
                    </a>


                    <a
                        href="#services"
                        class="secondary-button"
                    >
                        Découvrir la plateforme
                    </a>

                </div>

            </div>


            <!-- CARTE DE DÉMONSTRATION -->

            <div class="hero-card">

                <div class="card-title">
                    Activité des livraisons
                </div>


                <div class="card-main">

                    <strong>
                        Aujourd'hui
                    </strong>

                    <span class="status">
                        En activité
                    </span>

                </div>


                <div class="progress-container">


            


                <div class="delivery-item">

                    <div class="delivery-icon">
                        📦
                    </div>

                    <div class="delivery-text">

                        <strong>
                            Commandes
                        </strong>

                        <span>
                            Gestion des commandes
                        </span>

                    </div>

                </div>


                <div class="delivery-item">

                    <div class="delivery-icon">
                        🚚
                    </div>

                    <div class="delivery-text">

                        <strong>
                            Livreurs
                        </strong>

                        <span>
                            Gestion des livreurs
                        </span>

                    </div>

                </div>


                <div class="delivery-item">

                    <div class="delivery-icon">
                        📊
                    </div>

                    <div class="delivery-text">

                        <strong>
                            Suivi
                        </strong>

                        <span>
                            Suivi de l'activité
                        </span>

                    </div>

                </div>

            </div>

        </section>


        <!-- =========================
             STATISTIQUES
        ========================= -->

        <div class="stats">

            <div class="stat">

                <div class="stat-icon">
                    🕐
                </div>

                <strong>
                    24/7
                </strong>

                <span>
                    Accès à la plateforme
                </span>

            </div>


            <div class="stat">

                <div class="stat-icon">
                    📈
                </div>

                <strong>
                    100%
                </strong>

                <span>
                    Suivi numérique
                </span>

            </div>


            <div class="stat">

                <div class="stat-icon">
                    👥
                </div>

                <strong>
                    1
                </strong>

                <span>
                    Plateforme pour toute l'équipe
                </span>

            </div>

        </div>


        <!-- =========================
             FONCTIONNALITÉS
        ========================= -->

        <section
            class="services"
            id="services"
        >

            <div class="section-header">

                <div class="section-label">
                    Fonctionnalités
                </div>


                <h2>
                    Tout ce qu'il faut pour gérer les livraisons
                </h2>


                <p>
                    Une solution conçue pour simplifier le travail
                    quotidien des administrateurs et des livreurs.
                </p>

            </div>


            <div class="cards">


                <div class="service-card">

                    <div class="service-icon">
                        📦
                    </div>


                    <h3>
                        Gestion des commandes
                    </h3>


                    <p>
                        Consultez les commandes et gérez leur
                        association avec les différentes livraisons.
                    </p>

                </div>


                <div class="service-card">

                    <div class="service-icon">
                        🚚
                    </div>


                    <h3>
                        Gestion des livreurs
                    </h3>


                    <p>
                        L'administrateur peut créer, modifier et
                        gérer les comptes des livreurs.
                    </p>

                </div>


                <div class="service-card">

                    <div class="service-icon">
                        📊
                    </div>


                    <h3>
                        Suivi de l'activité
                    </h3>


                    <p>
                        Retrouvez facilement les informations
                        importantes au même endroit.
                    </p>

                </div>

            </div>

        </section>


        <!-- =========================
             CTA
        ========================= -->

        <section
            class="cta"
            id="contact"
        >

            <div>

                <h2>
                    Prêt à accéder à votre espace ?
                </h2>


                <p>
                    Connectez-vous à la plateforme pour accéder
                    aux fonctionnalités correspondant à votre rôle.
                </p>

            </div>


            <a
                href="{{ route('login') }}"
                class="primary-button"
            >
                Se connecter →
            </a>

        </section>


        <!-- =========================
             ACCESSIBILITÉ
        ========================= -->

        <section
            class="table accessibility-section"
            id="accessibilite"
        >

            <h2>♿ Accessibilité</h2>

            <p class="accessibility-description">
                Personnalisez l'affichage de l'application selon vos besoins,
                avant même de vous connecter. Vos préférences seront
                mémorisées sur cet appareil.
            </p>


            <!-- CONTRASTE -->

            <div class="accessibility-option">

                <div>

                    <strong>
                        Mode contraste élevé
                    </strong>

                    <p>
                        Augmenter le contraste pour faciliter la lecture de l'application.
                    </p>

                </div>

                <button
                    type="button"
                    id="contrastButton"
                    onclick="toggleContrast()"
                >
                    Activer
                </button>

            </div>


            <!-- TAILLE TEXTE -->

            <div class="accessibility-option">

                <div>

                    <strong>
                        🔠 Taille du texte
                    </strong>

                    <p>
                        Modifiez la taille du texte pour améliorer la lisibilité de l'application.
                    </p>

                </div>


                <div class="text-size-buttons">

                    <button
                        type="button"
                        onclick="setTextSize('small')"
                        id="textSmall"
                    >
                        A−
                    </button>

                    <button
                        type="button"
                        onclick="setTextSize('normal')"
                        id="textNormal"
                    >
                        A
                    </button>

                    <button
                        type="button"
                        onclick="setTextSize('large')"
                        id="textLarge"
                    >
                        A+
                    </button>

                </div>

            </div>

        </section>

    </main>


    <!-- =========================
         FOOTER
    ========================= -->

    <footer>

        <div class="footer-content">

            <div class="footer-logo">
                Carrefour
            </div>


            <div class="footer-text">
                Plateforme de gestion des livraisons
            </div>


            <div class="footer-text">
                © {{ date('Y') }} Carrefour
            </div>

        </div>


        <div class="footer-links">

            <a href="{{ route('rgpd') }}">
                Politique de confidentialité
            </a>


            <span class="footer-separator">
                |
            </span>


            <a href="{{ route('mentions.legales') }}">
                Mentions légales
            </a>

        </div>

    </footer>


    <!-- =========================
         BANDEAU COOKIES
    ========================= -->

    <div id="cookie-banner">

        <h3>
            🍪 Gestion des cookies
        </h3>


        <p>
            Ce site utilise des cookies nécessaires à son fonctionnement.
            Vous pouvez accepter ou refuser les cookies non essentiels.
        </p>


        <button
            id="accept-cookies"
            class="cookie-button"
            type="button"
        >
            Accepter
        </button>


        <button
            id="refuse-cookies"
            class="cookie-button"
            type="button"
        >
            Refuser
        </button>

    </div>


    <style>

    /* =========================================================
       ACCESSIBILITE — mise en forme propre à la page d'accueil
    ========================================================= */

    .accessibility-section {
        margin: 40px auto 0;
        max-width: 900px;
        background: white;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 2px 8px rgba(0,0,0,.08);
    }

    .accessibility-description {
        margin-top: 10px;
        margin-bottom: 20px;
        color: #555;
    }

    .accessibility-option {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        padding: 15px;
        margin-top: 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background: #f8f9fa;
    }

    .accessibility-option p {
        margin-top: 6px;
        color: #666;
    }

    #contrastButton {
        min-width: 120px;
        padding: 12px 18px;
        border: 0;
        border-radius: 7px;
        background: #0d1b4c;
        color: white;
        font-size: 16px;
        cursor: pointer;
    }

    #contrastButton:hover {
        background: #3859d6;
    }

    .text-size-buttons {
        display: flex;
        gap: 8px;
    }

    .text-size-buttons button {
        min-width: 50px;
        min-height: 44px;
        font-size: 18px;
        font-weight: bold;
        border: 0;
        border-radius: 7px;
        background: #0d1b4c;
        color: white;
        cursor: pointer;
    }

    .text-size-buttons button:hover {
        background: #3859d6;
    }


    /* =========================================================
       CONTRASTE ELEVE — éléments propres à la page d'accueil
       (le reste des règles génériques vient du partial accessibilité)
    ========================================================= */

    body.contrast-mode .accessibility-section {
        background: #111 !important;
        color: #fff !important;
        border: 2px solid #fff;
    }

    body.contrast-mode header,
    body.contrast-mode footer {
        background: #000 !important;
        color: #fff !important;
        border-color: #fff !important;
    }

    </style>




    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const cookieBanner =
                document.getElementById('cookie-banner');

            const acceptCookies =
                document.getElementById('accept-cookies');

            const refuseCookies =
                document.getElementById('refuse-cookies');


            const cookieChoice =
                localStorage.getItem('carrefour_cookie_consent_v1');


            if (cookieChoice) {

                cookieBanner.style.display = 'none';

            }


            acceptCookies.addEventListener('click', function () {

                localStorage.setItem(
                    'carrefour_cookie_consent_v1',
                    'accepted'
                );

                cookieBanner.style.display = 'none';

            });


            refuseCookies.addEventListener('click', function () {

                localStorage.setItem(
                    'carrefour_cookie_consent_v1',
                    'refused'
                );

                cookieBanner.style.display = 'none';

            });

        });

    </script>

 @include('partials.accessibility')

</body>

</html>