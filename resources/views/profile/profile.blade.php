<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
</head>
<body>
    <h1>Bem-vindo ao seu perfil, {{ Auth::user()->name }}!</h1>

    <h2>Gatos Favoritos</h2>
    <ul>
        @foreach ($gatosFavoritos as $gato)
            <li>
                <img src="{{ $gato['url'] }}" alt="{{ $gato['breeds'][0]['name'] ?? 'Desconhecida' }}" style="max-width:200px;">
                <p>Raça: {{ $gato['breeds'][0]['name'] ?? 'Desconhecida' }}</p>
            </li>
        @endforeach
    </ul>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>
