<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Profil Administrateur</title>
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

            <li onclick="window.location.href='{{ route('admin.livraisons') }}'">🚚 Livraisons</li>

            <li onclick="window.location.href='{{ route('admin.utilisateurs') }}'">👥 Utilisateurs</li>

            <li style="font-weight:bold;">👤 Profil</li>
        </ul>

        <button onclick="logout()">Déconnexion</button>
    </div>

    <div class="main">

        <h1>Profil administrateur</h1>

        <section class="table">
            <h2>Mes informations</h2>

            <form id="profilForm">
                <input type="text" id="name" value="{{ auth()->user()->name }}" required>

                <input type="email" id="email" value="{{ auth()->user()->email }}" required>

                <input type="text" id="role" value="{{ auth()->user()->role }}" disabled>

                <button type="submit">Modifier mon profil</button>
            </form>
        </section>

        <section class="table">
            <h2>Modifier mon mot de passe</h2>

            <form id="passwordForm">
                <input type="password" id="new_password" placeholder="Nouveau mot de passe" required>

                <button type="submit">Modifier le mot de passe</button>
            </form>
        </section>
        <footer>
    © {{ date('Y') }} Carrefour - Application de gestion des livraisons
</footer>

    </div>

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

    if(response.ok){
        alert("Profil modifié !");
        location.reload();
    }else{
        alert("Erreur lors de la modification.");
    }

});

document.getElementById("passwordForm").addEventListener("submit", async function(e){

    e.preventDefault();

    const response = await fetch(`/api/users/${user.id}/password`, {

        method:"PUT",

        headers:{
            "Content-Type":"application/json",
            "Accept":"application/json"
        },

        body:JSON.stringify({
            password:document.getElementById("new_password").value
        })

    });

    if(response.ok){
        alert("Mot de passe modifié !");
        document.getElementById("passwordForm").reset();
    }else{
        alert("Erreur lors de la modification.");
    }

});

function logout(){

    fetch("/logout",{

        method:"POST",

        headers:{
            "X-CSRF-TOKEN":document.querySelector('meta[name="csrf-token"]').content
        }

    }).then(()=>{

        window.location.href="/login";

    });

}

</script>

</body>
</html>