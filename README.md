# Krunker Matchmaker

## Processo de instalação
Para instalar o sistema, você apeanas necessita possuir o [Docker](https://www.docker.com/), com o Docker Compose ativo.
Caso não tenha, é necessário ter o [PHP](https://www.php.net/) na versão `^8.2` e o [Composer](https://getcomposer.org/)

### 1. Clone o Repositório

```sh
git clone https://github.com/gustavogordoni/krunker-matchmaker.git krunker-matchmaker
```

### 2. Acesse o diretório
```sh
cd krunker-matchmaker
```

### 3. Crie o arquivo .env

```sh
cp .env.example .env
```

### 4. Suba o container Nginx

```sh
docker compose up -d
```

### 5. Acesse o container da aplicação

```sh
docker compose exec app bash
```

### 6. Instale as dependências do Laravel

```sh
composer install
```

### 7. Gere a chave da aplicação

```sh
php artisan key:generate
```

---

## Acesse a plataforma

Abra no navegador: [http://localhost:8000](http://localhost:8000)
