<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tableau de bord - Livreur</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            color: #111;
        }

        .layout {
            display: flex;
            min-height: 100vh;
        }

        /* =========================
           SIDEBAR
        ========================= */

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            width: 315px;
            background: #0d1b4c;
            color: white;
            padding: 25px 16px;
        }

        .logo {
            text-align: center;
            margin-bottom: 45px;
        }

        .logo img {
            width: 205px;
            max-width: 100%;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar li {
            padding: 20px 15px;
            margin-bottom: 8px;
            font-size: 20px;
            border-radius: 8px;
            cursor: pointer;
        }

        .sidebar li:hover,
        .sidebar li.active {
            background: #3859d6;
        }

        .sidebar li a {
            display: block;
            width: 100%;
            color: white;
            text-decoration: none;
        }

        .logout-form {
            margin-top: 35px;
        }

        .logout-form button {
            width: 100%;
            padding: 15px;
            border: 0;
            border-radius: 8px;
            background: #3859d6;
            color: white;
            font-size: 18px;
            cursor: pointer;
        }

        .logout-form button:hover {
            background: #2f4ec8;
        }

        /* =========================
           MAIN
        ========================= */

        .main {
            margin-left: 315px;
            width: calc(100% - 315px);
            padding: 40px;
        }

        header {
            margin-bottom: 30px;
        }

        header p {
            margin: 0;
            font-size: 20px;
        }

        header h1 {
            margin: 5px 0;
            font-size: 40px;
        }

        header span {
            font-size: 20px;
        }

        /* =========================
           CARTES
        ========================= */

        .cards {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            flex: 1;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .card h2 {
            font-size: 32px;
            margin: 10px 0 0;
        }

        .card.orange {
            border-left: 6px solid orange;
        }

        .card.green {
            border-left: 6px solid #22c55e;
        }

        /* =========================
           CONTENU
        ========================= */

        .content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
        }

        .livraisons,
        .details {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .livraisons h2,
        .details h2 {
            margin-top: 0;
        }

        /* =========================
           LIVRAISON
        ========================= */

        .delivery {
            border: 1px solid #ddd;
            padding: 18px;
            border-radius: 10px;
            margin-bottom: 15px;
            cursor: pointer;
        }

        .delivery:hover {
            border-color: #3b5bdb;
            background: #f7f9ff;
        }

        .delivery h3 {
            margin-bottom: 10px;
        }

        .validate {
            margin-top: 15px;
            width: 100%;
            padding: 14px;
            background: #3b5bdb;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
        }

        .validate:hover {
            background: #2f4ec8;
        }

        footer {
            text-align: center;
            border-top: 1px solid #ccc;
            padding: 25px 0;
            margin-top: 40px;
        }

        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 900px) {

            .sidebar {
                width: 220px;
            }

            .main {
                margin-left: 220px;
                width: calc(100% - 220px);
            }

            .content {
                grid-template-columns: 1fr;
            }

            .cards {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>

<div class="layout">

    <!-- =========================
         MENU
    ========================= -->

    <aside class="sidebar">

        <div class="logo">
            <img
                src="{{ asset('images/OIP (3).webp') }}"
                alt="Logo Carrefour"
            >
        </div>

        <ul>

    <li class="active">
        <a href="{{ route('livreur') }}">
            🏠 Tableau de bord
        </a>
    </li>

    <li>
        <a href="{{ route('livreur') }}">
            📦 Mes livraisons
        </a>
    </li>

    <li>
        <a href="{{ route('livreur.messages.create') }}">
            💬 Contact admin
        </a>
    </li>

    <li>
        <a href="{{ route('livreur.profil') }}">
            👤 Profil
        </a>
    </li>

</ul>

        <form
            method="POST"
            action="{{ route('logout') }}"
            class="logout-form"
        >
            @csrf

            <button type="submit">
                Déconnexion
            </button>
        </form>

    </aside>


    <!-- =========================
         TABLEAU DE BORD
    ========================= -->

    <main class="main">

        <header>

            <p>Bonjour,</p>

            <h1>
                {{ auth()->user()->name }}
            </h1>

            <span>
                Voici vos livraisons
            </span>

        </header>


        <!-- =========================
             STATISTIQUES
        ========================= -->

        <section class="cards">

            <div class="card">

                Toutes

                <h2 id="totalLivraisons">
                    0
                </h2>

            </div>


            <div class="card orange">

                En cours

                <h2 id="livraisonsEnCours">
                    0
                </h2>

            </div>


            <div class="card green">

                Livrées

                <h2 id="livraisonsLivrees">
                    0
                </h2>

            </div>

        </section>


        <!-- =========================
             LIVRAISONS
        ========================= -->

        <section class="content">

            <div class="livraisons">

                <h2>
                    Mes livraisons
                </h2>

                <div id="mesLivraisons">

                    <p>
                        Chargement de vos livraisons...
                    </p>

                </div>

            </div>


            <div class="details">

                <h2>
                    Détail de la livraison
                </h2>

                <div id="detailsLivraison">

                    <p>
                        Sélectionne une livraison.
                    </p>

                </div>

            </div>

        </section>


        <footer>
            © {{ date('Y') }} Carrefour -
            Application de gestion des livraisons
        </footer>

    </main>

</div>

</body>
</html>