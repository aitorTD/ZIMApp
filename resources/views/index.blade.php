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
    @vite(['resources/css/app.css', 'resources/css/tactical.css'])
    <style>
        .hero-section {
            min-height: 100vh;
            background: 
                radial-gradient(ellipse at 30% 40%, rgba(26, 32, 44, 0.9) 0%, rgba(10, 15, 25, 0.95) 100%),
                url('data:image/svg+xml;utf8,<svg width="100" height="100" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><path d="M0 0h100v100H0z" fill="none"/><path d="M0 0h2v100H0zM20 0h2v100h-2zM40 0h2v100h-2zM60 0h2v100h-2zM80 0h2v100h-2zM100 0h2v100h-2zM0 0v2h100V0zM0 20v2h100v-2zM0 40v2h100v-2zM0 60v2h100v-2zM0 80v2h100v-2zM0 100v2h100v-2z" fill="rgba(226, 176, 7, 0.05)" fill-rule="evenodd"/></svg>');
            background-size: 100% 100%, 50px 50px;
            position: relative;
            overflow: hidden;
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
        }

        .welcome-text {
            font-family: 'Orbitron', sans-serif;
            font-size: clamp(2.5rem, 8vw, 4.5rem);
            font-weight: 700;
            background: linear-gradient(135deg, #e2b007 0%, #f6e05e 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 2px 15px rgba(0, 0, 0, 0.2);
            letter-spacing: 2px;
            line-height: 1.2;
            margin-bottom: 2rem;
            position: relative;
            display: inline-block;
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
            margin-bottom: 3rem;
            max-width: 600px;
            line-height: 1.6;
        }

        .tactical-grid {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                linear-gradient(90deg, rgba(10, 15, 25, 0.8) 1px, transparent 1px) 0 0 / 20px 100%,
                linear-gradient(0deg, rgba(10, 15, 25, 0.8) 1px, transparent 1px) 0 0 / 100% 20px;
            z-index: 1;
            pointer-events: none;
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
        <div class="tactical-grid"></div>
        <div class="tactical-overlay"></div>
        
        <div class="hero-content">
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
