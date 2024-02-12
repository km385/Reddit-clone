# Reddit Clone Backend

This project is a Dockerized REST API built with Symfony and Api Platform.

## Backend Startup

1. Prepare a `.env.local` file based on the provided example.
2. Run `composer install`.
3. Create Docker images for the database and PHP server:

   ```sh
   docker compose --env-file .env.local build --no-cache
   ```

4. Start up containers:

   ```sh
   docker compose --env-file .env.local up --wait
   ```

5. Navigate to [https://localhost/api](https://localhost/api) to verify the configuration.

### Local PHP Server

If you prefer to use a local PHP server (database server is still required) run:

```sh
symfony serve -d
```

### Migrations

In case migrations didn't run by default run:

```sh
php bin/console doctrine:migrations:migrate --no-interaction --allow-no-migration
```

## Managing the Database

- To log in to the PostgreSQL database:

  ```sh
  psql -U <username> -d <database_name>
  ```

- To check the database structure:

  ```sh
  \dt
  ```
     or
  ```sh
  SELECT EXISTS (SELECT 1 FROM information_schema.tables WHERE table_schema = 'public' );
  ```

- To check columns of a given table:

  ```sh
  \d <table_name>
  ```

- To create and run migrations:

  ```sh
  php bin/console make:migration
  ```

  ```sh
  php bin/console doctrine:migrations:migrate --no-interaction --allow-no-migration
  ```

- To generate dummy data with fixtures(seeders):

  ```sh
  symfony console doctrine:fixtures:load
  ```

- To drop and recreate the database:

  ```sh
  symfony console doctrine:database:drop --force
  ```

  ```sh
  symfony console doctrine:database:create
  ```

## Tech Stack

| Technology   | Version   |
| ------------ | --------- |
| Symfony      | v7.0.3    |
| Api Platform | v3.2.13   |
| PHP          | v8.2.12   |
| PostgreSQL   | v16-alpine|

## Team

| Who                                         | What      |
| ------------------------------------------- | --------- |
| [@Jakub F](https://github.com/km385)        | Frontend  |
| [@Mateusz C](https://github.com/MateuszCzz) | Backend   |

---