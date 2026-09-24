<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Mes livraisons - Livreur</title>

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
            font-size: 18px;
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
            font-size: 25px;
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
            margin-top: 0;
            margin-bottom: 10px;
        }

        .status {
            display: inline-block;
            padding: 7px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: bold;
        }

        .status-preparation {
            background: #fff3cd;
            color: #856404;
        }

        .status-cours {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .status-livree {
            background: #dcfce7;
            color: #166534;
        }

        /* =========================
           BOUTON
        ========================= */

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

        .validate:disabled {
            background: #999;
            cursor: not-allowed;
        }

        .success-message {
            background: #dcfce7;
            color: #166534;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: none;
        }

        .error-message {
            background: #fee2e2;
            color: #991b1b;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: none;
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

            <li>
                <a href="{{ route('livreur') }}">
                    🏠 Tableau de bord
                </a>
            </li>

            <li class="active">
                <a href="{{ route('livreur.livraisons') }}">
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
         CONTENU
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


        <!-- Messages -->

        <div id="successMessage" class="success-message"></div>

        <div id="errorMessage" class="error-message"></div>


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


            <!-- =========================
                 DETAILS
            ========================= -->

            <div class="details">

                <h2>
                    Détail de la livraison
                </h2>

                <div id="detailsLivraison">

                    <p>
                        Sélectionnez une livraison.
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


<script>

function afficherMessage(type, message) {

    const success = document.getElementById("successMessage");
    const error = document.getElementById("errorMessage");

    success.style.display = "none";
    error.style.display = "none";

    if (type === "success") {

        success.textContent = message;
        success.style.display = "block";

    } else {

        error.textContent = message;
        error.style.display = "block";

    }

}


/*
|--------------------------------------------------------------------------
| Charger les livraisons du livreur connecté
|--------------------------------------------------------------------------
*/

function chargerMesLivraisons() {

    fetch("/api/livreur/{{ auth()->id() }}/livraisons")

        .then(response => {

            if (!response.ok) {
                throw new Error("Erreur API");
            }

            return response.json();

        })

        .then(livraisons => {

            const container =
                document.getElementById("mesLivraisons");


            /*
            |--------------------------------------------------------------------------
            | Statistiques
            |--------------------------------------------------------------------------
            */

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


            container.innerHTML = "";


            /*
            |--------------------------------------------------------------------------
            | Aucune livraison
            |--------------------------------------------------------------------------
            */

            if (livraisons.length === 0) {

                container.innerHTML = `
                    <p>
                        Aucune livraison ne vous a été affectée.
                    </p>
                `;

                return;
            }


            /*
            |--------------------------------------------------------------------------
            | Affichage
            |--------------------------------------------------------------------------
            */

            livraisons.forEach(livraison => {

                let classeStatut = "";

                if (livraison.statut === "En préparation") {
                    classeStatut = "status-preparation";
                }

                if (livraison.statut === "En cours") {
                    classeStatut = "status-cours";
                }

                if (livraison.statut === "Livrée") {
                    classeStatut = "status-livree";
                }


                container.innerHTML += `

                    <div
                        class="delivery"
                        onclick="afficherDetails(${livraison.id})"
                    >

                        <h3>
                            Livraison n°${livraison.id}
                        </h3>

                        <p>

                            <strong>
                                Commande :
                            </strong>

                            ${
                                livraison.commande
                                    ? livraison.commande.id
                                    : livraison.commande_id
                            }

                        </p>

                        <p>

                            <strong>
                                Adresse :
                            </strong>

                            ${livraison.adresse}

                        </p>

                        <p>

                            <strong>
                                Date :
                            </strong>

                            ${livraison.date_livraison ?? ""}

                        </p>

                        <p>

                            <strong>
                                Statut :
                            </strong>

                            <span class="status ${classeStatut}">
                                ${livraison.statut}
                            </span>

                        </p>

                    </div>

                `;

            });

        })

        .catch(error => {

            console.error(error);

            document.getElementById(
                "mesLivraisons"
            ).innerHTML = `

                <p>
                    Erreur lors du chargement des livraisons.
                </p>

            `;

        });

}


/*
|--------------------------------------------------------------------------
| Afficher les détails
|--------------------------------------------------------------------------
*/

function afficherDetails(id) {

    fetch(`/api/livraisons/${id}`)

        .then(response => {

            if (!response.ok) {
                throw new Error("Erreur API");
            }

            return response.json();

        })

        .then(livraison => {

            const details =
                document.getElementById("detailsLivraison");


            let bouton = "";


            /*
            |--------------------------------------------------------------------------
            | Bouton uniquement si la livraison n'est pas encore livrée
            |--------------------------------------------------------------------------
            */

            if (livraison.statut !== "Livrée") {

                bouton = `

                    <button
                        class="validate"
                        onclick="event.stopPropagation(); marquerCommeLivree(${livraison.id})"
                    >
                        ✓ Marquer comme livrée
                    </button>

                `;

            }


            details.innerHTML = `

                <h3>
                    Livraison n°${livraison.id}
                </h3>

                <p>

                    <strong>
                        Commande :
                    </strong>

                    ${
                        livraison.commande
                            ? livraison.commande.id
                            : livraison.commande_id
                    }

                </p>

                <p>

                    <strong>
                        Adresse :
                    </strong>

                    ${livraison.adresse}

                </p>

                <p>

                    <strong>
                        Date :
                    </strong>

                    ${livraison.date_livraison ?? ""}

                </p>

                <p>

                    <strong>
                        Statut :
                    </strong>

                    ${livraison.statut}

                </p>

                ${bouton}

            `;

        })

        .catch(error => {

            console.error(error);

            document.getElementById(
                "detailsLivraison"
            ).innerHTML = `

                <p>
                    Impossible de charger les détails.
                </p>

            `;

        });

}


/*
|--------------------------------------------------------------------------
| Marquer comme livrée
|--------------------------------------------------------------------------
*/

async function marquerCommeLivree(id) {

    if (
        !confirm(
            "Voulez-vous vraiment marquer cette livraison comme livrée ?"
        )
    ) {
        return;
    }


    try {

        const response = await fetch(
            `/api/livraisons/${id}/livree`,
            {
                method: "PUT",

                headers: {
                    "Accept": "application/json",
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                }
            }
        );


        const data = await response.json();


        if (!response.ok) {

            throw new Error(
                data.message || "Erreur lors de la modification."
            );

        }


        afficherMessage(
            "success",
            "La livraison a été marquée comme livrée."
        );


        /*
        |--------------------------------------------------------------------------
        | Actualiser la liste
        |--------------------------------------------------------------------------
        */

        chargerMesLivraisons();


        /*
        |--------------------------------------------------------------------------
        | Actualiser les détails
        |--------------------------------------------------------------------------
        */

        afficherDetails(id);

    }

    catch (error) {

        console.error(error);

        afficherMessage(
            "error",
            error.message || "Une erreur est survenue."
        );

    }

}


/*
|--------------------------------------------------------------------------
| Chargement initial
|--------------------------------------------------------------------------
*/

chargerMesLivraisons();

</script>

@include('partials.accessibility')

</body>
</html>