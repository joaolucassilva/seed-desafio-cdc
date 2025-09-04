# Seed Desafio CDC

Projeto base em Laravel 12 (PHP 8.4) para estudos/desafios. Inclui configuração de CI (GitHub Actions), ambiente Docker via Sail e suíte de testes com PHPUnit.

## Sobre o projeto: Loja de Livros Virtual
Este projeto tem como domínio uma Loja de Livros Virtual (e-commerce focado em livros). Ele serve como base para evoluir funcionalidades como cadastro e consulta de categorias, autores e livros.

- Entidades principais: Categoria, Autor, Livro (a ser implementado conforme evolução).
- Casos de uso iniciais: criar/listar categorias; criar/listar autores; cadastrar/listar livros relacionando autor(es) e categoria(s).
- Padrões adotados: Laravel 12, validações via Form Requests, Actions/Repositories onde fizer sentido, testes de feature e unitários.

Roadmap curto (sugestão):
- [x] Categorias: endpoint para cadastro e listagem.
- [ ] Autores: endpoint para cadastro e listagem.
- [ ] Livros: endpoint para cadastro, listagem e filtros (por categoria/autor, preço, lançamento).
- [ ] Catálogo público e documentação dos endpoints (OpenAPI/Swagger).

## Requisitos
- PHP 8.4+
- Composer 2.x
- Node.js 18+ e NPM (para Vite)
- Opcional: Docker + Docker Compose (para usar o ambiente Sail)

## Começando

Você pode rodar o projeto de duas formas: sem Docker (ambiente local) ou com Docker (Laravel Sail).

### 1) Ambiente local (sem Docker)
1. Clonar o repositório e entrar no diretório:
   - git clone <URL_DO_REPO>
   - cd seed-desafio-cdc
2. Instalar dependências PHP:
   - composer install
3. Copiar o arquivo de ambiente e gerar a chave da aplicação:
   - cp .env.example .env
   - php artisan key:generate
4. Configurar o banco de dados no .env (padrão: MySQL). Se preferir SQLite para desenvolvimento rápido, use por exemplo:
   - DB_CONNECTION=sqlite
   - DB_DATABASE=database/database.sqlite
   - mkdir -p database && touch database/database.sqlite
5. Executar migrações (e seeds, caso existam):
   - php artisan migrate
6. Instalar dependências frontend e rodar o Vite (opcional durante o desenvolvimento):
   - npm install
   - npm run dev
7. Subir o servidor de desenvolvimento do Laravel:
   - php artisan serve

Dica: existe um script de conveniência para desenvolvimento com múltiplos processos:
- composer run dev

### 2) Ambiente com Docker (Laravel Sail)
1. Copiar .env e ajustar variáveis de DB de acordo com docker-compose.yml:
   - cp .env.example .env
   - DB_CONNECTION=mysql
   - DB_HOST=mysql
   - DB_PORT=3306
   - DB_DATABASE=laravel
   - DB_USERNAME=sail
   - DB_PASSWORD=password
2. Subir os containers:
   - docker compose up -d --build
3. Instalar dependências e rodar migrações dentro do container (caso necessário):
   - docker compose exec laravel.test composer install
   - docker compose exec laravel.test php artisan key:generate
   - docker compose exec laravel.test php artisan migrate
4. A aplicação ficará disponível em: http://localhost (porta configurável via APP_PORT no .env)

Observações:
- O arquivo docker-compose.yml usa a imagem base do Sail e sobe um MySQL 8.0.
- O Vite é exposto na porta VITE_PORT (padrão 5173).

## Testes
- Rodar testes localmente:
  - php artisan test
  - ou: composer test
- O pipeline de CI (.github/workflows/laravel.yml) executa os testes em SQLite, gerando cobertura em texto e HTML (tests/report/html-coverage) no ambiente de CI.

Para usar SQLite localmente:
- DB_CONNECTION=sqlite
- DB_DATABASE=database/database.sqlite
- mkdir -p database && touch database/database.sqlite

## Estrutura relevante
- app/…: código da aplicação (Controllers, Models, etc.)
- database/migrations: migrações
- tests/Feature e tests/Unit: testes automatizados
- .github/workflows/laravel.yml: pipeline de CI
- docker-compose.yml e docker/*: configuração Docker/Sail

## Comandos úteis
- Limpar/config cache: php artisan config:clear
- Migrações: php artisan migrate / php artisan migrate:fresh --seed
- Servidor: php artisan serve
- Dev multi-processos (server, queue, logs, vite): composer run dev

## CI (GitHub Actions)
O workflow "Laravel CI" é acionado em pushes e pull requests para a branch main. Ele:
- Instala PHP 8.4 com extensões necessárias
- Instala dependências com Composer
- Prepara ambiente Laravel e banco SQLite
- Executa php artisan test com relatório de cobertura

## Licença
Este projeto é distribuído sob a licença MIT.
