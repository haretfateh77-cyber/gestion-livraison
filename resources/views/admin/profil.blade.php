<link rel="stylesheet" href="{{ asset('css/style.css') }}">

<div class="sidebar">
    <div class="logo">
        <img src="{{ asset('images/OIP (3).webp') }}" alt="Logo Carrefour">
    </div>

    <ul>
        <li onclick="window.location.href='{{ route('admin.dashboard') }}'">🏠 Tableau de bord</li>
        <li onclick="window.location.href='{{ route('admin.commandes') }}'">📦 Commandes</li>
        <li onclick="window.location.href='{{ route('admin.livraisons') }}'">🚚 Livraisons</li>
        <li onclick="window.location.href='{{ route('admin.utilisateurs') }}'">👥 Utilisateurs</li>
        <li style="font-weight:bold;">👤 Profil</li>
        <li onclick="window.location.href='{{ route('admin.messages.index') }}'">💬 Messages</li>
    </ul>

    <button onclick="logout()">Déconnexion</button>
</div>

<div class="main">

    <h1>Profil administrateur</h1>

    @if(session('password_success'))
        <div class="validation-success">
            {{ session('password_success') }}
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

    <section class="table">
        <h2>Mes informations</h2>

        <form id="profilForm">
            <input type="text" id="name" value="{{ auth()->user()->name }}" required>
            <input type="email" id="email" value="{{ auth()->user()->email }}" required>
            <input type="text" id="role" value="{{ auth()->user()->role }}" disabled>
            <button type="submit">Modifier mon profil</button>
        </form>
    </section>

    <section class="table">
        <h2>Modifier mon mot de passe</h2>

        <form method="POST" action="{{ route('admin.profil.password') }}">
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
                <strong>Le nouveau mot de passe doit contenir :</strong>
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

            <button type="submit">Modifier le mot de passe</button>
        </form>
    </section>

    <section class="table accessibility-section">
        <h2>♿ Accessibilité</h2>

        <p class="accessibility-description">
            Personnalisez l'affichage de l'application selon vos besoins.
        </p>

        <div class="accessibility-option">
            <div>
                <strong>Mode contraste élevé</strong>
                <p>Augmenter le contraste pour faciliter la lecture de l'application.</p>
            </div>
            <button type="button" id="contrastButton" onclick="toggleContrast()">Activer</button>
        </div>

        <div class="accessibility-option">
            <div>
                <strong>🔠 Taille du texte</strong>
                <p>Modifiez la taille du texte pour améliorer la lisibilité de l'application.</p>
            </div>

            <div class="text-size-buttons">
                <button type="button" onclick="setTextSize('small')" id="textSmall">A−</button>
                <button type="button" onclick="setTextSize('normal')" id="textNormal">A</button>
                <button type="button" onclick="setTextSize('large')" id="textLarge">A+</button>
            </div>
        </div>
    </section>

    <footer>
        © {{ date('Y') }} Carrefour - Application de gestion des livraisons
    </footer>
</div>

<style>
.validation-success {
    background:#e8f7ed;
    color:#176b36;
    border:1px solid #9bd3ac;
    padding:12px 15px;
    border-radius:8px;
    margin-bottom:20px;
    font-weight:bold;
}

.validation-errors {
    background:#fff0f1;
    color:#a40016;
    border:1px solid #e0a5ac;
    padding:12px 15px;
    border-radius:8px;
    margin-bottom:20px;
}

.validation-errors p {
    margin:6px 0;
}

.password-rules {
    background:#f4f6f8;
    border-left:4px solid #0d1b4c;
    padding:10px 12px;
    margin:-5px 0 15px;
    font-size:13px;
    color:#555;
    line-height:20px;
}

.password-rules strong {
    color:#0d1b4c;
}

.password-rules ul {
    margin:5px 0 0 18px;
    padding:0;
}

.password-rules li {
    margin-bottom:2px;
}

.accessibility-section { margin-top:30px; }

.accessibility-description {
    margin-top:10px;
    margin-bottom:20px;
    color:#555;
}

.accessibility-option {
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:20px;
    padding:15px;
    margin-top:15px;
    border:1px solid #ddd;
    border-radius:8px;
    background:#f8f9fa;
}

.accessibility-option p {
    margin-top:6px;
    color:#666;
}

#contrastButton { min-width:120px; }

.text-size-buttons {
    display:flex;
    gap:8px;
}

.text-size-buttons button {
    min-width:50px;
    min-height:44px;
    font-size:18px;
    font-weight:bold;
}

/* Contraste élevé */
body.contrast-mode {
    background:#000 !important;
    color:#fff !important;
}

body.contrast-mode .main {
    background:#000 !important;
    color:#fff !important;
}

body.contrast-mode .table {
    background:#111 !important;
    color:#fff !important;
    border:2px solid #fff;
}

body.contrast-mode h1,
body.contrast-mode h2,
body.contrast-mode h3,
body.contrast-mode strong,
body.contrast-mode p,
body.contrast-mode label,
body.contrast-mode li {
    color:#fff !important;
}

body.contrast-mode input,
body.contrast-mode select {
    background:#000 !important;
    color:#fff !important;
    border:2px solid #fff !important;
}

body.contrast-mode input::placeholder {
    color:#ddd !important;
}

body.contrast-mode button {
    background:#fff !important;
    color:#000 !important;
    border:2px solid #fff !important;
}

body.contrast-mode .accessibility-option,
body.contrast-mode .password-rules,
body.contrast-mode .validation-success,
body.contrast-mode .validation-errors {
    background:#000 !important;
    color:#fff !important;
    border:2px solid #fff !important;
}

body.contrast-mode .password-rules strong {
    color:#fff !important;
}

body.contrast-mode .sidebar {
    background:#000 !important;
    color:#fff !important;
    border-right:2px solid #fff;
}

body.contrast-mode .sidebar li {
    color:#fff !important;
}

body.contrast-mode footer {
    color:#fff !important;
    border-top:2px solid #fff !important;
}

/* Taille du texte */
body.text-size-small { font-size:14px; }
body.text-size-normal { font-size:16px; }
body.text-size-large { font-size:19px; }

body.text-size-small h1,
body.text-size-normal h1,
body.text-size-large h1 { font-size:2em; }

body.text-size-small h2,
body.text-size-normal h2,
body.text-size-large h2 { font-size:1.5em; }

body.text-size-small input,
body.text-size-small button,
body.text-size-small select,
body.text-size-large input,
body.text-size-large button,
body.text-size-large select { font-size:1em; }
</style>

<script>
function applyContrastMode() {
    const enabled = localStorage.getItem('contrastMode') === 'enabled';
    document.body.classList.toggle('contrast-mode', enabled);
    updateContrastButton();
}

function toggleContrast() {
    const enabled = !document.body.classList.contains('contrast-mode');
    localStorage.setItem('contrastMode', enabled ? 'enabled' : 'disabled');
    applyContrastMode();
}

function updateContrastButton() {
    const button = document.getElementById('contrastButton');
    if (button) {
        button.textContent =
            document.body.classList.contains('contrast-mode')
                ? '✓ Activé'
                : 'Activer';
    }
}

function setTextSize(size) {
    document.body.classList.remove(
        'text-size-small',
        'text-size-normal',
        'text-size-large'
    );

    document.body.classList.add('text-size-' + size);
    localStorage.setItem('textSize', size);
    updateTextSizeButtons();
}

function updateTextSizeButtons() {
    const size = localStorage.getItem('textSize') || 'normal';

    const buttons = {
        small: document.getElementById('textSmall'),
        normal: document.getElementById('textNormal'),
        large: document.getElementById('textLarge')
    };

    Object.values(buttons).forEach(button => {
        if (button) button.style.outline = 'none';
    });

    if (buttons[size]) {
        buttons[size].style.outline = '3px solid #ffcc00';
    }
}

document.addEventListener('DOMContentLoaded', function () {
    applyContrastMode();
    setTextSize(localStorage.getItem('textSize') || 'normal');
});
</script>