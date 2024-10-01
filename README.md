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
8.	API Documentation
9.	License
1. Project Overview
This project is built using Laravel 9, a PHP framework for web artisans. It provides an expressive and elegant syntax that makes development enjoyable. This application includes various essential features such as API authentication, role management, and JWT-based token authentication.________________________________________
2. Features
•	 Role-Based Access Control using Spatie Laravel Permission.
•	JWT Authentication using Tymon JWT Auth.
•	 API Support with Laravel Sanctum.
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
git clone https://github.com/your-username/your-repository-name.git
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

10. API Documentation
If your project has APIs, include details on how to use them.
API Endpoints
Logs in the user
•	POST /api/login 
Protected routes with jwt auth
Logs out (admin, supervisor, manager, student)
•	Get /api/logout 
Show user profile(admin, supervisor, manager, student)
•	Get /api/user-profile  - Post/api/admin/add-user - Add user ( supervisor, manager)
Sets password ( supervisor, manager ) => add token received in notification mail
•	Post/set-passwod{token} 
view all students submissions based on statuses
•	GET/admin/view-students
 view all students submissions with out filtering 
•	Get/admin/view-submissions
Admin will accept student submission 
•	Patch/admin/submission/{submission}/accept  ( here student submission id will be passed)
Admin will accept student submission 
•	Patch/admin/submission/{submission}/reject  ( here student submission id will be passed)
 Question Management
Admin will create question, jwt access token is required
 post/create-questions
Update an existing question (question id is requird)
put/update-question/{id}
Delete a question 
delete/delete-question/{id}
Quiz Management 
post/create-quiz 
view all quizzes
get/view-quizzes
 update quiz
put/update-quiz/{id} 
Delete quiz
 delete/delete-quiz/{id}
view all quizzes with questions
get/view-quiz-with-questions/{quizId}
Quiz Assignment 
post/assign-quiz
view single quiz
get/view-quiz/{quizId}
view all assigned quizzes
 get/view-assigned-quizzes
Attempt assigned quizzes
post/attempt-quiz
view quizzes results
 get/view-quiz-attempt/{attemptId})
 Getting Attempts for a Specific Quiz Assignment 
get/{assignmentId}/attempts 
get/view-video/{attemptId}
public routes
 Student Submission Route 
post/submission
Set Password Routes
post/set-password/{token}
post/set-password/{token}
post/set-student-password/{token}
post/reset-student-password
post/store-video
________________________________________
11. License
This project is open-source and available under the MIT License.


