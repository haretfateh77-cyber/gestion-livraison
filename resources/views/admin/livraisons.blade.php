<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Gestion des livraisons</title>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="icon" type="image/webp" href="{{ asset('images/OIP (3).webp') }}">
</head>

<body>

<div class="layout">

    <div class="sidebar">
        <div class="logo">
            <img src="{{ asset('images/OIP (3).webp') }}" alt="Logo Carrefour">
        </div>

        <ul>
            <li onclick="window.location.href='{{ route('admin.dashboard') }}'">🏠 Tableau de bord</li>

            <li onclick="window.location.href='{{ route('admin.commandes') }}'">📦 Commandes</li>

            <li style="font-weight:bold;">🚚 Livraisons</li>

            <li onclick="window.location.href='{{ route('admin.utilisateurs') }}'">👥 Utilisateurs</li>

            <li onclick="window.location.href='{{ route('admin.profil') }}'">👤 Profil</li>
            <li onclick="window.location.href='{{ route('admin.messages.index') }}'">
    💬 Messages
</li>
        </ul>

        <button onclick="logout()">Déconnexion</button>
    </div>

    <div class="main">

        <h1>Gestion des livraisons</h1>

        <section class="table">

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>N° Livraison</th>
                        <th>Commande</th>
                        <th>Livreur</th>
                        <th>Date</th>
                        <th>Adresse</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody id="listeLivraisons"></tbody>
            </table>

        </section>
        <footer>
    © {{ date('Y') }} Carrefour - Application de gestion des livraisons
</footer>

    </div>

</div>

<script>

function logout() {

    fetch("/logout", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        }

    }).then(() => {

        window.location.href = "/login";

    });

}

function chargerLivraisons() {

    fetch("/api/livraisons")

    .then(response => response.json())

    .then(livraisons => {

        const tbody = document.getElementById("listeLivraisons");

        tbody.innerHTML = "";

        livraisons.forEach(livraison => {

            tbody.innerHTML += `
                <tr>
                    <td>${livraison.id}</td>
                    <td>${livraison.num_livraison}</td>
                    <td>${livraison.commande_id}</td>
                    <td>${livraison.livreur ? livraison.livreur.name : livraison.livreur_id}</td>
                    <td>${livraison.date_livraison ?? ""}</td>
                    <td>${livraison.adresse}</td>
                    <td>${livraison.statut}</td>
                    <td>
                        <button onclick="modifierLivraison(${livraison.id})">Modifier</button>
                        <button onclick="supprimerLivraison(${livraison.id})">Supprimer</button>
                    </td>
                </tr>
            `;

        });

    })

    .catch(() => {

        alert("Erreur chargement livraisons");

    });

}

async function modifierLivraison(id) {

    const nouvelleAdresse = prompt("Nouvelle adresse :");

    const nouveauStatut = prompt("Nouveau statut : En préparation / En cours / Livrée");

    const nouvelleDate = prompt("Nouvelle date : 2026-07-01");

    if(!nouvelleAdresse || !nouveauStatut || !nouvelleDate){

        alert("Modification annulée");

        return;

    }

    const response = await fetch(`/api/livraisons/${id}`,{

        method:"PUT",

        headers:{
            "Content-Type":"application/json",
            "Accept":"application/json"
        },

        body:JSON.stringify({
            adresse:nouvelleAdresse,
            statut:nouveauStatut,
            date_livraison:nouvelleDate
        })

    });

    if(response.ok){

        alert("Livraison modifiée !");

        chargerLivraisons();

    }else{

        alert("Erreur modification");

    }

}

async function supprimerLivraison(id){

    if(!confirm("Supprimer cette livraison ?")) return;

    const response = await fetch(`/api/livraisons/${id}`,{

        method:"DELETE",

        headers:{
            "Accept":"application/json"
        }

    });

    if(response.ok){

        alert("Livraison supprimée !");

        chargerLivraisons();

    }else{

        alert("Erreur suppression");

    }

}

chargerLivraisons();

</script>

</body>
</html>