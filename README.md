
## leadPops app

- .env is provided in root of project please change to your credentials DB_DATABASE, DB_USERNAME, DB_PASSWORD
- postmen collection is in the root of project leadPops.postman_collection.json

clone the repo and please run next commands in your terminal

```sh
- composer install
- php artisan migrate --seed
- php artisan serve
```


Project should be found on route http://127.0.0.1:8000

Project has three routes
```sh
http://127.0.0.1:8000/api/jwt
http://127.0.0.1:8000/api/short
http://127.0.0.1:8000/Lnf5oNN   note that "Lnf5oNN" is generated Short url

```

First step:
http://127.0.0.1:8000/api/jwt POST route accepts params email: user@admin.com and password:password and return token

Second step:
http://127.0.0.1:8000/api/short POST route requires Bearer Token supplied from http://127.0.0.1:8000/api/jwt route,
also requires url parameter that has to be valid url like https://www.google.com/
it returns "short_url": "http://127.0.0.1:8000/Lnf5oNN"

Third step:
http://127.0.0.1:8000/Lnf5oNN GET route is provided as response in previous step, just copy and paste address in your browser address bar and you will be redirected domain you provided in previous step

