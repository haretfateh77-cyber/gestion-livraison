<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Connexion - Carrefour</title>

    <link rel="icon"
          type="image/webp"
          href="{{ asset('images/OIP (3).webp') }}">

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: Arial, Helvetica, sans-serif;

            background:
                radial-gradient(
                    circle at top right,
                    #174fa5 0%,
                    #0d3d82 35%,
                    #071d50 100%
                );

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 30px 20px;
        }


        /* ==============================
           CONTAINER
        ============================== */

        .login-container {
            width: 100%;
            max-width: 500px;
        }


        /* ==============================
           CARTE
        ============================== */

        .login-box {
            background: #ffffff;

            border-radius: 22px;

            padding: 45px 50px 40px;

            box-shadow:
                0 25px 60px rgba(0, 0, 0, 0.28);

            position: relative;

            overflow: hidden;
        }


        /* Petite barre Carrefour */

        .login-box::before {
            content: "";

            position: absolute;

            top: 0;
            left: 0;

            width: 100%;
            height: 6px;

            background: linear-gradient(
                90deg,
                #e30613 0%,
                #e30613 35%,
                #0046ad 35%,
                #0046ad 100%
            );
        }


        /* ==============================
           LOGO
        ============================== */

        .logo {
            text-align: center;

            margin-bottom: 25px;
        }

        .logo img {
            width: 175px;
            max-width: 100%;

            display: inline-block;

            border-radius: 4px;
        }


        /* ==============================
           TITRE
        ============================== */

        h1 {
            margin: 0;

            text-align: center;

            color: #0d1b4c;

            font-size: 34px;

            font-weight: 700;
        }


        .subtitle {
            text-align: center;

            color: #6b7280;

            font-size: 16px;

            margin: 10px 0 32px;
        }


        /* ==============================
           MESSAGES
        ============================== */

        .status {
            background: #ecfdf5;

            border: 1px solid #86efac;

            color: #166534;

            padding: 12px 15px;

            border-radius: 9px;

            margin-bottom: 20px;

            font-size: 14px;

            text-align: center;
        }


        .error {
            color: #dc2626;

            background: #fef2f2;

            border: 1px solid #fecaca;

            padding: 9px 12px;

            border-radius: 7px;

            font-size: 13px;

            margin-top: -8px;

            margin-bottom: 15px;
        }


        /* ==============================
           FORMULAIRE
        ============================== */

        .form-group {
            margin-bottom: 20px;
        }


        label {
            display: block;

            margin-bottom: 8px;

            font-size: 15px;

            font-weight: 700;

            color: #111827;
        }


        input[type="email"],
        input[type="password"] {
            width: 100%;

            height: 52px;

            padding: 0 16px;

            border: 1px solid #d1d5db;

            border-radius: 10px;

            background: #ffffff;

            color: #111827;

            font-size: 15px;

            outline: none;

            transition: 0.2s ease;
        }


        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #3158d4;

            box-shadow:
                0 0 0 3px rgba(49, 88, 212, 0.12);
        }


        input::placeholder {
            color: #9ca3af;
        }


        /* ==============================
           MOT DE PASSE OUBLIE
        ============================== */

        .forgot-password {
            text-align: right;

            margin-top: -10px;

            margin-bottom: 24px;
        }


        .forgot-password a {
            color: #0d1b4c;

            text-decoration: none;

            font-size: 14px;

            font-weight: 700;
        }


        .forgot-password a:hover {
            text-decoration: underline;
        }


        /* ==============================
           RGPD
        ============================== */

        .privacy-consent {
            margin-bottom: 18px;
        }


        .privacy-checkbox {
            display: flex;

            align-items: flex-start;

            gap: 10px;
        }


        .privacy-checkbox input {
            width: 19px;
            height: 19px;

            margin: 1px 0 0;

            flex-shrink: 0;

            cursor: pointer;
        }


        .privacy-checkbox label {
            margin: 0;

            font-size: 14px;

            line-height: 1.5;

            font-weight: 400;

            color: #374151;

            cursor: pointer;
        }


        /* ==============================
           SE SOUVENIR
        ============================== */

        .remember {
            display: flex;

            align-items: center;

            gap: 9px;

            margin-bottom: 25px;
        }


        .remember input {
            width: 17px;
            height: 17px;

            cursor: pointer;
        }


        .remember label {
            margin: 0;

            font-size: 14px;

            font-weight: 400;

            color: #374151;

            cursor: pointer;
        }


        /* ==============================
           BOUTON
        ============================== */

        button {
            width: 100%;

            height: 52px;

            border: none;

            border-radius: 10px;

            background: #0d1b4c;

            color: white;

            font-size: 16px;

            font-weight: 700;

            cursor: pointer;

            transition:
                background 0.2s ease,
                transform 0.1s ease,
                box-shadow 0.2s ease;
        }


        button:hover {
            background: #16327c;

            box-shadow:
                0 6px 15px rgba(13, 27, 76, 0.25);
        }


        button:active {
            transform: translateY(1px);
        }


        /* ==============================
           FOOTER
        ============================== */

        .footer {
            text-align: center;

            margin-top: 25px;

            font-size: 13px;

            line-height: 1.6;

            color: #6b7280;
        }


        .footer a {
            color: #0d1b4c;

            font-weight: 700;

            text-decoration: none;
        }


        .footer a:hover {
            text-decoration: underline;
        }


        /* ==============================
           TEXTE BAS DE PAGE
        ============================== */

        .copyright {
            text-align: center;

            color: rgba(255, 255, 255, 0.75);

            font-size: 13px;

            margin-top: 20px;
        }


        /* ==============================
           RESPONSIVE
        ============================== */

        @media (max-width: 600px) {

            body {
                padding: 20px 15px;
            }

            .login-box {
                padding: 35px 25px 30px;

                border-radius: 18px;
            }

            h1 {
                font-size: 29px;
            }

            .logo img {
                width: 150px;
            }

        }

    </style>
</head>


<body>

<div class="login-container">

    <div class="login-box">


        <!-- ==============================
             LOGO
        ============================== -->

        <div class="logo">

            <img
                src="{{ asset('images/OIP (3).webp') }}"
                alt="Carrefour"
            >

        </div>


        <!-- ==============================
             TITRE
        ============================== -->

        <h1>
            Connexion
        </h1>

        <p class="subtitle">
            Accédez à votre espace de gestion
        </p>


        <!-- ==============================
             MESSAGE DE SUCCÈS
        ============================== -->

        @if (session('status'))

            <div class="status">

                {{ session('status') }}

            </div>

        @endif


        <!-- ==============================
             FORMULAIRE
        ============================== -->

        <form method="POST" action="{{ route('login') }}">

            @csrf


            <!-- EMAIL -->

            <div class="form-group">

                <label for="email">
                    Email
                </label>

                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Votre adresse email"
                    required
                    autofocus
                    autocomplete="email"
                >

                @error('email')

                    <div class="error">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            <!-- MOT DE PASSE -->

            <div class="form-group">

                <label for="password">
                    Mot de passe
                </label>

                <input
                    id="password"
                    type="password"
                    name="password"
                    placeholder="Votre mot de passe"
                    required
                    autocomplete="current-password"
                >

                @error('password')

                    <div class="error">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            <!-- MOT DE PASSE OUBLIE -->

            @if (Route::has('password.request'))

                <div class="forgot-password">

                    <a href="{{ route('password.request') }}">
                        Mot de passe oublié ?
                    </a>

                </div>

            @endif


            <!-- RGPD -->

            <div class="privacy-consent">

                <div class="privacy-checkbox">

                    <input
                        type="checkbox"
                        name="privacy_consent"
                        id="privacy_consent"
                        value="1"
                        required
                    >

                    <label for="privacy_consent">

                        J'accepte la politique de protection
                        des données à caractère personnel

                    </label>

                </div>

            </div>


            <!-- SE SOUVENIR DE MOI -->

            <div class="remember">

                <input
                    type="checkbox"
                    name="remember"
                    id="remember"
                >

                <label for="remember">

                    Se souvenir de moi

                </label>

            </div>


            <!-- BOUTON -->

            <button type="submit">

                Se connecter

            </button>


            <!-- FOOTER -->

            <div class="footer">

                En vous connectant, vous acceptez notre

                <a href="{{ route('rgpd') }}">
                    Politique de confidentialité
                </a>.

            </div>

        </form>

    </div>


    <!-- COPYRIGHT -->

    <div class="copyright">

        © {{ date('Y') }} Carrefour -
        Application de gestion des livraisons

    </div>

</div>

@include('partials.accessibility')

</body>

</html>