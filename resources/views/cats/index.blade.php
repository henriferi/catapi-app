<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Busca de Gatos</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }

        .cat-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }

        .cat-card {
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 15px;
            width: 200px;
            text-align: center;
        }

        .cat-card img {
            width: 100%;
            border-radius: 10px;
        }

        button {
            background-color: #ff4081;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            border-radius: 5px;
        }

        button:hover {
            background-color: #e91e63;
        }
    </style>
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

    @if(isset($cats) && count($cats) > 0)
    <div class="cat-container">
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
            <p><a href="{{ route('login') }}">Faça login para favoritar</a></p>
            @endauth

        </div>
        @endforeach
    </div>
    @else
    <p>Nenhum gato encontrado para a raça pesquisada.</p>
    @endif

    <script>
        $(document).ready(function() {
            $("#breed-search").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ url('/breeds') }}",
                        data: {
                            term: request.term
                        },
                        dataType: "json",
                        success: function(data) {
                            response(data);
                        }
                    });
                },
                minLength: 1
            });
        });
    </script>
</body>

</html>