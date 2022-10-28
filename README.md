# Slorm Builds

## About
Slorm builds is a site to share and vote on Slorm buids.

## Setting up the project
You will need [Docker](https://www.docker.com/) installed to run this project locally.
<br>
Fork the repo, then clone your forked repo.

Install the composer dependencies
```sh
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
```

Copy the .env.example file
```sh
cp .env.example .env
```

Create an alias for Sail
```sh
alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'
```

Start the containers
```sh
sail up -d
```

SSH into the container
```sh
sail shell
```

Generate the app key
```sh
php artisan key:generate
```

Run migrations and seeders
```sh
php artisan migrate --seed
```

That's it! you've now setup the project's enviroment.