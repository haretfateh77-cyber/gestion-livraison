<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Mentions légales - Carrefour</title>

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

        .header {
            background: #ffffff;
            padding: 20px 8%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #ddd;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 15px;
            color: #0055b8;
            font-size: 28px;
            font-weight: bold;
        }

        .logo img {
            width: 55px;
            height: 55px;
            object-fit: contain;
        }

        .container {
            max-width: 1000px;
            margin: 50px auto;
            padding: 40px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        h1 {
            color: #0d1b4c;
            font-size: 38px;
            margin-bottom: 35px;
        }

        h2 {
            color: #0d1b4c;
            margin-top: 35px;
            margin-bottom: 12px;
        }

        p,
        li {
            font-size: 17px;
            line-height: 1.7;
        }

        ul {
            padding-left: 25px;
        }

        .warning {
            background: #fff3cd;
            border: 1px solid #ffecb5;
            color: #664d03;
            padding: 18px;
            border-radius: 8px;
            margin-top: 25px;
        }

        .back {
            display: inline-block;
            margin-top: 35px;
            padding: 12px 20px;
            background: #3859d6;
            color: white;
            text-decoration: none;
            border-radius: 8px;
        }

        .back:hover {
            background: #2f4ec8;
        }

        footer {
            text-align: center;
            padding: 30px;
            color: #666;
        }
    </style>
</head>

<body>

<header class="header">

    <div class="logo">

        <img
            src="{{ asset('images/OIP (3).webp') }}"
            alt="Carrefour"
        >

        Carrefour

    </div>

</header>


<main class="container">

    <h1>Mentions légales</h1>


    <h2>Éditeur du site</h2>

    <p>
        <strong>Nom :</strong>
        Carrefour - Application de gestion des livraisons
    </p>

    <p>
        <strong>Type :</strong>
        Application interne de gestion des livraisons
    </p>


    <h2>Responsable de la publication</h2>

    <p>
        Responsable de la publication :
        Administrateur de l'application.
    </p>


    <h2>Hébergement</h2>

    <p>
        Cette application est actuellement utilisée dans le cadre
        d'un environnement de développement et de démonstration.
    </p>

    <p>
        Les informations relatives à l'hébergeur devront être
        complétées lors de la mise en production de l'application.
    </p>


    <h2>Propriété intellectuelle</h2>

    <p>
        L'ensemble des éléments présents sur cette application,
        notamment les textes, interfaces et éléments graphiques,
        est destiné à l'utilisation dans le cadre du projet
        de gestion des livraisons.
    </p>


    <h2>Données personnelles</h2>

    <p>
        Le traitement des données personnelles est présenté dans
        la
        <a href="{{ route('rgpd') }}">
            politique de confidentialité
        </a>.
    </p>


    <h2>Contact</h2>

    <p>
        Pour toute question concernant l'application ou les données
        personnelles, l'utilisateur peut contacter l'administrateur
        de l'application.
    </p>


    <div class="warning">

        <strong>Informations à compléter :</strong>

        <p>
            Les mentions telles que le numéro SIRET, l'adresse
            officielle de l'éditeur, les coordonnées du responsable
            et les informations précises de l'hébergeur devront être
            renseignées avant une éventuelle mise en production
            publique.
        </p>

    </div>


    <a href="{{ route('home') }}" class="back">
        ← Retour à l'accueil
    </a>

</main>


<footer>

    © {{ date('Y') }} Carrefour -
    Application de gestion des livraisons

</footer>
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