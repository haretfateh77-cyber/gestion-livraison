<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>{{ $message->sujet }}</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="icon" type="image/webp" href="{{ asset('images/OIP (3).webp') }}">

    <style>
        * {
            box-sizing: border-box;
        }

        .main {
            flex: 1;
            padding: 35px;
        }

        .message-detail {
            max-width: 900px;
            background: white;
            padding: 30px;
            border-radius: 12px;
            border-left: 5px solid #3b5bdb;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        .message-detail h1 {
            margin-top: 0;
            margin-bottom: 20px;
        }

        .message-meta {
            margin-bottom: 25px;
            color: #444;
        }

        .message-body {
            padding: 22px;
            background: #f7f9ff;
            border-radius: 10px;
            line-height: 1.6;
            white-space: pre-wrap;
        }

        .btn-retour {
            display: inline-block;
            margin-top: 25px;
            padding: 11px 18px;
            border-radius: 8px;
            background: #3b5bdb;
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        .btn-retour:hover {
            background: #2f4ec8;
        }

        .sidebar form {
            margin: 0;
            padding: 0;
            background: transparent;
        }
    </style>
</head>

<body>

<div class="layout">

    <div class="sidebar">

        <div class="logo">
            <img
                src="{{ asset('images/OIP (3).webp') }}"
                alt="Carrefour"
                class="logo"
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
                style="width: 100%; border: none; cursor: pointer;"
            >
                Déconnexion
            </button>
        </form>

    </div>

    <div class="main">

        <div class="header">
            <h1>Détail du message</h1>

            <div class="admin-info">
                <strong>{{ auth()->user()->name }}</strong><br>
                Administrateur
            </div>
        </div>

        <div class="message-detail">

            <h1>{{ $message->sujet }}</h1>

            <div class="message-meta">
                <p>
                    <strong>Expéditeur :</strong>
                    {{ $message->expediteur->name ?? 'Utilisateur inconnu' }}
                </p>

                <p>
                    <strong>Date :</strong>
                    {{ $message->created_at->format('d/m/Y à H:i') }}
                </p>

                @if($message->livraison)
                    <p>
                        <strong>Livraison :</strong>
                        {{ $message->livraison->num_livraison }}
                    </p>
                @endif
            </div>

            <div class="message-body">
                {{ $message->contenu }}
            </div>

            <a
                href="{{ route('admin.messages.index') }}"
                class="btn-retour"
            >
                ← Retour aux messages
            </a>

        </div>

        <footer>
            © {{ date('Y') }} Carrefour - Application de gestion des livraisons
        </footer>

    </div>

</div>

</body>
</html>