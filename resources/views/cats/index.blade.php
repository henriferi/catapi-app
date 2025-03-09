<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Busca de Gatos</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
</head>
<body>
    <h1>Busque Gatos por Raça</h1>

    <form method="GET" action="{{ route('cats.search') }}">
        <input type="text" id="breed-search" name="race" value="{{ request('race') }}" placeholder="Digite a raça do gato">
        <button type="submit">Buscar</button>
    </form>

    @if(isset($searchedRace))
        <h2>Resultados para a raça: {{ $searchedRace }}</h2>
    @endif

    @if(isset($cats) && count($cats) > 0)
        <div>
            @foreach($cats as $cat)
                <div>
                    <img src="{{ $cat['url'] }}" alt="Gato">
                    <p>Raça: {{ $cat['breeds'][0]['name'] ?? 'Desconhecida' }}</p>
                </div>
            @endforeach
        </div>
    @else
        <p>Não foram encontrados gatos para a raça solicitada.</p>
    @endif

    <script>
        $(document).ready(function() {
            $("#breed-search").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ url('/breeds') }}",
                        data: { term: request.term },
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
