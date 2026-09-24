<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Mon profil - Livreur</title>

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
            cursor: pointer;
        }

        .sidebar li:hover,
        .sidebar li.active {
            background: #3859d6;
        }

        .sidebar li a {
            display: block;
            width: 100%;
            color: white;
            text-decoration: none;
        }

        .sidebar li a:hover {
            color: white;
            text-decoration: none;
        }

        .logout-form {
            margin-top: 35px;
            background: transparent;
            padding: 0;
        }

        .logout-form button {
            width: 100%;
            padding: 15px;
            border: 0;
            border-radius: 8px;
            background: #3859d6;
            color: white;
            font-size: 18px;
            cursor: pointer;
        }

        .logout-form button:hover {
            background: #2f4ec8;
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

        h2 {
            font-size: 28px;
            margin-top: 0;
        }

        .table {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 2px 8px rgba(0,0,0,.08);
        }

        label {
            display: block;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 14px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 17px;
            margin-bottom: 18px;
        }

        input:disabled {
            background: #f1f1f1;
            color: #555;
        }

        .profile-form {
            background: transparent;
            padding: 0;
        }

        button {
            padding: 12px 18px;
            border: 0;
            border-radius: 7px;
            background: #0d1b4c;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background: #3859d6;
        }

        .password-rules {
            background: #f1f4ff;
            border-left: 4px solid #3859d6;
            padding: 15px 20px;
            margin: 5px 0 20px;
            border-radius: 6px;
        }

        .password-rules ul {
            margin-bottom: 0;
            padding-left: 25px;
        }

        .password-rules li {
            margin: 5px 0;
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
            margin: 8px 0 0;
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

    <li>
        <a href="{{ route('livreur.messages.create') }}">
            💬 Contact admin
        </a>
    </li>

    <li class="active">
        👤 Profil
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

        <h1>Mon profil</h1>

        @if(session('password_success'))
            <div class="validation-success">
                {{ session('password_success') }}
            </div>
        @endif


        @if($errors->any())

            <div class="validation-errors">

                <strong>Erreur :</strong>

                @foreach($errors->all() as $error)

                    <p>
                        {{ $error }}
                    </p>

                @endforeach

            </div>

        @endif


        <section class="table">

            <h2>Mes informations</h2>

            <form
                id="profilForm"
                class="profile-form"
            >

                <label for="name">
                    Nom
                </label>

                <input
                    type="text"
                    id="name"
                    value="{{ auth()->user()->name }}"
                    required
                >


                <label for="email">
                    Email
                </label>

                <input
                    type="email"
                    id="email"
                    value="{{ auth()->user()->email }}"
                    required
                >


                <label for="role">
                    Rôle
                </label>

                <input
                    type="text"
                    id="role"
                    value="{{ auth()->user()->role }}"
                    disabled
                >


                <button type="submit">
                    Modifier mon profil
                </button>

            </form>

        </section>


        <section class="table">

            <h2>
                Modifier mon mot de passe
            </h2>

            <form
                method="POST"
                action="{{ route('livreur.profil.password') }}"
                class="profile-form"
            >

                @csrf

                <label for="current_password">
                    Mot de passe actuel
                </label>

                <input
                    type="password"
                    id="current_password"
                    name="current_password"
                    placeholder="Mot de passe actuel"
                    required
                >


                <label for="new_password">
                    Nouveau mot de passe
                </label>

                <input
                    type="password"
                    id="new_password"
                    name="new_password"
                    placeholder="Nouveau mot de passe"
                    required
                >


                <div class="password-rules">

                    <strong>
                        Le nouveau mot de passe doit contenir :
                    </strong>

                    <ul>
                        <li>Au moins 8 caractères</li>
                        <li>Au moins une majuscule</li>
                        <li>Au moins une minuscule</li>
                        <li>Au moins un chiffre</li>
                        <li>Au moins un caractère spécial</li>
                    </ul>

                </div>


                <label for="new_password_confirmation">
                    Confirmer le nouveau mot de passe
                </label>

                <input
                    type="password"
                    id="new_password_confirmation"
                    name="new_password_confirmation"
                    placeholder="Confirmer le nouveau mot de passe"
                    required
                >


                <button type="submit">
                    Modifier le mot de passe
                </button>

            </form>

        </section>


        <footer>
            © {{ date('Y') }} Carrefour -
            Application de gestion des livraisons
        </footer>

    </main>

</div>

@include('partials.accessibility')

</body>
</html>