<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Agent DGE - Système de Gestion des Parrainages</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite('resources/css/app.css', 'resources/js/app.js')
    <style>
        body {
            background-color: #f8f9fa;
        }
        .login-container {
            max-width: 450px;
            margin: 100px auto;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
        .card-header {
            background-color: #007bff;
            border-radius: 10px 10px 0 0 !important;
            padding: 20px;
        }
        .logo {
            width: 80px;
            height: 80px;
            margin-bottom: 15px;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
            padding: 10px;
        }
        .btn-primary:hover {
            background-color: #0069d9;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <div class="text-center mb-4 ">
                <img src="{{ asset('images/logo-dge.png') }}" alt="Logo DGE" class="logo mx-auto" onerror="this.src='https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT5k4tMW90wj1_cnResA0X32VrQHIHJaZw2Tw&s'">
                <h2>Direction Générale des Élections</h2>
                <p class="text-muted">Système de Gestion des Parrainages</p>
            </div>
  
            
            <div class="card">
                <div class="card-header bg-primary text-white text-center">
                    <h3 class="mb-0">Connexion Agent DGE</h3>
                </div>
                <div class="card-body p-4">
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('agent_dge.login.submit') }}">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="email">Adresse email</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="password">Mot de passe</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    Se souvenir de moi
                                </label>
                            </div>
                        </div>

                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary btn-lg w-100">
                                Se connecter
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="text-center mt-3">
                <a href="{{ url('/') }}" class="text-decoration-none">
                    <i class="fas fa-arrow-left"></i> Retour à la page d'accueil
                </a>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>