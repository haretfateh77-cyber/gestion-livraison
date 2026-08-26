<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Gestion des commandes</title>
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
            <li style="font-weight:bold;">📦 Commandes</li>
            <li onclick="window.location.href='{{ route('admin.livraisons') }}'">🚚 Livraisons</li>
            <li onclick="window.location.href='{{ route('admin.utilisateurs') }}'">👥 Utilisateurs</li>
            <li onclick="window.location.href='{{ route('admin.profil') }}'">👤 Profil</
            li>
            <li onclick="window.location.href='{{ route('admin.messages.index') }}'">
    💬 Messages
</li>
        </ul>

        <button onclick="logout()">Déconnexion</button>
    </div>

    <div class="main">

        <h1>Gestion des commandes</h1>

        <section class="table">
            <h2>Créer une commande</h2>

            <form id="commandeForm">
                <input type="number" id="num_commande" placeholder="N° commande" required>
                <input type="date" id="date_commande" required>
                <input type="number" id="montant" placeholder="Montant" required>

                <select id="statut">
                    <option value="En préparation">En préparation</option>
                    <option value="En cours">En cours</option>
                    <option value="Livrée">Livrée</option>
                    <option value="en_attente">En attente</option>
                </select>

                <button type="submit">Créer la commande</button>
            </form>
        </section>

        <section class="table">
            <h2>Commandes créées</h2>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>N° Commande</th>
                        <th>Date</th>
                        <th>Montant</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody id="listeCommandes"></tbody>
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

document.getElementById("commandeForm").addEventListener("submit", async function(e) {
    e.preventDefault();

    const response = await fetch("/api/commandes", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json"
        },
        body: JSON.stringify({
            num_commande: document.getElementById("num_commande").value,
            date_commande: document.getElementById("date_commande").value,
            montant: document.getElementById("montant").value,
            statut: document.getElementById("statut").value
        })
    });

    const data = await response.json();

    if (response.ok) {
        alert("Commande créée !");
        document.getElementById("commandeForm").reset();
        chargerCommandes();
    } else {
        alert(JSON.stringify(data));
    }
});

function chargerCommandes() {
    fetch("/api/commandes")
        .then(response => response.json())
        .then(commandes => {
            const tbody = document.getElementById("listeCommandes");
            tbody.innerHTML = "";

            commandes.forEach(commande => {
                tbody.innerHTML += `
                    <tr>
                        <td>${commande.id}</td>
                        <td>${commande.num_commande}</td>
                        <td>${commande.date_commande}</td>
                        <td>${commande.montant} €</td>
                        <td>${commande.statut}</td>
                        <td>
                            <button onclick="modifierCommande(${commande.id})">Modifier</button>
                            <button onclick="supprimerCommande(${commande.id})">Supprimer</button>
                        </td>
                    </tr>
                `;
            });
        });
}

async function modifierCommande(id) {
    const nouvelleDate = prompt("Nouvelle date : 2026-07-01");
    const nouveauMontant = prompt("Nouveau montant :");
    const nouveauStatut = prompt("Nouveau statut : En préparation / En cours / Livrée / en_attente");

    if (!nouvelleDate || !nouveauMontant || !nouveauStatut) {
        alert("Modification annulée");
        return;
    }

    const response = await fetch(`/api/commandes/${id}`, {
        method: "PUT",
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json"
        },
        body: JSON.stringify({
            date_commande: nouvelleDate,
            montant: nouveauMontant,
            statut: nouveauStatut
        })
    });

    if (response.ok) {
        alert("Commande modifiée !");
        chargerCommandes();
    } else {
        const data = await response.json();
        alert(JSON.stringify(data));
    }
}

async function supprimerCommande(id) {
    if (!confirm("Supprimer cette commande ?")) return;

    const response = await fetch(`/api/commandes/${id}`, {
        method: "DELETE",
        headers: {
            "Accept": "application/json"
        }
    });

    if (response.ok) {
        alert("Commande supprimée !");
        chargerCommandes();
    } else {
        alert("Erreur suppression commande");
    }
}

chargerCommandes();
</script>

</body>
</html>