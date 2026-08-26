<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Carrefour | Gestion des livraisons</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

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

                    <div class="progress-info">

                        <span>
                            Livraisons traitées
                        </span>

                        <span>
                            76%
                        </span>

                    </div>


                    <div class="progress">

                        <div class="progress-bar"></div>

                    </div>

                </div>


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


</body>

</html>