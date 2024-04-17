To run this project you will need PHP 8.1 and 'composer' to install the dependencies.

1. Clone the project in your local machine
If you're using xampp to run the project, change APP_URL=http://localhost in the .env file
If you're using Laragon, leave it as it is (I use Laragon)

3. Change DB credentials
Change DB credentials accordingly in .env file. Default:
```
DB_DATABASE=project_task 
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_USERNAME=root
DB_PASSWORD=
```

Change Mail credentials accordingly in .env file to send the mail.
```
MAIL_USERNAME=your_mail_address
MAIL_PASSWORD=your_mail_password
MAIL_FROM_ADDRESS=your_mail_address
```

4. Open a terminal in the root folder
5. Run 'composer install' to install all the dependencies
6. Run 'php artisan migrate:fresh --seed' to seed the data
7. Run 'php artisan queue:work' to run the queue and keep this terminal running. I used Queue to send the verification code mail, if you close the terminal, you won't recieve the email. (Also, if you use admin credentials to login, you won't have to verify by code. admin credentials- email:admin@localhost.local, password:admin. You won't have to verify by code also after registering. Everytime else, you will have to verify by code from email after login.
8. If you encounter any CSRF/Page expired issue, please refresh the page/go back.

Thanks for this opportunity.

