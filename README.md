### Installation

```bash
# clone repository
git clone git@gitlab.com:medeq/api.git medeq-api && cd medeq-api

# install composer dependencies (using docker)
docker run --rm -v $(pwd):/opt -w /opt laravelsail/php80-composer:latest composer create-project --ignore-platform-reqs

# run laravel sail (docker)
./vendor/bin/sail up -d

# migrate database and fake data
./vendor/bin/sail artisan migrate:fresh --seed
