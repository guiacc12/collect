# Collect - Sistema de Gestão

Sistema de gestão desenvolvido em Laravel 11 com interface administrativa e frontend para exibição de produtos e portfólio.

## 📋 Pré-requisitos

Antes de começar, certifique-se de ter instalado:

- **XAMPP** (Apache, MySQL, PHP 8.2+)
- **Composer** (gerenciador de dependências PHP)
- **Node.js 18+ e NPM** (para assets frontend)
- **Git** (para clonar o repositório)

## 🚀 Instalação

### 1. Clone o repositório
```bash
# Clone o repositório na pasta htdocs do XAMPP
cd C:\xampp\htdocs
git clone <https://github.com/guiacc12/collect>
cd collect
```

### 2. Instale as dependências PHP
```bash
composer install
```

### 3. Instale as dependências Node.js
```bash
npm install
```

### 4. Configure o ambiente
```bash
# Copie o arquivo de exemplo de configuração
cp .env.example .env

# Gere a chave da aplicação
php artisan key:generate
```

### 5. Configure o banco de dados MySQL

#### 5.1. Inicie o XAMPP
- Abra o **XAMPP Control Panel**
- Inicie os serviços **Apache** e **MySQL**

#### 5.2. Crie o banco de dados
- Acesse `http://localhost/phpmyadmin`
- Clique em **"Novo"** para criar um novo banco
- Nome do banco: `collect`
- Collation: `utf8mb4_unicode_ci`
- Clique em **"Criar"**

#### 5.3. Configure o arquivo .env
Edite o arquivo `.env` com as configurações do MySQL:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=collect
DB_USERNAME=root
DB_PASSWORD=
```

### 6. Execute as migrações
```bash
# Execute as migrações para criar as tabelas
php artisan migrate

# Execute os seeders (dados iniciais)
php artisan db:seed
```

### 7. Compile os assets
```bash
# Para desenvolvimento
npm run dev

# Para produção
npm run build
```

### 8. Configure o storage
```bash
php artisan storage:link
```

## 🏃‍♂️ Executando o Projeto

### Opção 1: Usando o servidor do Laravel (Recomendado para desenvolvimento)
```bash
# Inicie o servidor de desenvolvimento
php artisan serve

# Em outro terminal, compile os assets em modo watch
npm run dev
```

O projeto estará disponível em: `http://localhost:8000`

### Opção 2: Usando o Apache do XAMPP
```bash
# Compile os assets para produção
npm run build

# Acesse diretamente pelo Apache
# http://localhost/collect/public
```

### Comando de desenvolvimento completo
```bash
# Executa servidor, queue, logs e vite simultaneamente
composer run dev
```

## 📁 Estrutura do Projeto

```
collect/
├── app/
│   ├── Http/Controllers/     # Controladores
│   │   ├── Backend/         # Controladores do painel admin
│   │   └── Frontend/        # Controladores do frontend
│   ├── Models/              # Modelos Eloquent
│   ├── DataTables/          # Configurações do DataTables
│   └── Traits/              # Traits reutilizáveis
├── database/
│   ├── migrations/          # Migrações do banco
│   └── seeders/            # Seeders para dados iniciais
├── resources/views/
│   ├── admin/              # Views do painel administrativo
│   ├── front-end/          # Views do frontend
│   └── layouts/            # Layouts base
├── public/
│   ├── uploads/            # Arquivos enviados pelos usuários
│   └── backend/assets/     # Assets do painel admin
└── routes/
    ├── web.php             # Rotas principais
    └── web/                # Rotas organizadas por módulo
```

## 🔐 Acesso ao Sistema

### Painel Administrativo
- **URL (Laravel serve):** `http://localhost:8000/admin`
- **URL (XAMPP Apache):** `http://localhost/collect/public/admin`
- **Usuário padrão:** Verifique o seeder `UserSeeder.php`

### Frontend
- **URL (Laravel serve):** `http://localhost:8000`
- **URL (XAMPP Apache):** `http://localhost/collect/public`
- Página inicial com produtos e portfólio

### phpMyAdmin
- **URL:** `http://localhost/phpmyadmin`
- **Usuário:** `root`
- **Senha:** (vazio por padrão)

## 🛠️ Funcionalidades

### Painel Administrativo
- ✅ Autenticação de usuários
- ✅ Gestão de categorias
- ✅ Gestão de produtos
- ✅ Gestão de colaboradores
- ✅ Gestão de promoções
- ✅ Gestão de sliders
- ✅ Relatórios de vendas
- ✅ Perfil do usuário

### Frontend
- ✅ Página inicial
- ✅ Catálogo de produtos
- ✅ Página de portfólio
- ✅ Visualização de produtos

## 📦 Dependências Principais

### Backend (PHP)
- **Laravel 11** - Framework PHP
- **Laravel Breeze** - Autenticação
- **Yajra DataTables** - Tabelas interativas
- **Toastr** - Notificações

### Frontend (JavaScript/CSS)
- **Vite** - Build tool
- **Tailwind CSS** - Framework CSS
- **Alpine.js** - Framework JavaScript
- **GSAP** - Animações

## 🔧 Comandos Úteis

```bash
# Limpar cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Recriar banco de dados
php artisan migrate:fresh --seed

# Executar testes
php artisan test

# Gerar controller
php artisan make:controller NomeController

# Gerar model
php artisan make:model NomeModel -m

# Gerar migration
php artisan make:migration nome_da_migration
```

## 🌐 Configuração do XAMPP

### Apache (XAMPP)
Para usar o Apache do XAMPP, certifique-se de que:

1. **mod_rewrite está habilitado:**
   - Abra o arquivo `C:\xampp\apache\conf\httpd.conf`
   - Procure por `#LoadModule rewrite_module modules/mod_rewrite.so`
   - Remova o `#` para descomentar a linha
   - Reinicie o Apache

2. **Configuração do Virtual Host (Opcional):**
   - Adicione no arquivo `C:\xampp\apache\conf\extra\httpd-vhosts.conf`:
   ```apache
   <VirtualHost *:80>
       DocumentRoot "C:/xampp/htdocs/collect/public"
       ServerName collect.local
       <Directory "C:/xampp/htdocs/collect/public">
           AllowOverride All
           Require all granted
       </Directory>
   </VirtualHost>
   ```
   - Adicione `127.0.0.1 collect.local` no arquivo `C:\Windows\System32\drivers\etc\hosts`
   - Reinicie o Apache

### MySQL (XAMPP)
- **Porta padrão:** 3306
- **Usuário padrão:** root
- **Senha padrão:** (vazio)
- **phpMyAdmin:** `http://localhost/phpmyadmin`

## 🐛 Solução de Problemas

### Erro de permissões (Windows/XAMPP)
```bash
# Certifique-se de que o Apache tem permissões de escrita nas pastas
# Clique com botão direito nas pastas storage e bootstrap/cache
# Propriedades > Segurança > Editar > Adicionar > IIS_IUSRS
# Conceda permissões de "Controle total"
```

### Erro de chave da aplicação
```bash
php artisan key:generate
```

### Problemas com assets
```bash
npm run build
php artisan view:clear
```

### Erro de conexão com MySQL
- Verifique se o MySQL está rodando no XAMPP Control Panel
- Confirme as credenciais no arquivo `.env`
- Teste a conexão: `php artisan tinker` → `DB::connection()->getPdo();`

### Erro 500 - Internal Server Error
```bash
# Verifique os logs
tail -f storage/logs/laravel.log

# Limpe todos os caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

### Problemas com mod_rewrite
- Certifique-se de que o mod_rewrite está habilitado no Apache
- Verifique se o arquivo `.htaccess` existe na pasta `public/`
- Para XAMPP, use `http://localhost/collect/public` se mod_rewrite não estiver funcionando

## 📝 Licença

Este projeto está sob a licença MIT. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.

## 👥 Contribuição

1. Faça um fork do projeto
2. Crie uma branch para sua feature (`git checkout -b feature/AmazingFeature`)
3. Commit suas mudanças (`git commit -m 'Add some AmazingFeature'`)
4. Push para a branch (`git push origin feature/AmazingFeature`)
5. Abra um Pull Request

## 📞 Suporte

Para suporte, entre em contato através dos canais oficiais do projeto.
