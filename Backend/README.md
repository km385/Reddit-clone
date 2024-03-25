# Reddit Clone Backend

Welcome to the Reddit Clone Backend project! This is a Dockerized REST API built with Symfony and Api Platform.

## Backend Startup

1. Prepare a `.env.local` file based on the provided example.
2. Build Docker images for the database and PHP server using the following command:

    ```sh
    docker compose --env-file .env.local build --no-cache
    ```
   >⚠️ **Warning:** Rebuilding images can result in dangling images. Remember to clean them off after each use.
   >
   >⚠️ **Warning:** Git can break docker containers with converting line ending from windows's LF to CRLF. 
   To disable CRLF conversion globally, run `git config --global core.autocrlf false`, and clone again.

3. Start up the containers with:

    ```sh
    docker compose --env-file .env.local up --wait
    ```

4. Once the server is successfully configured, you can test the API endpoints by visiting [https://localhost/api](https://localhost/api). Additionally, you can check out server statistics at [http://localhost/_profiler](http://localhost/_profiler).

### Local PHP Server

If you prefer to use a local PHP server instead of Docker:

1. Install necessary dependencies with Composer:

    ```sh
    composer install
    ```
      >⚠️ **Warning:** It might be necessary to change the Database URL in `env.local` in order to connect with the database.
 
2. Start the PHP server:

    If you have Symfony CLI installed:
    
      ```sh
      symfony serve -d
      ```
    
    If you don't have Symfony CLI installed:
    
      ```sh
      php -S localhost:8000 -t public
      ```

### Lack of tables:

In case migrations didn't run by default run, use:

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
  php bin/console doctrine:migrations:migrate --no-interaction --allow-no-migration
  ```

- To generate dummy data with fixtures (Laravel Seeders):

  ```sh
  symfony console doctrine:fixtures:load --no-interaction
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