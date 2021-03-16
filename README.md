### Installation

```bash
# clone repository
git clone git@gitlab.com:medeq/api.git medeq-api && cd medeq-api

# install composer dependencies (using docker)
docker run --rm -v $(pwd):/opt -w /opt laravelsail/php80-composer:latest composer create-project --ignore-platform-reqs

# migrate database and fake data
sail artisan migrate:fresh --seed

# reindexing elasticsearch indices
sail artisan search:reindex
