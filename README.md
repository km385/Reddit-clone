# Reddit Clone
Welcome to the Reddit Clone project! This is a dockerized application split into Symfony/Api Platform Backend and Vue.js/Typescript Frontend.

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
>⚠️ **Warning:** It might be nececery to change the Database URL in `env.local` in order to connect with the database.
 
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

## Frontend Startup

### Docker Setup

1. Build the Docker image:

   ```sh
   docker build . -t reddit-clone-client
   ```

2. Run the Docker container:

   ```sh
   docker run -d -p 8080:80 --name reddit-clone-frontend reddit-clone-client
   ```

### Local Development Server

For development purposes, compile and hot-reload using:

   ```sh
   npm run dev
   ```

## Tech Stack

| Technology   |  Version   |
|:-------------|:----------:|
| Symfony      |   v7.0.3   |
| Api Platform |  v3.2.13   |
| PHP          |  v8.2.12   |
| Postgres     | v16-alpine |
| Vue          |  v3.4.15   |
| Vite         |  v5.0.11   |

## Team

| Who                                          | What     |
|:-------------------------------------------- |:--------:|
| [@Jakub F](https://github.com/km385)        | Frontend |
| [@Mateusz C](https://github.com/MateuszCzz) | Backend  |

---
