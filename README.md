# Installation guide for Paynetics Project simple managment sytem
First, you need install on local machine these soft :

##### 1. docker
   Mac: https://docs.docker.com/desktop/install/mac-install/
   win: https://docs.docker.com/desktop/install/windows-install/
   Linux: https://docs.docker.com/engine/install/ubuntu/
##### 2. docker-compose
   installation : https://docs.docker.com/compose/install/

##  After installing all soft let's do other steps.
   Clone files from giving repository.

##  Open CMD/Terminal and run:

`docker-compose build`

Note : First time it will take more time, you should not run it everytime before starting work.

**Then run following command:**

`docker-compose up`

**Run following commands (on CMD/Terminal) from new tab step by step:**

**Create new .env file from env.example and set credentials**

`docker-compose exec php cp .env.example .env`

Note: I didn't remove the credentials from
docker-composer.yml and .env.example files to simplify installation

**Installing composer**

`docker-compose run --rm composer install`

**Give Permissions for php user**

`docker-compose exec php chown paynetics storage`
`docker-compose exec php chown paynetics bootstrap/cache`

**Migrate database**

`docker-compose run --rm artisan migrate`

`docker-compose run --rm artisan db:seed`

**Install `npm` and generate front-end files**

`docker-compose run --rm yarn install`

`docker-compose run --rm yarn run dev`

**And open the url http://localhost**

**For admin login, just open http://localhost/admin/**