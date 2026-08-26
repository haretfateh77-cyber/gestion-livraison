<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Messages reçus</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="icon" type="image/webp" href="{{ asset('images/OIP (3).webp') }}">

    <style>
        * {
            box-sizing: border-box;
        }

        .layout {
            display: flex;
            min-height: 100vh;
            width: 100%;
        }

        .sidebar {
            flex-shrink: 0;
        }

        .main {
            flex: 1;
            min-width: 0;
            padding: 35px;
            display: flex;
            flex-direction: column;
        }

        .header {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .header h1 {
            margin: 0;
        }

        .messages-container {
            width: 100%;
            max-width: 1000px;
            flex: 1;
        }

        .message-card {
            width: 100%;
            background: white;
            padding: 22px;
            margin-bottom: 18px;
            border-radius: 12px;
            border-left: 5px solid #3b5bdb;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .message-card.non-lu {
            border-left-color: #ef4444;
        }

        .message-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-bottom: 12px;
        }

        .message-header h2 {
            margin: 0;
            font-size: 21px;
        }

        .message-expediteur {
            margin: 7px 0;
            font-weight: bold;
        }

        .message-contenu {
            margin: 12px 0 18px;
            color: #444;
            line-height: 1.5;
        }

        .badge-nouveau,
        .badge-lu {
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: bold;
            white-space: nowrap;
        }

        .badge-nouveau {
            background: #fee2e2;
            color: #b91c1c;
        }

        .badge-lu {
            background: #dcfce7;
            color: #166534;
        }

        .btn-lire {
            display: inline-block;
            padding: 10px 18px;
            border-radius: 8px;
            background: #3b5bdb;
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        .btn-lire:hover {
            background: #2f4ec8;
        }

        .aucun-message {
            width: 100%;
            background: white;
            padding: 30px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        footer {
            width: 100%;
            margin-top: 40px;
            padding: 20px 0;
            text-align: center;
            position: static;
            border-top: 1px solid #ddd;
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
            <h1>Messages reçus</h1>

            <div class="admin-info">
                <strong>{{ auth()->user()->name }}</strong><br>
                Administrateur
            </div>
        </div>

        <div class="messages-container">

            @forelse($messages as $message)

                <div class="message-card {{ !$message->lu ? 'non-lu' : '' }}">

                    <div class="message-header">
                        <h2>{{ $message->sujet }}</h2>

                        @if(!$message->lu)
                            <span class="badge-nouveau">Nouveau</span>
                        @else
                            <span class="badge-lu">Lu</span>
                        @endif
                    </div>

                    <p class="message-expediteur">
                        De :
                        {{ $message->expediteur->name ?? 'Utilisateur inconnu' }}
                    </p>

                    <p class="message-contenu">
                        {{ \Illuminate\Support\Str::limit($message->contenu, 150) }}
                    </p>

                    <a
                        href="{{ route('admin.messages.show', $message) }}"
                        class="btn-lire"
                    >
                        Lire le message
                    </a>

                </div>

            @empty

                <div class="aucun-message">
                    <h2>Aucun message reçu</h2>
                    <p>Les messages envoyés par les livreurs apparaîtront ici.</p>
                </div>

            @endforelse

        </div>

        <footer>
            © {{ date('Y') }} Carrefour - Application de gestion des livraisons
        </footer>

    </div>

</div>

</body>
</html>