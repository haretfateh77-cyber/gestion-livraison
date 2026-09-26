<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Mentions légales - Carrefour</title>
    <link rel="icon" type="image/webp" href="{{ asset('images/OIP (3).webp') }}">

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

@include('partials.accessibility')

</body>

</html>