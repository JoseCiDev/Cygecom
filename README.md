## GECOM - Gerenciador de cotações e compras

### Instalação:

-   Clonar o projeto para pasta projects do Docker
-   Rodar docker compose up na pasta docker-sm (Necessário container php8-projects e db-mysql-8.0)
    (Para acessar o banco de dados é pela porta 3307)
-   Ir para a branch develop - git checkout
-   Rodar composer install
-   Criar arquivo .env a partir de env.example
-   Adicionar na pasta public as pastas font e img do flat
-   Criar banco de dados com nome gerenciador_compras
-   Rodar php artisan migrate
-   Rodar php artisan db:seed
