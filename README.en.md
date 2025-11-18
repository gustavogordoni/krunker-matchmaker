# Krunker Matchmaker

[![GitHub last commit](https://img.shields.io/github/last-commit/gustavogordoni/krunker-matchmaker?color=purple)](https://github.com/gustavogordoni/krunker-matchmaker/commits/)
[![License](https://img.shields.io/github/license/gustavogordoni/krunker-matchmaker)](https://github.com/gustavogordoni/krunker-matchmaker/blob/main/LICENSE)

This project is an application built with **Laravel** that queries the **Krunker** game API to retrieve real-time information about active matches.

The application works as a **search system**, allowing users to filter matches by region, game mode, player count, remaining time, and other criteria. This makes it easy to quickly find open matches or games with specific characteristics.

[Versão em Português](https://github.com/gustavogordoni/krunker-matchmaker/blob/main/README.md)

---

## Purpose of the Project

The main goal of **Krunker Matchmaker** is to provide an interface where players can:

* View active matches on the servers;
* Apply filters to find ideal games;
* Quickly access the game through a direct link;

Available filters include:

* Regions
* Game modes
* Minimum/maximum number of players
* Remaining time

The system fetches data directly from the endpoint:

```
https://matchmaker.krunker.io/game-list?hostname=krunker.io
```

It then processes and filters the returned JSON, displaying only the matches that match the selected criteria.

---

## Requirements

You can run the project in two ways:

### Option 1 — Using Docker (Recommended)

You will need:

* **Docker**
* **Docker Compose**

### Option 2 — Without Docker

You will need:

* **PHP 8.2+**
* **Composer**

---

## Installation Process

### 1. Clone the repository

```sh
git clone https://github.com/gustavogordoni/krunker-matchmaker.git krunker-matchmaker
```

### 2. Enter the directory

```sh
cd krunker-matchmaker
```

### 3. Create the `.env` file

```sh
cp .env.example .env
```

### 4. Start the Nginx container

```sh
docker compose up -d
```

### 5. Access the application container

```sh
docker compose exec app bash
```

### 6. Install Laravel dependencies

```sh
composer install
```

### 7. Generate the application key

```sh
php artisan key:generate
```

### 8. Run the migrations

```sh
php artisan migrate
```

---

## Accessing the platform

Open in your browser:

```
http://localhost:8000
```

---

## Contributions

Feel free to open PRs with improvements or fixes.
