# CatAPI - Aplicativo de Busca e Favoritos de Gatos

## Descrição

CatAPI é um aplicativo web desenvolvido com Laravel e MySQL que permite aos usuários visualizar imagens de gatos aleatórios, buscar por raças específicas e favoritar seus gatos preferidos. Ele consome a API [The Cat API](https://thecatapi.com/) para exibir as informações.

## Funcionalidades

- Exibição de gatos aleatórios ao carregar a página.
- Pesquisa de gatos por raça.
- Login e registro de usuários.
- Sistema de favoritos (usuários logados podem salvar seus gatos preferidos).
- Interface responsiva e intuitiva.

## Tecnologias Utilizadas

- **Backend:** Laravel, MySQL, PHP
- **Frontend:** Blade, HTML, CSS, JavaScript
- **API:** The Cat API

## Instalação

1. Clone o repositório:
   ```sh
   git clone https://github.com/seu-usuario/catapi.git
   ```
2. Instale as dependências do Laravel:
   ```sh
   composer install
   ```
3. Configure o arquivo `.env` com os dados do banco de dados.
4. Execute as migrations para criar o banco de dados:
   ```sh
   php artisan migrate
   ```
5. Inicie o servidor local:
   ```sh
   php artisan serve
   ```
6. Acesse o aplicativo em `http://localhost:8000`

## Como Usar

- Navegue pela página inicial para visualizar gatos aleatórios.
- Use a barra de pesquisa para buscar gatos por raça.
- Crie uma conta ou faça login para salvar seus gatos favoritos.
- Acesse a página de favoritos para ver sua lista salva.

