# Real State Docker
### Services
- Nginx
- PHP 8.1
- Laravel 9
- Redis 6.2.6
- MySQl 8.0

## How to install
After cloning the repository and being inside the project folder, run the following commands:
```sh
cp .env.example .env
docker-compose up
docker exec -it api-real-estate php artisan key:generate
```
Next, we configure our .env with the data from our database and redis configuration.
```
DB_HOST=real-estate-mysql
REDIS_HOST=real-estate-redis
```

After that, run the following commands:
```
docker exec -it api-real-estate php artisan migrate
docker exec -it api-real-estate php artisan db:seed
```

### Optional Step
In .env file you can set custom ports for services:
- Nginx (default: 8000)
- Redis (default: 6379)
- Mysql (default: 4806)

### Optional Population by CSV file
You can put the csv file in the services/api-real-estate/public folder and name it gustavo-madero.csv so that the table is populated inside the seeder.
Also, inside the .env set the REQUIRE_CSV parameter to TRUE.

**AFTER THAT, RUN THE SEEDERS AGAIN.**

## Endpoints available
- {BASE_PATH}:8000/price-m2/zip-codes/{zipCode}/aggregate/{type}?construction_type={1-7}
## License

MIT
