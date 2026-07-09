<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Espace Livreur</title>
    <link rel="stylesheet" href="{{ asset('css/livreur.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/webp" href="{{ asset('images/OIP (3).webp') }}">
</head>

<body>

<div class="sidebar">
    <div class="profile">
        <div class="avatar">👤</div>
        <h2>{{ auth()->user()->name }}</h2>
    </div>

    <ul>
        <li>🏠 Tableau de bord</li>
        <li>📦 Mes livraisons</li>
        <li onclick="window.location.href='{{ route('livreur.profil') }}'">👤 Profil</li>
    </ul>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Déconnexion</button>
    </form>
</div>

<div class="main">

    <header>
        <p>Bonjour,</p>
        <h1>{{ auth()->user()->name }}</h1>
        <span>Voici vos livraisons</span>
    </header>

    <section class="cards">
        <div class="card">
            Toutes
            <h2 id="totalLivraisons">0</h2>
        </div>

        <div class="card orange">
            En cours
            <h2 id="livraisonsEnCours">0</h2>
        </div>

        <div class="card green">
            Livrées
            <h2 id="livraisonsLivrees">0</h2>
        </div>
    </section>

    <section class="content">
        <div class="livraisons">
            <h2>Mes livraisons</h2>
            <div id="mesLivraisons"></div>
        </div>

        <div class="details">
            <h2>Détail de la livraison</h2>
            <div id="detailsLivraison">
                <p>Sélectionne une livraison.</p>
            </div>
        </div>
    </section>

</div>

<script>
const livreurId = {{ auth()->user()->id }};
let listeLivraisons = [];

chargerLivraisons();

function chargerLivraisons() {
    fetch(`/api/livreur/${livreurId}/livraisons`)
        .then(response => response.json())
        .then(livraisons => {
            listeLivraisons = livraisons;

            const div = document.getElementById("mesLivraisons");
            div.innerHTML = "";

            document.getElementById("totalLivraisons").innerText = livraisons.length;

            const enCours = livraisons.filter(l =>
                l.statut === "En cours" || l.statut === "En préparation"
            ).length;

            const livrees = livraisons.filter(l => l.statut === "Livrée").length;

            document.getElementById("livraisonsEnCours").innerText = enCours;
            document.getElementById("livraisonsLivrees").innerText = livrees;

            if (livraisons.length === 0) {
                div.innerHTML = "<p>Aucune livraison assignée.</p>";
                return;
            }

            livraisons.forEach(livraison => {
                div.innerHTML += `
                    <div class="delivery" onclick="afficherDetails(${livraison.id})">
                        <h3>Livraison n° ${livraison.num_livraison}</h3>
                        <p><strong>Adresse :</strong> ${livraison.adresse}</p>
                        <p><strong>Statut :</strong> ${livraison.statut}</p>
                    </div>
                `;
            });
        })
        .catch(() => {
            alert("Erreur chargement livraisons");
        });
}

function afficherDetails(id) {
    const livraison = listeLivraisons.find(l => l.id === id);

    if (!livraison) return;

    document.getElementById("detailsLivraison").innerHTML = `
        <h1>Livraison n° ${livraison.num_livraison}</h1>
        <p><strong>Adresse :</strong> ${livraison.adresse}</p>
        <p><strong>Statut :</strong> ${livraison.statut}</p>
        <p><strong>Date :</strong> ${livraison.date_livraison ?? "Non renseignée"}</p>

        <button class="validate" onclick="changerStatut(${livraison.id}, 'En cours')">
            Marquer en cours
        </button>

        <button class="validate" onclick="changerStatut(${livraison.id}, 'Livrée')">
            Marquer comme livrée
        </button>
    `;
}

async function changerStatut(id, statut) {
    const response = await fetch(`/api/livraisons/${id}/statut`, {
        method: "PUT",
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            statut: statut
        })
    });

    if (response.ok) {
        alert("Statut mis à jour !");
        chargerLivraisons();
        document.getElementById("detailsLivraison").innerHTML = "<p>Sélectionne une livraison.</p>";
    } else {
        alert("Erreur lors de la mise à jour");
    }
}
</script>

</body>
</html>