<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
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

        .login-box{
            width:380px;
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
            margin-bottom:5px;
            color:#0d1b4c;
        }

        .subtitle{
            text-align:center;
            color:#666;
            margin-bottom:25px;
        }

        label{
            font-weight:bold;
            margin-bottom:6px;
            display:block;
        }

        input[type="email"],
        input[type="password"]{
            width:100%;
            padding:12px;
            margin-bottom:15px;
            border:1px solid #ccc;
            border-radius:8px;
            box-sizing:border-box;
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

        .remember{
            display:flex;
            align-items:center;
            margin-bottom:20px;
            font-size:14px;
        }

        .remember input{
            margin-right:8px;
        }

        .error{
            color:red;
            font-size:13px;
            margin-bottom:10px;
        }

        .status{
            color:green;
            text-align:center;
            margin-bottom:15px;
        }
    </style>
</head>

<body>

<div class="login-box">

    <div class="logo">
        <img src="{{ asset('images/OIP (3).webp') }}" alt="Carrefour">
    </div>

    <h1>Connexion</h1>
    <p class="subtitle">Accédez à votre espace de gestion</p>

    @if (session('status'))
        <div class="status">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <label for="email">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Votre email" required autofocus>

        @error('email')
            <div class="error">{{ $message }}</div>
        @enderror

        <label for="password">Mot de passe</label>
        <input id="password" type="password" name="password" placeholder="Votre mot de passe" required>

        @error('password')
            <div class="error">{{ $message }}</div>
        @enderror

        <div class="remember">
            <input type="checkbox" name="remember" id="remember">
            <label for="remember" style="margin:0;font-weight:normal;">Se souvenir de moi</label>
        </div>

        <button type="submit">Se connecter</button>
        <p style="margin-top:20px; text-align:center; font-size:13px; color:#666;">
    En vous connectant, vous acceptez notre
    <a href="{{ route('rgpd') }}" style="color:#0d1b4c; font-weight:bold;">
        Politique de confidentialité
    </a>.
</p>
    </form>

</div>

</body>
</html>