# Reddit-clon
### Dockerized clone of reddit, split into Symfony Api Platform backend and Vue.js Frontend
---
### Backend Startup:
- prepare .env file
- composer install
- start database server / docker-compose up --build
- php bin/console doctrine:migrations:diff
- php bin/console doctrine:migrate
- symfony serve -d --no-tls
---
### Frontend Startup:
-
-
---
### How To check Database:
- start database server
- login with psql -U <username> -d <database_name>
- run "\dt" or "SELECT EXISTS (SELECT 1 FROM information_schema.tables WHERE table_schema = 'public' );" For list of tables.
- run "\d <table_name>" to check structure of given table.
---
### Tech stack:
| Technology        | Version    |
| :---- | :----: |
| Symfony          | v7.0.3  |
| Api Platform     | v3.2.13       |
| PHP              | v8.2.12     |
| Postgres         | v16-alpine     |
---
### To look into:
-
--- 
### Team
| Who | What |
| :---: | :---: |
| [@Jakub F](https://github.com/km385) | Frontend |
| [@Mateusz C](https://github.com/MateuszCzz) | Backend |

---
