<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    <title>Cadastro</title>
</head>
<body>
    <div class="container">
        <h2>Cadastro de Usuário</h2>

        <form class="form-register" method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <label for="name">Nome:</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                @error('name')
                    <p>{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <p>{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="phone">Telefone:</label>
                <input type="text" id="phone" name="phone" value="{{ old('phone') }}" required>
                @error('phone')
                    <p>{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="cpf">CPF:</label>
                <input type="text" id="cpf" name="cpf" value="{{ old('cpf') }}" required>
                @error('cpf')
                    <p>{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="gender">Sexo:</label>
                <select id="gender" name="gender">
                    <option value="">Selecione</option>
                    <option value="masculino" {{ old('gender') == 'masculino' ? 'selected' : '' }}>Masculino</option>
                    <option value="feminino" {{ old('gender') == 'feminino' ? 'selected' : '' }}>Feminino</option>
                    <option value="outro" {{ old('gender') == 'outro' ? 'selected' : '' }}>Prefiro não falar</option>
                </select>
                @error('gender')
                    <p>{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password">Senha:</label>
                <input type="password" id="password" name="password" required>
                @error('password')
                    <p>{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation">Confirmar Senha:</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required>
                @error('password_confirmation')
                    <p>{{ $message }}</p>
                @enderror
            </div>

            <div>
                <button type="submit">Cadastrar</button>
            </div>

            <div class="div-login">
                <p>Já tem uma conta? <a href="{{ route('login') }}"><button type="button">Faça login</button></a></p>
            </div>
        </form>
    </div>
</body>
</html>
