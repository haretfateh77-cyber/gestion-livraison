<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nouvelle livraison</title>
</head>

<body>

    <h2>Nouvelle livraison affectée</h2>

    <p>Bonjour {{ $livraison->livreur->name }},</p>

    <p>
        Une nouvelle livraison vous a été affectée.
    </p>

    <p>
        <strong>N° de livraison :</strong>
        #{{ $livraison->id }}
    </p>

    <p>
        <strong>N° de commande :</strong>
        #{{ $livraison->commande->id }}
    </p>

    <p>
        <strong>Date :</strong>
        {{ $livraison->date_livraison }}
    </p>

    <p>
        <strong>Adresse :</strong>
        {{ $livraison->adresse }}
    </p>

    <p>
        <strong>Statut :</strong>
        {{ $livraison->statut }}
    </p>

    <p>
        Bonne livraison !
    </p>

</body>
</html>