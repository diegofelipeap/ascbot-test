# API de Livros e Usuários - Laravel (ASCBOT)

Este projeto é uma API desenvolvida em Laravel para gerenciar livros e usuários, com funcionalidades de autenticação, operações CRUD, gerenciamento de favoritos, validação de dados, jobs assíncronos e uma documentação interativa usando Swagger. O projeto tem finalidade de avaliação técnica.

## 🚀 **Funcionalidades Principais**
- Autenticação de usuários (registro, login, logout) com JWT.
- Operações CRUD para livros.
- Sistema de favoritos, onde usuários podem adicionar e remover livros dos seus favoritos.
- Validação de dados de entrada para assegurar que as requisições sejam processadas corretamente.
- Job assíncrono para registrar logs após a criação de livros.
- Documentação interativa gerada com Swagger.

---

## 📦 **Instalação e Configuração**

### Pré-requisitos:
- **PHP**: Versão 8.0 ou superior.
- **Composer**: Gerenciador de dependências para PHP.
- **Laravel**: Framework PHP.
- **XAMPP ou WAMP**: Para rodar o servidor localmente (se necessário).

### Passos para Instalação:

1. **Clonar o Repositório**:

   ```bash
   git clone https://github.com/seu-usuario/api-livros.git
   cd api-livros
   ```

2. **Instalar Dependências**:

   Execute o comando abaixo para instalar todas as dependências do Laravel:

   ```bash
   composer install
   ```

3. **Configurar o Arquivo `.env`**:

   Copie o arquivo `.env.example` para `.env`:

   ```bash
   cp .env.example .env
   ```

   Abra o arquivo `.env` e configure as seguintes variáveis:

   ```bash
   APP_NAME=API de Livros
   APP_URL=http://127.0.0.1:8000

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nome_do_banco
   DB_USERNAME=seu_usuario
   DB_PASSWORD=sua_senha

   JWT_SECRET=gerar_token_com_o_comando_php_artisan_jwt_secret
   ```

4. **Gerar a Chave JWT**:

   Execute o comando abaixo para gerar a chave JWT:

   ```bash
   php artisan jwt:secret
   ```

5. **Executar as Migrações**:

   Rode as migrações para criar as tabelas no banco de dados:

   ```bash
   php artisan migrate
   ```

6. **Rodar o Servidor**:

   Inicie o servidor de desenvolvimento:

   ```bash
   php artisan serve
   ```

   O servidor será iniciado em `http://127.0.0.1:8000`.

---

## 🗂 **Configuração do Banco de Dados**

A aplicação utiliza MySQL como banco de dados, mas pode ser configurada para outros bancos de dados como PostgreSQL ou SQLite. No arquivo `.env`, ajuste os parâmetros do banco de dados conforme sua necessidade.

- **Migrações**: As migrações criam as seguintes tabelas:
  - `users`: Armazena os dados dos usuários registrados.
  - `books`: Armazena os livros cadastrados pelos usuários.
  - `book_user_favorites`: Tabela pivô que relaciona os usuários com seus livros favoritos.

Execute o seguinte comando para aplicar as migrações e gerar as tabelas no banco de dados:

```bash
php artisan migrate
```

---

## 📄 **Documentação da API - Swagger**

A API está documentada usando **Swagger**, permitindo a interação direta com as rotas por meio de uma interface web. A documentação pode ser acessada em:

```
http://127.0.0.1:8000/api/documentation
```

### Possíveis Erros e Soluções na Documentação Swagger:
- **Erro: Undefined array key "annotations"**: Certifique-se de que a chave `annotations` está corretamente configurada em `config/l5-swagger.php`.
- **Erro: Documentação não carregada**: Limpe o cache de configuração com `php artisan config:clear` e gere a documentação novamente com `php artisan l5-swagger:generate`.

---

## 🔧 **Rotas Disponíveis**

### Autenticação:
#### **Registro de Usuário**:
- **Método**: `POST`
- **URL**: `/api/auth/register`
- **Payload**:
  ```json
  {
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
  }
  ```
- **Resposta (201)**:
  ```json
  {
    "message": "Usuário criado com sucesso",
    "user": {
      "id": 1,
      "name": "John Doe",
      "email": "john@example.com"
    }
  }
  ```

#### **Login de Usuário**:
- **Método**: `POST`
- **URL**: `/api/auth/login`
- **Payload**:
  ```json
  {
    "email": "john@example.com",
    "password": "password123"
  }
  ```
- **Resposta (200)**:
  ```json
  {
    "token": "jwt_token"
  }
  ```

---

### Livros:
#### **Listar Livros**:
- **Método**: `GET`
- **URL**: `/api/books`
- **Cabeçalho**:
  - `Authorization: Bearer {token_jwt}`
- **Resposta (200)**:
  ```json
  [
    {
      "id": 1,
      "title": "O Hobbit",
      "author": "J.R.R. Tolkien",
      "description": "Um clássico da fantasia"
    }
  ]
  ```

#### **Criar Livro**:
- **Método**: `POST`
- **URL**: `/api/books`
- **Payload**:
  ```json
  {
    "title": "O Senhor dos Anéis",
    "author": "J.R.R. Tolkien",
    "description": "Continuação de O Hobbit"
  }
  ```
- **Resposta (201)**:
  ```json
  {
    "message": "Livro criado com sucesso",
    "book": {
      "id": 2,
      "title": "O Senhor dos Anéis",
      "author": "J.R.R. Tolkien",
      "description": "Continuação de O Hobbit"
    }
  }
  ```

#### **Atualizar Livro**:
- **Método**: `PUT`
- **URL**: `/api/books/{id}`
- **Payload**:
  ```json
  {
    "title": "O Hobbit - Edição Revisada"
  }
  ```
- **Resposta (200)**:
  ```json
  {
    "message": "Livro atualizado com sucesso"
  }
  ```

#### **Deletar Livro**:
- **Método**: `DELETE`
- **URL**: `/api/books/{id}`
- **Resposta (200)**:
  ```json
  {
    "message": "Livro deletado com sucesso"
  }
  ```

---

### Favoritos:
#### **Adicionar Livro aos Favoritos**:
- **Método**: `POST`
- **URL**: `/api/books/{id}/favorite`
- **Cabeçalho**:
  - `Authorization: Bearer {token_jwt}`
- **Resposta (200)**:
  ```json
  {
    "message": "Livro adicionado aos favoritos"
  }
  ```

#### **Remover Livro dos Favoritos**:
- **Método**: `DELETE`
- **URL**: `/api/books/{id}/favorite`
- **Cabeçalho**:
  - `Authorization: Bearer {token_jwt}`
- **Resposta (200)**:
  ```json
  {
    "message": "Livro removido dos favoritos"
  }
  ```

---

## 🛠 **Execução de Jobs**

Este projeto utiliza **jobs assíncronos** para processar ações em segundo plano. Após a criação de um livro, um **job** é disparado para registrar uma mensagem no log. O job é configurado no modo `sync` no ambiente de desenvolvimento, mas pode ser alterado para **fila assíncrona** conforme necessário.

### Configuração:
No arquivo `.env`, certifique-se de que o valor de `QUEUE_CONNECTION` está definido como `sync` ou configure uma fila como Redis ou Beanstalk para produção.

---

## 📝 **Descrição de Testes**

### Como Testar a Aplicação:

1. **Autenticação**:
   - Registre um novo usuário utilizando a rota de `POST /api/auth/register`.
   - Faça login com as credenciais criadas na rota `POST /api/auth/login`.

2. **CRUD de Livros**:
   - Após obter o token JWT, utilize as rotas para criar, listar, atualizar e deletar livros. Certifique-se de incluir o token JWT no cabeçalho `Authorization`.

3. **Favoritos**:
   - Adicione e remova livros da lista de favoritos usando as rotas `POST` e `DELETE` de `/api/books/{id}/favorite`.

4. **Verifique o Log**:
   - Após criar um livro, verifique o arquivo de log em `storage/logs/laravel.log` para garantir que o job foi executado corretamente.

---

## 💡 **Possíveis Erros e Soluções**

1. **Erro ao Acessar

 o Swagger**:
   - Se a documentação Swagger não carregar, execute os comandos para limpar o cache e gerar a documentação novamente:
     ```bash
     php artisan config:clear
     php artisan l5-swagger:generate
     ```

2. **Erro com o JWT**:
   - Se ocorrer um erro com o token JWT, certifique-se de que o `JWT_SECRET` foi gerado corretamente no arquivo `.env`.
