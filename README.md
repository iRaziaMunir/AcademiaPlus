# AcademiaPlus
 
Author: [Razia Munir]
APIs are integrated by Abu Hurar and Ali Hussain 
Table of Contents
1.	Project Overview
2.	Features
3.	System Requirements
4.	Installation
5.	Configuration
6.	Database Setup
7.	Running the Application
9.	License
1. Project Overview
This project is built using Laravel 9, a PHP framework for web artisans. It provides an expressive and elegant syntax that makes development enjoyable. This application includes various essential features such as API authentication, role management, and JWT-based token authentication.
________________________________________
3. Features
•	 Role-Based Access Control using Spatie Laravel Permission.
•	JWT Authentication using Tymon JWT Auth.
•	CORS Configuration for handling cross-origin requests.
•	Queue Management with database drivers.
________________________________________
3. System Requirements
Before installing the project, ensure your system meets the following requirements:
•	PHP version >= 8.0
•	Composer
•	MySQL
•	Web server (Apache)
________________________________________
4. Installation
Step 1: Clone the repository
To get started, clone the repository from GitHub
Copy code
git clone https://github.com/iRaziaMunir/AcademiaPlus.git
cd your-repository-name
Step 2: Install PHP Dependencies
Use Composer to install the PHP dependencies :
Copy code
composer install
Step 3: Set Up the .env File
Duplicate the .env.example file to create the .env file and configure it:
Copy code
cp .env.example .env
Make sure to update the following fields in your .env file:
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:w+ldcZUA9FlJ16EhnAZBtPhhLH151YPRoIB7tpLdIVg=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your-database-name
DB_USERNAME=your-username
DB_PASSWORD=your-password

MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=587
MAIL_USERNAME= your-username
MAIL_PASSWORD= your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email
MAIL_FROM_NAME="${APP_NAME}"

Step 4: Generate Application Key
Run the following command to generate the application key:
php artisan key:generate
________________________________________
5. Configuration
Make sure the following settings are configured properly in your .env file:
•	Database Connection: Set your database connection details in the .env file.
•	Mail Configuration: Set up your mail configuration as email notifications are required.
________________________________________
6. Database Setup
Step 1: Migrate the Database
Run the database migrations to set up the tables:
php artisan migrate
Step 2: Seed the Database 
To seed the database :
php artisan db:seed
________________________________________
Step 6: Set Up JWT Secret
Generate a JWT secret for the application:
php artisan jwt:secret

________________________________________
7. Running the Application
Step 1: Start the Development Server
Run the following command to start the local development server:
php artisan serve
Access the application by visiting http://localhost:8000 in your browser.
________________________________________


