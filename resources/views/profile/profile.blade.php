<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <title>Perfil</title>
    <script>
        function toggleEditForm() {
            var form = document.getElementById('edit-profile-form');
            var btn = document.getElementById('edit-button');

            if (form.style.display === 'none' || form.style.display === '') {
                form.style.display = 'block';
                btn.style.display = 'none'; 
            } else {
                form.style.display = 'none';
                btn.style.display = 'block'; 
            }
        }
    </script>
</head>

<body>
    <h1>Bem-vindo ao seu perfil, {{ Auth::user()->name }}!</h1>

    <a href="/"><button class="pag-initial-button">Página inicial</button></a>

    <h2>Seus Dados</h2>
    <p><strong>Nome:</strong> {{ Auth::user()->name }}</p>
    <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
    <p><strong>Número:</strong> {{ Auth::user()->phone ?? 'Não informado' }}</p>

    <button id="edit-button" onclick="toggleEditForm()">Editar Perfil</button>

    @if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
    @endif
    @if ($errors->any())
    <div style="color: red;">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form id="edit-profile-form" action="{{ route('profile.update') }}" method="POST" style="display: none;">
        @csrf
        @method('PUT')

        <label for="name">Nome:</label>
        <input type="text" id="name" name="name" value="{{ Auth::user()->name }}" required>

        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" value="{{ Auth::user()->email }}" required>

        <label for="phone">Número de telefone:</label>
        <input type="text" id="phone" name="phone" value="{{ Auth::user()->phone ?? '' }}">

        <label for="password">Nova Senha (opcional):</label>
        <input type="password" id="password" name="password">

        <label for="password_confirmation">Confirme a Nova Senha:</label>
        <input type="password" id="password_confirmation" name="password_confirmation">

        <button type="submit" style="background-color:#0001fc;">Salvar Alterações</button>
        <button type="button" style="background-color:red" onclick="toggleEditForm()">Cancelar</button>
    </form>

    <h2>Gatos Favoritos</h2>
    <div class="div-favorites">
        <ul>
            @foreach ($gatosFavoritos as $gato)
            <li>
                <img src="{{ $gato['url'] }}" alt="{{ $gato['breeds'][0]['name'] ?? 'Desconhecida' }}">
                <p>Raça: {{ $gato['breeds'][0]['name'] ?? 'Desconhecida' }}</p>
            </li>
            @endforeach
        </ul>
    </div>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>

</html>