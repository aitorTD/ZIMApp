<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Airsoft ZIMA - Welcome</title>

    <!-- Preload Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet"></noscript>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/css/fonts.css'])
    <style>
        .hero-section {
            min-height: 100vh;
            background: 
                linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.5)),
                url('/images/bg.jpg') no-repeat center center fixed;
            background-size: cover;
            position: relative;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            text-align: center;
            padding: 2rem;
            max-width: 800px;
            margin: 0 auto;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 100%;
        }
        
        .logo-container {
            margin: 0 auto 0.25rem;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: flex-end;
            padding-bottom: 0;
        }

        .logo-header {
            display: block;
            margin: 0 auto;
        }

        .welcome-text {
            font-family: 'Iori', sans-serif;
            font-size: clamp(2.5rem, 10vw, 5rem);
            font-weight: bold;
            color: white;
            text-shadow: 0 2px 15px rgba(0, 0, 0, 0.5);
            letter-spacing: 1px;
            line-height: 1;
            margin: 0.25rem 0 1.5rem 0.2rem; /* Added 0.2rem (2mm) left margin */
            position: relative;
            display: inline-block;
            padding-top: 0;
            text-transform: uppercase;
        }

        .welcome-text::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 3px;
            background: linear-gradient(90deg, transparent, #e2b007, transparent);
        }

        .subtitle {
            font-size: 1.25rem;
            color: #a0aec0;
            margin: 0 0 3rem 0.1rem; /* Added 0.1rem (1mm) left margin */
            max-width: 600px;
            line-height: 1.6;
        }


        .tactical-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 30%, rgba(226, 176, 7, 0.05) 0%, transparent 15%),
                radial-gradient(circle at 80% 70%, rgba(226, 176, 7, 0.05) 0%, transparent 15%);
            z-index: 1;
            pointer-events: none;
        }

        .nav-links {
            margin-top: 3rem;
            display: flex;
            gap: 1.5rem;
        }

        .nav-link {
            font-family: 'Orbitron', sans-serif;
            font-weight: 600;
            letter-spacing: 1px;
            padding: 0.75rem 2rem;
            border-radius: 4px;
            transition: all 0.3s ease;
            text-transform: uppercase;
            font-size: 0.875rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, #e2b007 0%, #d69e11 100%);
            color: #1a202c;
            border: 1px solid #d69e11;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(214, 158, 17, 0.3);
        }

        .btn-outline {
            border: 1px solid #4a5568;
            color: #cbd5e0;
        }

        .btn-outline:hover {
            border-color: #e2b007;
            color: #e2b007;
            transform: translateY(-2px);
        }

        @media (max-width: 640px) {
            .welcome-text {
                font-size: 2.5rem;
            }
            
            .subtitle {
                font-size: 1.1rem;
            }
            
            .nav-links {
                flex-direction: column;
                width: 100%;
                max-width: 300px;
                margin-left: auto;
                margin-right: auto;
            }
        }
    </style>
</head>
<body class="bg-tactical-bg text-tactical-text font-sans antialiased">
    <div class="hero-section">
        <div class="tactical-overlay"></div>
        
        <div class="hero-content">
            <div class="logo-container">
                <img 
                    src="{{ asset('images/logo.svg') }}" 
                    alt="ZIMA Logo" 
                    style="height: 18rem; width: auto; max-width: 90%; filter: brightness(0) invert(1);"
                    class="logo-header"
                >
            </div>
            <h1 class="welcome-text">ZIMA</h1>
            <p class="subtitle">Pium pium pium pium pium</p>
            
            <div class="nav-links">
                @auth
                    <a href="{{ route('dashboard') }}" class="nav-link btn-primary">
                        <i class="fas fa-door-open mr-2"></i> Acceder al Cuartel
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="nav-link btn-outline">
                            <i class="fas fa-sign-out-alt mr-2"></i> Abandonar Base
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="nav-link btn-primary">
                        <i class="fas fa-user-secret mr-2"></i> {{ __('Acceso de Operador') }}
                    </a>
                    @auth
                        @can('register-candidate')
                            <a href="{{ route('candidates.register') }}" class="nav-link btn-outline">
                                <i class="fas fa-user-plus mr-2"></i> {{ __('Registrar Recluta') }}
                            </a>
                        @endcan
                    @endauth
                @endauth
            </div>
        </div>
    </div>
    
    @vite('resources/js/app.js')
</body>
</html>
