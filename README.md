## Steps to reproduce

- Run git clone
```
git clone https://github.com/skylineCodes/crm-api.git
```
- On your local environment - Run 
```
docker-compose up -d
```
- Run this command to enter the api bash
```
docker-compose exec crm_api bash
```
- Run this command to migrate all tables
```
php artisan migrate
```

- Access the api on http://localhost:8001/api/


## Postman Documentation

- https://documenter.getpostman.com/view/4791722/TzefAPTD
