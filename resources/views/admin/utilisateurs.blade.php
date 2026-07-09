<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des utilisateurs</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="icon" type="image/webp" href="{{ asset('images/OIP (3).webp') }}">
</head>

<body>
<div class="layout">

    <div class="sidebar">
        <div class="logo">
            <img src="{{ asset('images/OIP (3).webp') }}" alt="Carrefour">
        </div>

        <ul>
            <li onclick="window.location.href='{{ route('admin.dashboard') }}'">🏠 Tableau de bord</li>
            <li onclick="window.location.href='{{ route('admin.commandes') }}'">📦 Commandes</li>
            <li onclick="window.location.href='{{ route('admin.livraisons') }}'">🚚 Livraisons</li>
            <li style="font-weight:bold;">👥 Utilisateurs</li>
            <li onclick="window.location.href='{{ route('admin.profil') }}'">👤 Profil</li>
        </ul>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">Déconnexion</button>
        </form>
    </div>

    <div class="main">
        <h1>Gestion des utilisateurs</h1>

        @if(session('success'))
            <p style="color:green; margin:15px 0;">{{ session('success') }}</p>
        @endif

        <section class="table">
            <h2>Ajouter un utilisateur</h2>

            <form method="POST" action="{{ route('admin.utilisateurs.store') }}">
                @csrf

                <input type="text" name="name" placeholder="Nom" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Mot de passe" required>

                <select name="role" required>
                    <option value="livreur">Livreur</option>
                    <option value="admin">Admin</option>
                </select>

                <button type="submit">Créer l'utilisateur</button>
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
                        <th>Nouveau mot de passe</th>
                        <th>Modifier</th>
                        <th>Supprimer</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <form method="POST" action="{{ route('admin.utilisateurs.update', $user->id) }}">
                                @csrf
                                @method('PUT')

                                <td>{{ $user->id }}</td>

                                <td>
                                    <input type="text" name="name" value="{{ $user->name }}" required>
                                </td>

                                <td>
                                    <input type="email" name="email" value="{{ $user->email }}" required>
                                </td>

                                <td>
                                    <select name="role" required>
                                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="livreur" {{ $user->role == 'livreur' ? 'selected' : '' }}>Livreur</option>
                                    </select>
                                </td>

                                <td>
                                    <input type="password" name="password" placeholder="Facultatif">
                                </td>

                                <td>
                                    <button type="submit">Modifier</button>
                                </td>
                            </form>

                            <td>
                                <form method="POST" action="{{ route('admin.utilisateurs.destroy', $user->id) }}">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" onclick="return confirm('Supprimer cet utilisateur ?')">
                                        Supprimer
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>
        <footer>
    © {{ date('Y') }} Carrefour - Application de gestion des livraisons
</footer>
    </div>

</div>
</body>
</html>