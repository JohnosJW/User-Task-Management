## Initial steps

1. Run `docker-compose up`
    - run `docker-compose exec php composer i`
    - you can connect to db by credentials in .env file (outside container: 127.0.0.1:8001)
2. Run migrations `docker exec $(docker ps -q -f name=gcore-php) php artisan migrate`
3. Run command for Creating A Personal Access Client `docker exec $(docker ps -q -f name=gcore-php) php artisan passport:install`
4. Run command `docker exec $(docker ps -q -f name=gcore-php) php artisan command:fill-db` to fill DB by test data.
5. Create POST Requests to http://127.0.0.1:8012/api/v1/auth with `email = ap@apple.com, password = 123456` for get access_token
6. Requests must be sent with `OAuth 2.0` type authorization and token must be `Bearer <your_access_token>`.
7. There are tests for end-points. Execute by: `docker exec $(docker ps -q -f name=gcore-php) ./vendor/bin/phpunit tests/Controller/Api/V1/`

## Curl requests
##### POST /api/v1/auth
`curl --location --request POST 'http://127.0.0.1:8012/api/v1/auth' \
--form 'email="ap@apple.com"' \
--form 'password="123456"'`

##### GET /api/v1/tasks
`curl --location --request GET 'http://127.0.0.1:8012/api/v1/tasks/' \
--header 'Authorization: Bearer <your_access_token>'`

##### POST /api/v1/tasks
`curl --location --request POST 'http://127.0.0.1:8012/api/v1/tasks/' \
--header 'Authorization: Bearer <your_access_token>' \
--form 'title="title"' \
--form 'description="description"'`

##### POST /api/v1/tasks/<taskId>/set-status/<status>
`curl --location --request POST 'http://127.0.0.1:8012/api/v1/tasks/<taskId>/set-status/<status>' \
--header 'Authorization: Bearer <your_access_token>'`
