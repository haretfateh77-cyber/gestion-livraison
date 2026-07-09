<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de bord</title>
   <link rel="stylesheet" href="{{ asset('css/style.css') }}">
   <link rel="icon" type="image/webp" href="{{ asset('images/OIP (3).webp') }}">
</head>

<body>
    <div class="layout">

        <div class="sidebar">
            <div class="logo">
                <img src="{{ asset('images/OIP (3).webp') }}" alt="Carrefour" class="logo">
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
</ul>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout" style="width:100%; border:none; cursor:pointer;">
                    Déconnexion
                </button>
            </form>
        </div>

        <div class="main">

            <div class="header">
                <h1>Tableau de bord</h1>
                <div class="admin-info">
                    <strong>Admin</strong><br>
                    Administrateur
                </div>
            </div>

            <div class="stats">
                <div class="stat-card">
                    Commandes totales
                    <div class="value">{{ $commandesTotales }}</div>
                </div>
                <div class="stat-card">
                    Livraisons totales
                    <div class="value">{{ $livraisonsTotales }}</div>
                </div>
                <div class="stat-card">
                    En cours de livraison
                    <div class="value">{{ $enCoursLivraison }}</div>
                </div>
                <div class="stat-card">
                    Livraisons livrées
                    <div class="value">{{ $livraisonsLivrees }}</div>
                </div>
            </div>

            <div class="panels">
                <div class="panel">
                    <h2>Livraison par statut</h2>
                    <ul>
                        <li><span class="dot blue"></span> En préparation</li>
                        <li><span class="dot green"></span> En cours</li>
                        <li><span class="dot blue"></span> Livrée</li>
                    </ul>
                </div>

                <div class="panel">
                    <h2>Livraisons récentes</h2>
                    <ul>
                        @foreach ($livraisonsRecentes as $livraison)
                            <li><strong>Livraison {{ $livraison->num_livraison }}</strong> - {{ $livraison->statut }}</li>
                        @endforeach
                    </ul>
                </div>

                <div class="panel">
                    <h2>Livreurs disponibles</h2>
                    <ul>
                        @foreach ($livreurs as $livreur)
                            <li>👤{{ $livreur->name }} </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="form-section">
                <h2>Créer une livraison</h2>
                <form method="POST" action="{{ route('livraisons.store') }}">
                    @csrf
                    <input type="text" name="num_livraison" placeholder="N° livraison" required>

                    <select name="commande_id" required>
                        <option value="">Choisir une commande</option>
                        @foreach ($commandes as $commande)
                            <option value="{{ $commande->id }}">{{ $commande->num_commande }}</option>
                        @endforeach
                    </select>

                    <input type="date" name="date" required>

                    <select name="livreur_id" required>
                        <option value="">Choisir un livreur</option>
                        @foreach ($livreurs as $livreur)
    <option value="{{ $livreur->id }}">{{ $livreur->name }}</option>
@endforeach
                    </select>

                    <input type="text" name="adresse" placeholder="Adresse" required>

                    <select name="statut">
                        <option value="En préparation">En préparation</option>
                        <option value="En cours">En cours</option>
                        <option value="Livrée">Livrée</option>
                    </select>

                    <button type="submit">Créer la livraison</button>
                </form>
            </div>

            <div class="table-section">
                <h2>Commandes récentes</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>N° Commande</th>
                            <th>Date</th>
                            <th>Montant</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($commandes as $commande)
                            <tr>
                                <td>{{ $commande->id }}</td>
                                <td>{{ $commande->num_commande }}</td>
                                <td>{{ $commande->date_commande }}</td>
                                <td>{{ number_format($commande->montant, 2) }} €</td>
                                <td>{{ $commande->statut }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <footer>
    © {{ date('Y') }} Carrefour - Application de gestion des livraisons
</footer>
            </div>

        </div>
    </div>
</body>
</html>