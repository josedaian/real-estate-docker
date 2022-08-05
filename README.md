# Real State Docker
### Services
- Nginx
- PHP 8.1
- Laravel
- Redis 6.2.6
- MySQl 8.0

## How to install
After cloning the repository and being inside the project folder, run the following commands:
```sh
cp .env.example .env
docker-compose up
```

### Optional Step
In .env file you can set custom ports for services:
- Nginx (default: 8000)
- Redis (default: 6379)
- Mysql (default: 4806)

## License

MIT
