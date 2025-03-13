<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <title>Login</title>
</head>

<body>
    <div class="container">
        <h2>Login</h2>
        <form class="form-login" method="POST" action="{{ route('login') }}">
            @csrf
            <div>
                <label for="cpf">CPF</label>
                <input type="text" name="cpf" id="cpf" value="{{ old('cpf') }}" required>
                @error('cpf')
                <div>{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="password">Senha</label>
                <input type="password" name="password" requi red>
                @error('password')
                <div>{{ $message }}</div>
                @enderror
            </div>

            <button type="submit">Login</button>
        </form>

        <div class="div-register">
            <p>Ainda não tem uma conta? <a href="{{ route('register') }}"><button type="button">Registrar</button></a></p>
        </div>
    </div>
</body>

<script>
    document.getElementById('cpf').addEventListener('input', function(e) {
        e.target.value = e.target.value.replace(/\D/g, '');
    });
</script>

</html>