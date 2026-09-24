<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Gestion des utilisateurs</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="icon" type="image/webp" href="{{ asset('images/OIP (3).webp') }}">

    <style>
        .message-success {
            margin: 15px 0;
            padding: 12px 16px;
            color: #155724;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            border-radius: 8px;
        }

        .validation-errors {
            margin: 15px 0;
            padding: 14px 18px;
            color: #842029;
            background-color: #f8d7da;
            border: 1px solid #f5c2c7;
            border-radius: 8px;
        }

        .validation-errors strong {
            display: block;
            margin-bottom: 8px;
        }

        .validation-errors ul {
            margin: 0;
            padding-left: 20px;
        }

        .validation-errors li {
            margin-bottom: 5px;
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

            <li style="font-weight: bold;">
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

            <button type="submit">
                Déconnexion
            </button>
        </form>

    </div>

    <div class="main">

        <h1>Gestion des utilisateurs</h1>

        @if(session('success'))
            <div class="message-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="validation-errors">

                <strong>
                    Impossible d’enregistrer les modifications :
                </strong>

                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

            </div>
        @endif

        <section class="table">

            <h2>Ajouter un utilisateur</h2>

            <form
                method="POST"
                action="{{ route('admin.utilisateurs.store') }}"
            >
                @csrf

                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Nom"
                    maxlength="255"
                    required
                >

                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Email"
                    maxlength="255"
                    required
                >

                

                <select name="role" required>

                    <option
                        value="livreur"
                        {{ old('role') === 'livreur' ? 'selected' : '' }}
                    >
                        Livreur
                    </option>

                    <option
                        value="admin"
                        {{ old('role') === 'admin' ? 'selected' : '' }}
                    >
                        Admin
                    </option>

                </select>

                <button type="submit">
                    Créer l’utilisateur
                </button>

            </form>

        </section>

        <section class="table">

            <h2>Liste des utilisateurs</h2>

            <table>

                <thead>

                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Rôle</th>
                        <th>Modifier</th>
                        <th>Supprimer</th>
                    </tr>

                </thead>

                <tbody>

                @forelse($users as $user)

                    <tr>

                        <form
                            method="POST"
                            action="{{ route('admin.utilisateurs.update', $user->id) }}"
                        >
                            @csrf

                            @method('PUT')

                            <td>
                                {{ $user->id }}
                            </td>

                            <td>

                                <input
                                    type="text"
                                    name="name"
                                    value="{{ $user->name }}"
                                    maxlength="255"
                                    required
                                >

                            </td>

                            <td>

                                <input
                                    type="email"
                                    name="email"
                                    value="{{ $user->email }}"
                                    maxlength="255"
                                    required
                                >

                            </td>

                            

        <td>
    <strong>
        {{ $user->role === 'admin' ? 'Admin' : 'Livreur' }}
    </strong>
</td>                        

                            

                            <td>

                                <button type="submit">
                                    Modifier
                                </button>

                            </td>

                        </form>

                        <td>

                            <form
                                method="POST"
                                action="{{ route('admin.utilisateurs.destroy', $user->id) }}"
                            >
                                @csrf

                                @method('DELETE')

                                <button
                                    type="submit"
                                    onclick="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?')"
                                >
                                    Supprimer
                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="6">
                            Aucun utilisateur enregistré.
                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </section>

        <footer>
            © {{ date('Y') }} Carrefour -
            Application de gestion des livraisons
        </footer>

    </div>

</div>

@include('partials.accessibility')

</body>
</html>