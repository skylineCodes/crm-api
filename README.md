## Steps to reproduce

- Run git clone
- On your local environment - Run docker-compose up -d - to build the project images with docker compose images
- Run docker-compose exec crm_api bash to enter the api bash
- Run php artisan migrate
- Exit the bash
- Access the api on http://localhost:8001/api/

## Postman Documentation

- https://documenter.getpostman.com/view/4791722/TzefAPTD
