# Reddit Clone

A Dockerized clone of Reddit, split into Symfony/Api Platform Backend and Vue.js Frontend.

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

5. Visit [https://localhost/api](https://localhost/api) to verify the configuration.

### Local PHP Server

If you prefer to use a local PHP server (database server is still required), run:

```sh
symfony serve -d
```

## Frontend Startup

### Docker Setup

Build the Docker image:

```sh
docker build . -t reddit-clone-client
```

Run the Docker container:

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
