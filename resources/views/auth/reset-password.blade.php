<style>
    body {
        margin: 0;
        height: 100vh;
        font-family: Arial, sans-serif;
        background: #f4f6f8;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .box {
        width: 420px;
        background: white;
        padding: 40px;
        border-radius: 14px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.12);
    }

    .logo {
        text-align: center;
        margin-bottom: 20px;
    }

    .logo img {
        width: 170px;
    }

    h1 {
        text-align: center;
        color: #0d1b4c;
        margin-bottom: 10px;
    }

    p {
        text-align: center;
        color: #666;
        margin-bottom: 25px;
        line-height: 22px;
    }

    label {
        display: block;
        margin-bottom: 6px;
        font-weight: bold;
    }

    input {
        width: 100%;
        padding: 12px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 8px;
        box-sizing: border-box;
    }

    button {
        width: 100%;
        padding: 13px;
        background: #0d1b4c;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
    }

    button:hover {
        background: #162c75;
    }

    .error {
        color: #b00020;
        background: #fff0f1;
        border: 1px solid #f1b5bb;
        padding: 9px 10px;
        border-radius: 6px;
        font-size: 13px;
        margin-bottom: 12px;
        line-height: 18px;
    }

    .password-rules {
        background: #f4f6f8;
        border-left: 4px solid #0d1b4c;
        padding: 10px 12px;
        margin-top: -5px;
        margin-bottom: 15px;
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

    .retour {
        text-align: center;
        margin-top: 20px;
    }

    .retour a {
        color: #0d1b4c;
        text-decoration: none;
        font-weight: bold;
    }

    .retour a:hover {
        text-decoration: underline;
    }
</style>


<div class="box">

    <div class="logo">
        <img src="{{ asset('images/OIP (3).webp') }}" alt="Carrefour">
    </div>

    <h1>Nouveau mot de passe</h1>

    <p>
        Choisissez un nouveau mot de passe pour accéder à votre espace de gestion.
    </p>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <input
            type="hidden"
            name="token"
            value="{{ request()->route('token') }}"
        >

        <label>Email</label>

        <input
            type="email"
            name="email"
            value="{{ old('email', request('email')) }}"
            required
            autofocus
        >

        @error('email')
            <div class="error">{{ $message }}</div>
        @enderror


        <label>Nouveau mot de passe</label>

        <input
            type="password"
            name="password"
            placeholder="********"
            required
        >

        <div class="password-rules">
            <strong>Le mot de passe doit contenir :</strong>

            <ul>
                <li>Au moins 8 caractères</li>
                <li>Au moins une majuscule</li>
                <li>Au moins une minuscule</li>
                <li>Au moins un chiffre</li>
                <li>Au moins un caractère spécial</li>
            </ul>
        </div>

        @error('password')
            <div class="error">
                {{ $message }}
            </div>
        @enderror


        <label>Confirmer le mot de passe</label>

        <input
            type="password"
            name="password_confirmation"
            placeholder="********"
            required
        >

        @error('password_confirmation')
            <div class="error">
                {{ $message }}
            </div>
        @enderror


        <button type="submit">
            Réinitialiser le mot de passe
        </button>

    </form>

    <div class="retour">
        <a href="{{ route('login') }}">
            ← Retour à la connexion
        </a>
    </div>

</div>