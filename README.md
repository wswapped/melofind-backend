# Backend

The backend for melofind is built in Laravel v10

Copy the `.env.example` to `.env` and substitute the variables depending on your environment, below are the values to change

- `APP_PORT` is the port that backend will run on

- `FORWARD_DB_PORT` the db port to be used by docker to forward mysql

- `FRONTEND_URL` the auth complete URL, just change the host, port and leave other parts

- `LASTFM_API_KEY` this is last fm key, generate one from https://www.last.fm/api/account/create

- `LASTFM_SHARED_SECRET` this is a lasfm secret, you get it with `LASTFM_API_KEY`

- `GOOGLE_CLIENT_ID` and `GOOGLE_CLIENT_SECRET` are used for Google single sign on. You can generate one from the Google Cloud Console, or follow below for guide

https://support.google.com/workspacemigrate/answer/9222992?hl=en

In `Authorized JavaScript origins` use `http://127.0.0.1:8081`

In `Authorized redirect URIs` use `http://127.0.0.1:8081/api/auth/callback`

After setting up the environment, its time to run the backend and database

Installing laravel dependencies by running ```bash
docker run --rm     -u "$(id -u):$(id -g)"     -v "$(pwd):/var/www/html"     -w /var/www/html     laravelsail/php82-composer:latest     composer install --ignore-platform-reqs```

You can use `./vendor/bin/sail up` to bring the services up

You should run the migrations from the laravel container with `php artisan migrate` or using sail from the host system with `./vendor/bin/sail artisan migrate`
