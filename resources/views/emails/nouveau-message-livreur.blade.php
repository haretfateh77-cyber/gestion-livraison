<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nouveau message Carrefour</title>
</head>

<body style="margin:0; padding:0; background:#f4f6f8; font-family:Arial, sans-serif;">

    <div style="max-width:600px; margin:40px auto; background:white; border-radius:12px; overflow:hidden;">

        <div style="background:#0055b8; padding:25px; color:white;">
            <h1 style="margin:0;">
                Carrefour
            </h1>

            <p style="margin:8px 0 0;">
                Gestion des livraisons
            </p>
        </div>

        <div style="padding:30px;">

            <h2 style="color:#222;">
                Nouveau message d'un livreur
            </h2>

            <p>
                Bonjour,
            </p>

            <p>
                Vous avez reçu un nouveau message de
                <strong>{{ $contactMessage->expediteur->name }}</strong>.
            </p>

            <div style="
                background:#f5f7fa;
                padding:20px;
                border-radius:8px;
                margin:25px 0;
            ">

                <p style="margin-top:0;">
                    <strong>Sujet :</strong>
                    {{ $contactMessage->sujet }}
                </p>

                <p style="margin-bottom:0;">
                    <strong>Message :</strong>
                </p>

                <p>
                    {{ $contactMessage->contenu }}
                </p>

            </div>

            
            <p style="color:#666;">
                Connectez-vous à votre espace administrateur
                pour consulter ce message.
            </p>

        </div>

        <div style="
            background:#f4f6f8;
            padding:20px;
            text-align:center;
            color:#888;
            font-size:12px;
        ">
            Gestion Livraison Carrefour
        </div>

    </div>

</body>
</html>