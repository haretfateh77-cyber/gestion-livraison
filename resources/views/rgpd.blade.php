<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Politique de confidentialité</title>
    <link rel="icon" type="image/webp" href="{{ asset('images/OIP (3).webp') }}">

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
        Les mots de passe sont stockés de manière sécurisée grâce à un hachage
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

@include('partials.accessibility')

</body>
</html>