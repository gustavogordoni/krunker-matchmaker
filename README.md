# Krunker Matchmaker

Este projeto é uma aplicação desenvolvida em **Laravel** que consulta a API do jogo **Krunker** para obter informações sobre as partidas que estão ocorrendo em tempo real.

A aplicação funciona como um **sistema de busca**, permitindo filtrar as partidas por região, modo de jogo, quantidade de jogadores, tempo restante e outros critérios. Isso facilita encontrar rapidamente partidas abertas ou com características específicas.

[English Version](https://github.com/gustavogordoni/krunker-matchmaker/blob/main/README.en.md)

---

## Propósito do Projeto

O objetivo principal do **Krunker Matchmaker** é oferecer uma interface para que jogadores possam:

* Visualizar partidas ativas nos servidores;
* Aplicar filtros para encontrar partidas ideais;
* Acessar rapidamente o jogo via link;

Os filtros incluem:
* Regiões
* Modos de jogo
* Mínimo/máximo de jogadores
* Tempo restante

O sistema coleta dados diretamente do endpoint:

```
https://matchmaker.krunker.io/game-list?hostname=krunker.io
```

Em seguida, processa e filtra o JSON retornado, exibindo apenas as partidas desejadas.

---

## Requisitos

Você pode rodar o projeto de duas formas:

### Opção 1 — Usando Docker (Recomendado)

Necessário ter:

* **Docker**
* **Docker Compose**

### Opção 2 — Sem Docker

Necessário ter:

* **PHP 8.2+**
* **Composer**

---

## Processo de Instalação

### 1. Clone o repositório

```sh
git clone https://github.com/gustavogordoni/krunker-matchmaker.git krunker-matchmaker
```

### 2. Acesse o diretório

```sh
cd krunker-matchmaker
```

### 3. Crie o arquivo `.env`

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

### 8. Rode as migrations

```sh
php artisan migrate
```

---

## Acessando a plataforma

Abra no navegador:

```
http://localhost:8000
```

---

## Contribuições

Sinta-se à vontade para abrir PRs com melhorias ou correções.
