# Collect - Sistema de Gestão

Um sistema simples de gestão feito com Laravel 11. Tem uma área administrativa para gerenciar produtos e um frontend bonito para mostrar eles.

## O que você precisa ter instalado

- XAMPP (com PHP 8.2+)
- Composer 
- Node.js e NPM
- Git

## Como instalar

### 1. Baixe o projeto
```bash
cd C:\xampp\htdocs
git clone <https://github.com/guiacc12/collect>
cd collect
```

### 2. Instale as coisas do PHP e JavaScript
```bash
composer install
npm install
```

### 3. Configure o ambiente
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configure o banco
1. Abra o XAMPP e inicie Apache e MySQL
2. Vá em `http://localhost/phpmyadmin`
3. Crie um banco chamado `collect`
4. No arquivo `.env`, deixe assim:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=collect
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Crie as tabelas e dados iniciais
```bash
php artisan migrate --seed
php artisan storage:link
```

## Como usar

### Para desenvolvimento (mais fácil)
```bash
# Inicie o servidor
php artisan serve

# Em outro terminal
npm run dev
```
Acesse: `http://localhost:8000`

### Para usar o XAMPP
```bash
npm run build
```
Acesse: `http://localhost/collect/public`

## Como acessar

- **Site principal:** `http://localhost:8000`
- **Painel admin:** `http://localhost:8000/admin`
- **phpMyAdmin:** `http://localhost/phpmyadmin`

Os dados de login do admin estão no arquivo `database/seeders/UserSeeder.php`

## O que o sistema faz

### Área administrativa
- Login de usuários
- Gerenciar categorias e produtos  
- Gerenciar colaboradores
- Criar promoções e banners
- Relatórios de vendas

### Site público
- Mostra os produtos
- Página de portfólio
- Design responsivo e bonito

## Se algo der errado

### Erro de permissão no Windows
Clique com botão direito nas pastas `storage` e `bootstrap/cache`, vá em Propriedades > Segurança e dê permissões para o IIS_IUSRS.

### Site não carrega
```bash
php artisan key:generate
php artisan cache:clear
php artisan view:clear
```

### MySQL não conecta
- Veja se o MySQL está rodando no XAMPP
- Confira os dados no arquivo `.env`

## Comandos úteis

```bash
# Limpar tudo
php artisan cache:clear

# Recriar banco do zero
php artisan migrate:fresh --seed

# Ver logs de erro
tail -f storage/logs/laravel.log

