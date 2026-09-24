<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Gestion des commandes</title>

<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="icon" type="image/webp" href="{{ asset('images/OIP (3).webp') }}">

<style>
    .import-box {
        margin-top: 25px;
        padding: 25px;
        background: #f8f9fc;
        border: 1px solid #ddd;
        border-radius: 10px;
    }

    .import-box h2 {
        margin-top: 0;
    }

    .import-box p {
        color: #666;
        margin-bottom: 18px;
    }

    .import-form {
        display: flex;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
    }

    .import-form input[type="file"] {
        padding: 10px;
        background: white;
        border: 1px solid #ccc;
        border-radius: 8px;
    }

    .import-button {
        padding: 12px 20px;
        background: #0d1b4c;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: bold;
    }

    .import-button:hover {
        background: #162c75;
    }

    .success-message {
        margin-top: 15px;
        padding: 12px 16px;
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
        border-radius: 8px;
    }

    .error-message {
        margin-top: 15px;
        padding: 12px 16px;
        background: #f8d7da;
        color: #842029;
        border: 1px solid #f5c2c7;
        border-radius: 8px;
    }
</style>

</head>

<body>

<div class="layout">

    <!-- =========================
         SIDEBAR
    ========================= -->

    <div class="sidebar">

        <div class="logo">
            <img
                src="{{ asset('images/OIP (3).webp') }}"
                alt="Logo Carrefour"
            >
        </div>

        <ul>

            <li onclick="window.location.href='{{ route('admin.dashboard') }}'">
                🏠 Tableau de bord
            </li>

            <li style="font-weight:bold;">
                📦 Commandes
            </li>

            <li onclick="window.location.href='{{ route('admin.livraisons') }}'">
                🚚 Livraisons
            </li>

            <li onclick="window.location.href='{{ route('admin.utilisateurs') }}'">
                👥 Utilisateurs
            </li>

            <li onclick="window.location.href='{{ route('admin.profil') }}'">
                👤 Profil
            </li>

            <li onclick="window.location.href='{{ route('admin.messages.index') }}'">
                💬 Messages
            </li>

        </ul>

        <form method="POST" action="{{ route('logout') }}">

            @csrf

            <button type="submit">
                Déconnexion
            </button>

        </form>

    </div>


    <!-- =========================
         CONTENU PRINCIPAL
    ========================= -->

    <div class="main">

        <h1>Gestion des commandes</h1>


        <!-- =========================
             MESSAGE SUCCÈS
        ========================= -->

        @if(session('success'))

            <div class="success-message">
                {{ session('success') }}
            </div>

        @endif


        <!-- =========================
             ERREURS
        ========================= -->

        @if($errors->any())

            <div class="error-message">

                @foreach($errors->all() as $error)

                    <div>
                        {{ $error }}
                    </div>

                @endforeach

            </div>

        @endif


        <!-- =========================
             CRÉER UNE COMMANDE
        ========================= -->

        <section class="table">

            <h2>Créer une commande</h2>

            <form id="commandeForm">

                <input
                    type="number"
                    id="montant"
                    placeholder="Montant"
                    step="0.01"
                    min="0"
                    required
                >

                <select id="statut">

                    <option value="En préparation">
                        En préparation
                    </option>

                    <option value="En cours">
                        En cours
                    </option>

                    <option value="Livrée">
                        Livrée
                    </option>

                    <option value="en_attente">
                        En attente
                    </option>

                </select>

                <button type="submit">
                    Créer la commande
                </button>

            </form>

        </section>


        <!-- =========================
             IMPORTER DES COMMANDES
        ========================= -->

        <section class="table import-box">

            <h2>Importer des commandes</h2>

            <p>
                Sélectionnez un fichier CSV contenant vos commandes préparées.
                Les commandes déjà présentes dans la base seront automatiquement ignorées.
            </p>

            <form
                method="POST"
                action="{{ route('admin.commandes.import') }}"
                enctype="multipart/form-data"
                class="import-form"
            >

                @csrf

                <input
                    type="file"
                    name="fichier"
                    accept=".xlsx,.xls,.csv"
                    required
                >

                <button
                    type="submit"
                    class="import-button"
                >
                    📥 Importer les commandes
                </button>

            </form>

            <p style="margin-top:15px;font-size:13px;">
                Format attendu :
                <strong>
                      date_commande, montant, statut
                </strong>
            </p>

        </section>


        <!-- =========================
             LISTE DES COMMANDES
        ========================= -->

        <section class="table">

            <h2>Commandes créées</h2>

            <table>

                <thead>

                    <tr>

                        <th>ID</th>
                        <th>Date</th>
                        <th>Montant</th>
                        <th>Statut</th>
                        <th>Actions</th>

                    </tr>

                </thead>

                <tbody id="listeCommandes"></tbody>

            </table>

        </section>


        <!-- =========================
             FOOTER
        ========================= -->

        <footer>

            © {{ date('Y') }} Carrefour -
            Application de gestion des livraisons

        </footer>

    </div>

</div>


<script>

/*
|--------------------------------------------------------------------------
| Jeton CSRF (utilisé par toutes les requêtes fetch de cette page)
|--------------------------------------------------------------------------
*/

const csrfToken =
    document.querySelector('meta[name="csrf-token"]').content;


/*
|--------------------------------------------------------------------------
| Déconnexion
|--------------------------------------------------------------------------
*/

function logout() {

    fetch("/logout", {

        method: "POST",

        headers: {

            "X-CSRF-TOKEN": csrfToken

        }

    }).then(() => {

        window.location.href = "/login";

    });

}


/*
|--------------------------------------------------------------------------
| Création d'une commande
|--------------------------------------------------------------------------
*/

document
    .getElementById("commandeForm")
    .addEventListener("submit", async function(e) {

        e.preventDefault();

        const response = await fetch("/api/commandes", {

            method: "POST",

            headers: {

                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-CSRF-TOKEN": csrfToken

            },

            body: JSON.stringify({

                montant:
                    document
                        .getElementById("montant")
                        .value,

                statut:
                    document
                        .getElementById("statut")
                        .value

            })

        });


        const data = await response.json();


        if (response.ok) {

            alert("Commande créée !");

            document
                .getElementById("commandeForm")
                .reset();

            chargerCommandes();

        } else {

            alert(JSON.stringify(data));

        }

    });


/*
|--------------------------------------------------------------------------
| Charger les commandes
|--------------------------------------------------------------------------
*/

function chargerCommandes() {

    fetch("/api/commandes")

        .then(response => response.json())

        .then(commandes => {

            const tbody =
                document.getElementById("listeCommandes");

            tbody.innerHTML = "";


           commandes.forEach(commande => {

    tbody.innerHTML += `

        <tr>

            <td>
                ${commande.id}
            </td>

            <td>
                ${commande.date_commande}
            </td>

            <td>
                ${commande.montant} €
            </td>

            <td>
                ${commande.statut}
            </td>

            <td>

                <button
                    onclick="modifierCommande(${commande.id})"
                >
                    Modifier
                </button>

                            ${
                                commande.statut !== "Livrée"

                                ? `
                                    <button
                                        onclick="supprimerCommande(${commande.id})"
                                    >
                                        Supprimer
                                    </button>
                                  `

                                : ""
                            }

                        </td>

                    </tr>

                `;

            });

        })

        .catch(error => {

            console.error(
                "Erreur chargement commandes :",
                error
            );

        });

}


/*
|--------------------------------------------------------------------------
| Modifier une commande
|--------------------------------------------------------------------------
*/

async function modifierCommande(id) {

    const nouvelleDate =
        prompt("Nouvelle date : 2026-07-01");

    const nouveauMontant =
        prompt("Nouveau montant :");

    const nouveauStatut =
        prompt(
            "Nouveau statut : En préparation / En cours / Livrée / en_attente"
        );


    if (
        !nouvelleDate ||
        !nouveauMontant ||
        !nouveauStatut
    ) {

        alert("Modification annulée");

        return;

    }


    const response = await fetch(
        `/api/commandes/${id}`,
        {

            method: "PUT",

            headers: {

                "Content-Type":
                    "application/json",

                "Accept":
                    "application/json",

                "X-CSRF-TOKEN": csrfToken

            },

            body: JSON.stringify({

                date_commande:
                    nouvelleDate,

                montant:
                    nouveauMontant,

                statut:
                    nouveauStatut

            })

        }
    );


    if (response.ok) {

        alert("Commande modifiée !");

        chargerCommandes();

    } else {

        const data =
            await response.json();

        alert(JSON.stringify(data));

    }

}


/*
|--------------------------------------------------------------------------
| Supprimer une commande
|--------------------------------------------------------------------------
*/

async function supprimerCommande(id) {

    if (
        !confirm(
            "Supprimer cette commande ?"
        )
    ) {

        return;

    }


    const response = await fetch(
        `/api/commandes/${id}`,
        {

            method: "DELETE",

            headers: {

                "Accept": "application/json",
                "X-CSRF-TOKEN": csrfToken

            }

        }
    );


    if (response.ok) {

        alert("Commande supprimée !");

        chargerCommandes();

    } else {

        const data = await response.json();

        alert(
            data.message || "Erreur suppression commande"
        );

    }

}


/*
|--------------------------------------------------------------------------
| Chargement initial
|--------------------------------------------------------------------------
*/

chargerCommandes();

</script>

@include('partials.accessibility')

</body>
</html>