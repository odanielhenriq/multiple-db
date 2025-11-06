# Multiple DB — Laravel Multi-Database Challenge

Este projeto foi desenvolvido como desafio técnico proposto por **Kreatives Denken**, para demonstrar o uso de múltiplos bancos de dados em uma aplicação **Laravel**, incluindo integração entre as bases, autenticação e exibição consolidada de dados.

---

## 🚀 Tecnologias Utilizadas

-   **Laravel 12**
-   **PHP 8.2+**
-   **MySQL** (três bancos de dados distintos)
-   **Bootstrap 5** (via Laravel UI)
-   **Eloquent ORM / Query Builder**
-   **Factories & Seeders**
-   **Blade Templates**

---

## 🗄️ Estrutura dos Bancos de Dados

A aplicação utiliza **três bancos distintos**:

| Nome         | Descrição                                                |
| ------------ | -------------------------------------------------------- |
| `office`     | Contém usuários e faturas principais                     |
| `backoffice` | Segunda base com usuários e faturas                      |
| `app`        | Banco principal que consolida informações e autenticação |

Cada banco possui as tabelas `users` e `invoices`.  
O banco `app` é responsável por autenticação e exibição consolidada dos dados vindos dos outros dois.

---

## ⚙️ Configuração do Projeto

### 1 Instalação de dependências

```bash
composer install
npm install
```

### 2 Configuração do .env

```bash
cp .env.example .env
php artisan key:generate
```

Ajuste as três conexões (nomes dos bancos devem existir: office, backoffice, app)

Dica: mantenha SESSION_DRIVER=file e DB_CONNECTION=mysql_app para evitar usar SQLite por engano.

### 3 Crie os bancos:

```bash
CREATE DATABASE office CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE DATABASE backoffice CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE DATABASE app CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 4: foi criado scripts no ocmposer.json para facilitar:

```bash
composer run migrate:all
```

para rodar todas as migrations (visto que as migrations estão separadas por pasta)

```bash
php artisan db:seed
```

para popular os dados (users e invoices de office / backoffice e mesclar tudo no banco app)

### 5: scripts úteis:

```bash
composer run refresh:all:seed
```

para derrubar e criar tudo de novo (rodar rollback, migrations e seed)

```bash
composer run rollback:all
```

para rodar todos rollback

```bash
composer run migrate:all
```

para rodar todas migrations

### 6: RODANDO A APLICAÇÃO:

inicie o backend e o vite:

```bash
php artisan serve
npm run dev
```

### Autenticação:

As rotas de listagem são protegidas (login obrigatório)

Crie um usuário ou use qualquer e-mail das seeders.

Senha padrão dos usuários seed: password.

### Rotas principais:

Usuários mesclados: /users

Invoices mescladas: /invoices
