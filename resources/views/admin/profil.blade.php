<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Profil administrateur</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="icon" type="image/webp" href="{{ asset('images/OIP (3).webp') }}">
</head>

<body>

<div class="layout">

    <!-- SIDEBAR -->
    <div class="sidebar">

        <div class="logo">
            <img
                src="{{ asset('images/OIP (3).webp') }}"
                alt="Logo Carrefour"
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

            <li style="font-weight:bold;">
                👤 Profil
            </li>

            <li onclick="window.location.href='{{ route('admin.messages.index') }}'">
                💬 Messages
            </li>

        </ul>

        <button onclick="logout()">
            Déconnexion
        </button>

    </div>


    <!-- CONTENU PRINCIPAL -->
    <div class="main">

        <h1>Profil administrateur</h1>


        <!-- MESSAGES -->

        @if(session('password_success'))
            <div class="validation-success">
                {{ session('password_success') }}
            </div>
        @endif

       @if(session('status') && !in_array(session('status'), ['two-factor-authentication-enabled', 'two-factor-authentication-confirmed', 'recovery-codes-generated']))
            <div class="validation-success">
                {{ session('status') }}
            </div>
        @endif

        @if($errors->passwordUpdate->any())
            <div class="validation-errors">

                <strong>Erreur :</strong>

                @foreach($errors->passwordUpdate->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach

            </div>
        @endif


        <!-- INFORMATIONS DU PROFIL -->

        <section class="table">

            <h2>Mes informations</h2>

            <form id="profilForm">

                <input
                    type="text"
                    id="name"
                    value="{{ auth()->user()->name }}"
                    required
                >

                <input
                    type="email"
                    id="email"
                    value="{{ auth()->user()->email }}"
                    required
                >

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


        <!-- MOT DE PASSE -->

        <section class="table">

            <h2>Modifier mon mot de passe</h2>

            <form
                method="POST"
                action="{{ route('admin.profil.password') }}"
            >

                @csrf

                <input
                    type="password"
                    name="current_password"
                    placeholder="Mot de passe actuel"
                    required
                >

                <input
                    type="password"
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

                <input
                    type="password"
                    name="new_password_confirmation"
                    placeholder="Confirmer le nouveau mot de passe"
                    required
                >

                <button type="submit">
                    Modifier le mot de passe
                </button>

            </form>

        </section>


        <!-- DOUBLE AUTHENTIFICATION (section unique) -->

        <section class="table two-factor-section">

            <h2>🔐 Double authentification</h2>

            <p class="two-factor-description">
                Sécurisez votre compte administrateur avec une deuxième étape
                de vérification lors de la connexion.
            </p>

            {{-- Message après activation --}}
            @if (session('status') === 'two-factor-authentication-enabled')
                <div class="two-factor-success">
                    <strong>✓ Double authentification activée</strong>

                    <p>
                        Scannez le QR code ci-dessous avec votre application
                        d'authentification, puis confirmez avec le code affiché.
                    </p>
                </div>
            @endif

            

            {{-- SI 2FA EST DÉJÀ CONFIRMÉ --}}
            @if (auth()->user()->two_factor_confirmed_at)

                <div class="two-factor-active">
                    <strong>✓ Double authentification active</strong>

                    <p>
                        Votre compte administrateur est protégé par une double authentification.
                    </p>
                </div>

                {{-- Désactivation --}}
                <form
                    method="POST"
                    action="{{ url('/user/two-factor-authentication') }}"
                    class="two-factor-form"
                >
                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="danger-button"
                        onclick="return confirm('Voulez-vous vraiment désactiver la double authentification ?')"
                    >
                        Désactiver la double authentification
                    </button>
                </form>

                {{-- Codes de récupération --}}
                <div class="recovery-section">

                    <h3>Codes de récupération</h3>

                    <p>
                        Conservez ces codes dans un endroit sûr. Ils permettent
                        de vous connecter si vous n'avez plus accès à votre
                        application d'authentification.
                    </p>

                    @if (session('recovery_codes'))
    <div class="recovery-codes">
        @foreach (session('recovery_codes') as $code)
            <code>{{ $code }}</code>
        @endforeach
    </div>
@else
    <p><em>Les codes ne sont affichés qu'une seule fois, juste après leur génération. Clique sur "Régénérer" pour en obtenir de nouveaux.</em></p>
@endif

                    <form
                        method="POST"
                        action="{{ url('/user/two-factor-recovery-codes') }}"
                    >
                        @csrf

                        <button type="submit">
                            Régénérer les codes de récupération
                        </button>
                    </form>

                </div>

            @else

                {{-- QR CODE --}}
                @if (auth()->user()->two_factor_secret)

                    <div class="qr-code-container">

                        <h3>1. Scannez le QR code</h3>

                        <p>
                            Ouvrez votre application d'authentification et
                            scannez ce QR code.
                        </p>

                        <div class="qr-code">
                            {!! auth()->user()->twoFactorQrCodeSvg() !!}
                        </div>

                    </div>

                    {{-- Confirmation du code --}}
                    <div class="two-factor-confirm">

                        <h3>2. Confirmez l'activation</h3>

                        <p>
                            Entrez le code à 6 chiffres affiché dans votre
                            application d'authentification.
                        </p>

                        <form
                            method="POST"
                            action="{{ url('/user/confirmed-two-factor-authentication') }}"
                        >
                            @csrf

                            <input
                                type="text"
                                name="code"
                                placeholder="Code à 6 chiffres"
                                inputmode="numeric"
                                autocomplete="one-time-code"
                                maxlength="6"
                                required
                            >

                            <button type="submit">
                                Confirmer la double authentification
                            </button>
                        </form>

                        @if ($errors->any())
                            <div class="two-factor-errors">
                                @foreach ($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif

                    </div>

                @else

                    {{-- PAS ENCORE ACTIVÉ --}}
                    <div class="two-factor-disabled">

                        <strong>⚠ Double authentification non activée</strong>

                        <p>
                            Activez-la pour renforcer la sécurité de votre compte.
                        </p>

                    </div>

                    <form
                        method="POST"
                        action="{{ url('/user/two-factor-authentication') }}"
                    >
                        @csrf

                        <button type="submit">
                            Activer la double authentification
                        </button>
                    </form>

                @endif

            @endif

        </section>


        <!-- FOOTER -->

        <footer>

            © {{ date('Y') }} Carrefour -
            Application de gestion des livraisons

        </footer>

    </div>

</div>


<style>

/* =========================================================
   MESSAGES
========================================================= */

.validation-success {
    background: #e8f7ed;
    color: #176b36;
    border: 1px solid #9bd3ac;
    padding: 12px 15px;
    border-radius: 8px;
    margin-bottom: 20px;
    font-weight: bold;
}

.validation-errors {
    background: #fff0f1;
    color: #a40016;
    border: 1px solid #e0a5ac;
    padding: 12px 15px;
    border-radius: 8px;
    margin-bottom: 20px;
}

.validation-errors p {
    margin: 6px 0;
}


/* =========================================================
   MOT DE PASSE
========================================================= */

.password-rules {
    background: #f4f6f8;
    border-left: 4px solid #0d1b4c;
    padding: 10px 12px;
    margin: -5px 0 15px;
    font-size: 13px;
    color: #555;
    line-height: 20px;
}

.password-rules strong {
    color: #0d1b4c;
}

.password-rules ul {
    margin: 5px 0 0 18px;
    padding: 0;
}

.password-rules li {
    margin-bottom: 2px;
}


/* =========================================================
   DOUBLE AUTHENTIFICATION
========================================================= */

.two-factor-section {
    margin-top: 30px;
}

.two-factor-description {
    margin-top: 10px;
    margin-bottom: 20px;
    color: #555;
    line-height: 1.6;
}

.two-factor-success {
    background: #e8f7ed;
    color: #176b36;
    border: 1px solid #9bd3ac;
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 20px;
}

.two-factor-active {
    background: #e8f7ed;
    border: 1px solid #9bd3ac;
    color: #176b36;
    padding: 15px 18px;
    border-radius: 8px;
    margin-bottom: 20px;
}

.two-factor-active strong {
    display: block;
    margin-bottom: 5px;
}

.two-factor-active p {
    margin: 0;
}

.two-factor-disabled {
    background: #fff8e1;
    border: 1px solid #f0d477;
    color: #765900;
    padding: 15px 18px;
    border-radius: 8px;
    margin-bottom: 20px;
}

.two-factor-disabled strong {
    display: block;
    margin-bottom: 5px;
}

.two-factor-disabled p {
    margin: 0;
}

.two-factor-form {
    margin-top: 10px;
}

.danger-button {
    background: #c62828 !important;
    color: white !important;
    border: none !important;
}

.danger-button:hover {
    background: #a91f1f !important;
}

.qr-code-container {
    text-align: center;
    padding: 20px;
    margin-top: 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
}

.qr-code {
    margin: 20px auto;
    width: 220px;
    height: 220px;
}

.qr-code svg {
    width: 220px;
    height: 220px;
}

.two-factor-confirm {
    margin-top: 25px;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
}

.two-factor-confirm form {
    display: flex;
    gap: 10px;
    align-items: center;
}

.two-factor-confirm input {
    width: 220px;
}

.recovery-section {
    margin-top: 30px;
    padding: 20px;
    background: #f5f6f8;
    border-radius: 8px;
}

.recovery-codes {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 10px;
    margin: 15px 0;
}

.recovery-codes code {
    background: white;
    border: 1px solid #ddd;
    padding: 10px;
    border-radius: 5px;
    font-family: monospace;
}

.two-factor-errors {
    margin-top: 15px;
    background: #fff0f1;
    color: #a40016;
    border: 1px solid #e0a5ac;
    padding: 10px;
    border-radius: 8px;
}

</style>


<script>

/* =========================================================
   DECONNEXION
========================================================= */

function logout() {
    fetch("/logout", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN":
                document
                    .querySelector('meta[name="csrf-token"]')
                    ?.content
        }
    }).then(() => {
        window.location.href = "/login";
    });
}


/* =========================================================
   PROFIL
========================================================= */

document
    .getElementById("profilForm")
    .addEventListener("submit", function(e) {
        e.preventDefault();
        alert("La modification du profil sera enregistrée.");
    });

</script>

@include('partials.accessibility')

</body>
</html>