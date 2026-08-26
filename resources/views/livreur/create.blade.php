<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Contact administrateur</title>

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

        .layout {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            width: 315px;
            background: #0d1b4c;
            color: white;
            padding: 25px 16px;
        }

        .logo {
            text-align: center;
            margin-bottom: 45px;
        }

        .logo img {
            width: 205px;
            max-width: 100%;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar li {
            padding: 20px 15px;
            margin-bottom: 8px;
            font-size: 20px;
            border-radius: 8px;
        }

        .sidebar li:hover,
        .sidebar li.active {
            background: #3859d6;
        }

        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
        }

        .logout-form {
            margin-top: 35px;
        }

        .logout-form button {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 8px;
            background: #3859d6;
            color: white;
            font-size: 18px;
            cursor: pointer;
        }

        .main {
            margin-left: 315px;
            width: calc(100% - 315px);
            padding: 40px;
        }

        h1 {
            font-size: 40px;
            margin: 0 0 30px;
        }

        .table {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 2px 8px rgba(0,0,0,.08);
            max-width: 900px;
        }

        label {
            display: block;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 8px;
        }

        input,
        textarea {
            width: 100%;
            padding: 14px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 17px;
            font-family: Arial, sans-serif;
        }

        textarea {
            min-height: 180px;
            resize: vertical;
        }

        button.send {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 8px;
            background: #3859d6;
            color: white;
            font-size: 17px;
            cursor: pointer;
        }

        button.send:hover {
            background: #2f4ec8;
        }

        .validation-errors {
            background: #f8d7da;
            color: #842029;
            border: 1px solid #f5c2c7;
            padding: 18px;
            border-radius: 8px;
            margin-bottom: 25px;
        }

        .validation-errors p {
            margin: 8px 0;
        }

        .validation-success {
            background: #d1e7dd;
            color: #0f5132;
            border: 1px solid #badbcc;
            padding: 18px;
            border-radius: 8px;
            margin-bottom: 25px;
        }

        footer {
            text-align: center;
            border-top: 1px solid #ccc;
            padding: 25px 0;
            margin-top: 40px;
        }
    </style>
</head>

<body>

<div class="layout">

    <aside class="sidebar">

        <div class="logo">
            <img
                src="{{ asset('images/OIP (3).webp') }}"
                alt="Logo Carrefour"
            >
        </div>

        <ul>

            <li>
                <a href="{{ route('livreur') }}">
                    🏠 Tableau de bord
                </a>
            </li>

            <li>
                <a href="{{ route('livreur') }}">
                    📦 Mes livraisons
                </a>
            </li>

            <li class="active">
                <a href="{{ route('livreur.messages.create') }}">
                    💬 Contact admin
                </a>
            </li>

            <li>
                <a href="{{ route('livreur.profil') }}">
                    👤 Profil
                </a>
            </li>

        </ul>

        <form
            method="POST"
            action="{{ route('logout') }}"
            class="logout-form"
        >
            @csrf

            <button type="submit">
                Déconnexion
            </button>
        </form>

    </aside>


    <main class="main">

        <h1>Contacter l'administrateur</h1>

        @if(session('success'))
            <div class="validation-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="validation-errors">

                <strong>Erreur :</strong>

                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach

            </div>
        @endif


        <section class="table">

            <h2>Envoyer un message</h2>

            <form
                method="POST"
                action="{{ route('livreur.messages.store') }}"
            >

                @csrf

                <label for="sujet">
                    Sujet
                </label>

                <input
                    type="text"
                    id="sujet"
                    name="sujet"
                    value="{{ old('sujet') }}"
                    placeholder="Sujet du message"
                    required
                >

                <label for="contenu">
                    Message
                </label>

                <textarea
                    id="contenu"
                    name="contenu"
                    placeholder="Écrivez votre message..."
                    required
                >{{ old('contenu') }}</textarea>

                <button
                    type="submit"
                    class="send"
                >
                    Envoyer le message
                </button>

            </form>

        </section>


        <footer>
            © {{ date('Y') }} Carrefour -
            Application de gestion des livraisons
        </footer>

    </main>

</div>

</body>
</html>