
# Symfony 6 + PHP 8.0.13 with Docker

Clone the project

```bash
  git clone git@github.com:NoPainNoFromage/symfony_project.git
  or
  git clone https://github.com/NoPainNoFromage/symfony_project.git
```

Run the docker-compose

```bash
  sudo docker-compose up -d
```

Log into the PHP container

```bash
  sudo docker exec -it php8-sf6 bash
```

Install vendor

```bash
  composer install
```

Run symfony server

```bash
  symfony serve -d  
```

Create database schema

```bash
  symfony console doctrine:migration:migrate
```

Add dummy data

```bash
  symfony console doctrine:fixtures:load
```

Enjoy!

*Your application is available at http://127.0.0.1:9000*
