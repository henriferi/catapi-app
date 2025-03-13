<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Busca de Gatos</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{ asset('css/cats.css') }}">
</head>
<body>
    <h1>Busque Gatos por Raça 🐱</h1>

    @auth
    <a href="{{ route('profile') }}">
        <button>👤 Ver Perfil</button>
    </a>
    @else
    <a href="{{ route('login') }}">
        <button>🔑 Fazer Login</button>
    </a>
    @endauth

    <form method="GET" action="{{ route('cats.search') }}">
        <input type="text" id="breed-search" name="race" value="{{ request('race') }}" placeholder="Digite a raça do gato">
        <button type="submit">Buscar</button>
    </form>

    @if(isset($searchedRace))
    <h2>Resultados para: {{ $searchedRace }}</h2>
    @endif

    <div id="cat-container" class="cat-container">
        @foreach($cats as $cat)
        <div class="cat-card">
            <img src="{{ $cat['url'] }}" alt="Gato">
            <p><strong>Raça:</strong> {{ $cat['breeds'][0]['name'] ?? 'Desconhecida' }}</p>

            @auth
            <form method="POST" action="{{ route('favoritar', $cat['id']) }}">
                @csrf
                <button type="submit">
                    {{ in_array($cat['id'], $favoritos) ? '❤️ Remover Favorito' : '🤍 Adicionar aos Favoritos' }}
                </button>
            </form>
            @else
            <a href="{{ route('login') }}" class="link-favorite">
                <button type="button">Faça login para favoritar</button>
            </a>
            @endauth

        </div>
        @endforeach
    </div>      
</body>
</html>
