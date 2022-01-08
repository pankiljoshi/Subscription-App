## Setup

- Clone the repo: git clone https://github.com/pankiljoshi/Subscription-App.git
- Create src/.env file
- Copy content of src/.env.example to src/.env
- Change QUEUE_CONNECTION=sync to QUEUE_CONNECTION=database in the newly copied .env file.
- Set mail server credentials in .env file, specially MAIL_MAILER, MAIL_HOST, MAIL_PORT, MAIL_USERNAME, MAIL_PASSWORD, MAIL_ENCRYPTION, MAIL_FROM_ADDRESS according to your needs.
- Move to src folder and generate laravel key: cd src && php artisan key:generate
- Move to project root folder and run docker compose up (This should automatically migrate database)
- Login to docker container and run seeder using php artisan db:seed (This will add 5 users and 7 websites)
- Login to docker container and Run the worker using php artisan queue:work --queue=subscription_emails
- Test the application at localhost:8003/api (If the port 8003 is in use on the system, change it to a free port in docker-compose.yml)
- Api endpoints are here: https://www.postman.com/zeroek/workspace/subscription-app/overview