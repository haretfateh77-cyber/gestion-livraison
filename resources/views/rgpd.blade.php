<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Politique de confidentialité</title>

    <style>
        body{
            font-family:Arial,sans-serif;
            max-width:900px;
            margin:40px auto;
            line-height:1.7;
            padding:20px;
            background:#f4f6f8;
        }

        .box{
            background:white;
            padding:35px;
            border-radius:10px;
            box-shadow:0 2px 8px rgba(0,0,0,.1);
        }

        h1{
            color:#0d1b4c;
        }

        a{
            color:#0d1b4c;
            text-decoration:none;
            font-weight:bold;
        }
    </style>

</head>

<body>

<div class="box">

<h1>Politique de confidentialité</h1>

<p>
Cette application de gestion des livraisons collecte uniquement les informations
nécessaires à son fonctionnement.
</p>

<h2>Données collectées</h2>

<ul>
<li>Nom</li>
<li>Adresse e-mail</li>
<li>Rôle (Administrateur ou Livreur)</li>
</ul>

<h2>Utilisation</h2>

<p>
Ces données sont utilisées uniquement pour gérer les utilisateurs,
les commandes et les livraisons.
</p>

<h2>Protection</h2>

<p>
Les mots de passe sont stockés de manière sécurisée grâce à un chiffrement
(Hash Laravel).
</p>

<h2>Conservation</h2>

<p>
Les données sont conservées uniquement pendant la durée nécessaire
au fonctionnement de l'application.
</p>

<h2>Vos droits</h2>

<p>
Vous pouvez demander la modification ou la suppression de vos informations
auprès de l'administrateur.
</p>

<br>

<a href="{{ route('login') }}">
← Retour à la connexion
</a>

</div>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link rel="icon" type="image/webp" href="{{ asset('images/OIP (3).webp') }}">

<div class="sidebar">

    <div class="logo">
        <img
            src="{{ asset('images/OIP (3).webp') }}"
            alt="Carrefour"
        >
    </div>

    <ul>

        <li onclick="window.location.href='{{ route('admin.dashboard') }}'">
            🏠 Tableau de bord
        </li>

        <li onclick="window.location.href='{{ route('admin.commandes') }}'">
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

        <button
            type="submit"
            class="logout"
            style="width:100%; border:none; cursor:pointer;"
        >
            Déconnexion
        </button>
    </form>

</div>


<div class="main">

    {{-- MESSAGE D'ERREUR --}}

    @if($errors->any())

        <div class="validation-errors">

            <strong>Erreur :</strong>

            @foreach($errors->all() as $error)

                <p>{{ $error }}</p>

            @endforeach

        </div>

    @endif


    {{-- MESSAGE DE SUCCÈS --}}

    @if(session('success'))

        <div class="message-success">
            {{ session('success') }}
        </div>

    @endif


    {{-- EN-TÊTE --}}

    <div class="header">

        <h1>Tableau de bord</h1>

        <div class="admin-info">

            <strong>Admin</strong><br>

            Administrateur

        </div>

    </div>


    {{-- STATISTIQUES --}}

    <div class="stats">

        <div class="stat-card">

            Commandes totales

            <div class="value">
                {{ $commandesTotales }}
            </div>

        </div>


        <div class="stat-card">

            Livraisons totales

            <div class="value">
                {{ $livraisonsTotales }}
            </div>

        </div>


        <div class="stat-card">

            En cours de livraison

            <div class="value">
                {{ $enCoursLivraison }}
            </div>

        </div>


        <div class="stat-card">

            Livraisons livrées

            <div class="value">
                {{ $livraisonsLivrees }}
            </div>

        </div>

    </div>


    {{-- PANNEAUX --}}

    <div class="panels">

        <div class="panel">

            <h2>Livraison par statut</h2>

            <ul>

                <li>
                    <span class="dot blue"></span>
                    En préparation
                </li>

                <li>
                    <span class="dot green"></span>
                    En cours
                </li>

                <li>
                    <span class="dot blue"></span>
                    Livrée
                </li>

            </ul>

        </div>


        <div class="panel">

            <h2>Livraisons récentes</h2>

            <ul>

                @forelse($livraisonsRecentes as $livraison)

    <li>

        <strong>
            Livraison #{{ $livraison->id }}
        </strong>

        - {{ $livraison->statut }}

    </li>

@empty

    <li>
        Aucune livraison récente.
    </li>

@endforelse

            </ul>

        </div>


        <div class="panel">

            <h2>Livreurs disponibles</h2>

            <ul>

                @forelse($livreurs as $livreur)

                    <li>
                        👤 {{ $livreur->name }}
                    </li>

                @empty

                    <li>
                        Aucun livreur disponible.
                    </li>

                @endforelse

            </ul>

        </div>

    </div>


    {{-- CRÉER UNE LIVRAISON --}}

    <div class="form-section">

        <h2>Créer une livraison</h2>

        <form
            method="POST"
            action="{{ route('admin.livraisons.store') }}"
        >

            @csrf



            <select name="commande_id" required>

                <option value="">
                    Choisir une commande
                </option>

                @foreach($commandes as $commande)

                    <option
                        value="{{ $commande->id }}"
                        {{ old('commande_id') == $commande->id ? 'selected' : '' }}
                    >
                        Commande #{{ $commande->id }}
                    </option>

                @endforeach

            </select>


            <input
                type="text"
                name="adresse"
                value="{{ old('adresse') }}"
                placeholder="Adresse"
                required
            >


            <select name="statut">

                <option value="En préparation">
                    En préparation
                </option>

                <option value="En cours">
                    En cours
                </option>

                <option value="Livrée">
                    Livrée
                </option>

            </select>


            <button type="submit">
                Créer la livraison
            </button>

        </form>

    </div>


    {{-- COMMANDES RÉCENTES --}}

    <div class="table-section">

        <h2>Commandes récentes</h2>

        <table>

            <thead>

                <tr>

                    <th>ID</th>
                    <th>Date</th>
                    <th>Montant</th>
                    <th>Statut</th>

                </tr>

            </thead>


            <tbody>

                @forelse($commandes as $commande)

                    <tr>

                        <td>
                            {{ $commande->id }}
                        </td>

                        <td>
                            {{ $commande->date_commande }}
                        </td>

                        <td>
                            {{ number_format($commande->montant, 2) }} €
                        </td>

                        <td>
                            {{ $commande->statut }}
                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="5">
                            Aucune commande récente.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>


        <footer>
        © {{ date('Y') }} Carrefour -
        Application de gestion des livraisons
    </footer>

</div>

@include('partials.accessibility')

</body>
</html>