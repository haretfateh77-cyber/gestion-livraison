<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mot de passe oublié</title>
    <link rel="icon" type="image/webp" href="{{ asset('images/OIP (3).webp') }}">

    <style>
        body{
            margin:0;
            height:100vh;
            font-family:Arial, sans-serif;
            background:#f4f6f8;
            display:flex;
            justify-content:center;
            align-items:center;
        }

        .box{
            width:400px;
            background:white;
            padding:40px;
            border-radius:14px;
            box-shadow:0 4px 15px rgba(0,0,0,0.12);
        }

        .logo{
            text-align:center;
            margin-bottom:20px;
        }

        .logo img{
            width:170px;
        }

        h1{
            text-align:center;
            color:#0d1b4c;
            margin-bottom:10px;
        }

        p{
            color:#666;
            font-size:14px;
            text-align:center;
            margin-bottom:25px;
            line-height:22px;
        }

        label{
            display:block;
            margin-bottom:8px;
            font-weight:bold;
        }

        input{
            width:100%;
            padding:12px;
            border:1px solid #ccc;
            border-radius:8px;
            box-sizing:border-box;
            margin-bottom:18px;
        }

        button{
            width:100%;
            padding:13px;
            background:#0d1b4c;
            color:white;
            border:none;
            border-radius:8px;
            font-size:16px;
            font-weight:bold;
            cursor:pointer;
        }

        button:hover{
            background:#162c75;
        }

        .status{
            background:#d4edda;
            color:#155724;
            padding:12px;
            border-radius:8px;
            margin-bottom:15px;
            text-align:center;
        }

        .error{
            color:red;
            font-size:13px;
            margin-top:-12px;
            margin-bottom:12px;
        }

        .retour{
            text-align:center;
            margin-top:20px;
        }

        .retour a{
            text-decoration:none;
            color:#0d1b4c;
            font-weight:bold;
        }

        .retour a:hover{
            text-decoration:underline;
        }

    </style>
</head>

<body>

<div class="box">

    <div class="logo">
        <img src="{{ asset('images/OIP (3).webp') }}" alt="Carrefour">
    </div>

    <h1>Mot de passe oublié</h1>

    <p>
        Saisissez votre adresse e-mail.
        Nous vous enverrons un lien permettant de choisir un nouveau mot de passe.
    </p>

    @if (session('status'))
    <div class="status">
        Un lien de réinitialisation du mot de passe a été envoyé à votre adresse e-mail.
    </div>
@endif
    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <label>Email</label>

        <input
            type="email"
            name="email"
            value="{{ old('email') }}"
            placeholder="Votre adresse e-mail"
            required
        >

        @error('email')
            <div class="error">{{ $message }}</div>
        @enderror

        <button type="submit">
            Envoyer le lien de réinitialisation
        </button>

    </form>

    <div class="retour">
        <a href="{{ route('login') }}">
            ← Retour à la connexion
        </a>
    </div>

</div>

</body>
</html>