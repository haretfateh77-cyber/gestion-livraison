<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tableau de bord - Livreur</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

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
           RACCOURCI
        ========================= */

        .shortcut {

            background: white;

            padding: 25px;

            border-radius: 12px;

            box-shadow: 0 2px 8px rgba(0,0,0,0.08);

            text-align: center;

        }

        .shortcut a {

            display: inline-block;

            margin-top: 12px;

            padding: 14px 28px;

            background: #3b5bdb;

            color: white;

            text-decoration: none;

            border-radius: 8px;

            font-size: 16px;

        }

        .shortcut a:hover {

            background: #2f4ec8;

        }

        /* =========================
           FOOTER
        ========================= */

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

            .cards {

                flex-direction: column;

            }

        }

    </style>

</head>


<body>


<div class="layout">


    <!-- =========================
         SIDEBAR
    ========================= -->

    <aside class="sidebar">


        <div class="logo">

            <img
                src="{{ asset('images/OIP (3).webp') }}"
                alt="Logo Carrefour"
            >

        </div>


        <ul>


            <!-- ACCUEIL -->


<li class="active">
    <a href="{{ route('livreur') }}">
        🏠 Tableau de bord
    </a>
</li>

<li>
    <a href="{{ route('livreur.livraisons') }}">
        📦 Mes livraisons
    </a>
</li>


            <!-- CONTACT ADMIN -->

            <li>

                <a href="{{ route('livreur.messages.create') }}">

                    💬 Contact admin

                </a>

            </li>


            <!-- PROFIL -->

            <li>

                <a href="{{ route('livreur.profil') }}">

                    👤 Profil

                </a>

            </li>


        </ul>


        <!-- DECONNEXION -->

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
         CONTENU PRINCIPAL
    ========================= -->

    <main class="main">


        <header>

            <p>Bonjour,</p>

            <h1>

                {{ auth()->user()->name }}

            </h1>

            <span>

                Voici un aperçu de votre activité

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
             RACCOURCI VERS LA LISTE
        ========================= -->

        <section class="shortcut">

            <p>Consultez le détail de vos livraisons et mettez à jour leur statut.</p>

            <a href="{{ route('livreur.livraisons') }}">
                Voir mes livraisons
            </a>

        </section>



        <footer>

            © {{ date('Y') }} Carrefour -

            Application de gestion des livraisons

        </footer>


    </main>


</div>



<script>

function getCookie(name) {
    const match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
    return match ? decodeURIComponent(match[2]) : null;
}


/*
|--------------------------------------------------------------------------
| Charger uniquement les statistiques du livreur connecté
|--------------------------------------------------------------------------
*/

function chargerStatistiques() {


    fetch("/api/livreur/{{ auth()->id() }}/livraisons", {
        credentials: "include",
        headers: {
            "X-XSRF-TOKEN": getCookie("XSRF-TOKEN")
        }
    })


        .then(response => {


            if (!response.ok) {

                throw new Error("Erreur API");

            }


            return response.json();


        })


        .then(livraisons => {


            const total = livraisons.length;


            const enCours = livraisons.filter(

                livraison =>

                    livraison.statut === "En cours" ||

                    livraison.statut === "En préparation"

            ).length;


            const livrees = livraisons.filter(

                livraison =>

                    livraison.statut === "Livrée"

            ).length;


            document.getElementById(
                "totalLivraisons"
            ).textContent = total;


            document.getElementById(
                "livraisonsEnCours"
            ).textContent = enCours;


            document.getElementById(
                "livraisonsLivrees"
            ).textContent = livrees;


        })


        .catch(error => {


            console.error(error);


        });


}



/*
|--------------------------------------------------------------------------
| Chargement initial
|--------------------------------------------------------------------------
*/

chargerStatistiques();


</script>

@include('partials.accessibility')

</body>

</html>