<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Profil Livreur</title>
<link rel="stylesheet" href="{{ asset('css/livreur.css') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="icon" type="image/webp" href="{{ asset('images/OIP (3).webp') }}">
</head>

<body>

<div class="sidebar">
    <div class="profile">
        <div class="avatar">👤</div>
        <h2 id="nomLivreur">{{ auth()->user()->name }}</h2>
    </div>

    <ul>
        <li onclick="window.location.href='/livreur'">🏠 Tableau de bord</li>
        <li onclick="window.location.href='/livreur'">📦 Mes livraisons</li>
        <li class="active">👤 Profil</li>
    </ul>

    <button onclick="logout()">Déconnexion</button>
</div>

<div class="main">
    <h1>Mon profil</h1>

    <form id="profilForm">
        <label>Nom</label><br>
        <input type="text" id="name" value="{{ auth()->user()->name }}" required><br><br>

        <label>Email</label><br>
        <input type="email" id="email" value="{{ auth()->user()->email }}" required><br><br>

        <label>Rôle</label><br>
        <input type="text" id="role" value="{{ auth()->user()->role }}" disabled><br><br>

        <button type="submit">Modifier mon profil</button>
    </form>

    <h2>Modifier mon mot de passe</h2>

    <form id="passwordForm">
        <label>Nouveau mot de passe</label><br>
        <input type="password" id="new_password" required><br><br>

        <button type="submit">Modifier le mot de passe</button>
    </form>
</div>

<script>
const user = {
    id: {{ auth()->user()->id }},
    name: "{{ auth()->user()->name }}",
    email: "{{ auth()->user()->email }}",
    role: "{{ auth()->user()->role }}"
};

document.getElementById("profilForm").addEventListener("submit", async function(e) {
    e.preventDefault();

    const response = await fetch(`/api/users/${user.id}`, {
        method: "PUT",
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json"
        },
        body: JSON.stringify({
            name: document.getElementById("name").value,
            email: document.getElementById("email").value,
            role: user.role
        })
    });

    if (response.ok) {
        alert("Profil modifié !");
        window.location.reload();
    } else {
        const data = await response.json();
        alert(JSON.stringify(data));
    }
});

document.getElementById("passwordForm").addEventListener("submit", async function(e) {
    e.preventDefault();

    const response = await fetch(`/api/users/${user.id}/password`, {
        method: "PUT",
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json"
        },
        body: JSON.stringify({
            password: document.getElementById("new_password").value
        })
    });

    if (response.ok) {
        alert("Mot de passe modifié !");
        document.getElementById("passwordForm").reset();
    } else {
        const data = await response.json();
        alert(JSON.stringify(data));
    }
});

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
</script>

</body>
</html>