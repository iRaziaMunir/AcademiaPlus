# AcademiaPlus
 
Author: [Razia Munir]

APIs are integrated by Abu Hurar and Ali Hussain 

Table of Contents

    1.	Project Overview
    2.	Key Features
    3.	System Requirements
    4.	Installation
    5.	Configuration
    6.	Database Setup
    7.	Running the Application
    9.	License


1. Project Overview

        This project is a Quiz and user (Student, Manager, Supervisor) Management System built using the Laravel framework. 
        It provides a comprehensive platform for administrators to manage quizzes, student submissions, and user roles while enforcing security and permissions through JWT-based authentication and Spatie role and permission.
        This project is designed to simplify the administration of quizzes, student submissions, and user management. 
        It provides a secure and scalable way for institutions or organizations to handle quizzes and student-related tasks while maintaining strict role-based permissions to protect sensitive actions. 
        The integration of JWT authentication ensures that user sessions are secure, and the Spate roles and permission package  ensures that only authorized users can perform specific actions.

2. Key Features:
   
    User Authentication:

        The application uses JSON Web Token (JWT) authentication to secure all routes and ensure only authenticated users can access specific functionalities.
        Users can log in, refresh tokens, logOut, and view their profiles securely.
   
   Role-Based Permissions:

        A robust custom permission middleware with spatie role and permission package restricts user actions based on roles and permissions.
        Only authorized users can create, view, update, and delete quizzes, as well as manage student submissions and quiz assignments.
   
    Student Management:

        Administrators can manage student submissions, including accepting and rejecting student requests. This allows the system to streamline student-related tasks and ensure each submission goes through an approval process.
        Students can submit their information, set their passwords, and request password resets.
        
    Quiz Management:

        Admin users can create, update, and delete quizzes. Additionally, the system allows administrators to view quizzes along with their questions.
        Quizzes can be assigned to students with accepted status, who can then attempt the assigned quizzes.
        The system also tracks quiz attempts, allowing users to review their results.
        
    Question Management:

        The application supports CRUD operations (Create, Read, Update, Delete) for quiz questions, enabling administrators to manage quiz content effectively.
        
    Quiz Assignment and Attempt:

        Managers can assign quizzes to students and view the list of assigned quizzes.
        
        Students can attempt assigned quizzes, and both admins and students can view the results of quiz attempts.
        
    Video Management:

        The system allows videos to be associated with quiz attempts, which admin user can watch.
Core Functionality:

    Admin Capabilities:

        Admins have full control over managing users, quizzes, and students.
        Admins can create, manage quiz questions, and handle student submissions.
        Manager can assign quizzes.
        The system includes detailed permissions to restrict or allow specific actions (e.g., only users with the correct permissions can add users or view student submissions).
        

    Student Interaction:

        Students can submit information, set their passwords, and attempt assigned quizzes.
        The system allows students to view their quiz results.

    User Management:

        Admins can add new users, with  roles and restrictions on what each user can do based on their permissions.
        The application uses spatie roles and permission package to ensure a secure environment where actions are only performed by users with appropriate access rights.

    Queue Management
    
        This project uses the Database Queue driver for handling background jobs

    Security:

        JWT authentication ensures that users' data and actions are secure.
        The permission-based middleware provides fine-grained control over which routes and actions are accessible to different user roles.
        
    Debugging:

        Error logs and request logs are maintained in this application which makes debugging easier.

3. System Requirements

Before installing the project, ensure your system meets the following requirements:

        •	PHP version >= 8.0
        
        •	Composer
        
        •	MySQL
        
        •	Web server (Apache)


4. Installation
   
Step 1:Clone the repository

        To get started, clone the repository from GitHub
    
        git clone https://github.com/iRaziaMunir/AcademiaPlus.git
        cd your-repository-name
    
Step 2: Install PHP Dependencies

        Use Composer to install the PHP dependencies :
        composer install
        
Step 3: Set Up the .env File

        Duplicate the .env.example file to create the .env file and configure it:
        cp .env.example .env
        
Make sure to update the following fields in your .env file:

General Settings:

        APP_NAME=Laravel
        
        APP_ENV=local
        
        APP_KEY=base64:w+ldcZUA9FlJ16EhnAZBtPhhLH151YPRoIB7tpLdIVg=
        
        APP_DEBUG=true
        
        APP_URL=http://localhost
        
Database Settings:
    
        DB_CONNECTION=mysql
        
        DB_HOST=127.0.0.1
        
        DB_PORT=3306
        
        DB_DATABASE=your-database-name
        
        DB_USERNAME=your-username
        
        DB_PASSWORD=your-password
        
Mail Configuration:
    
        MAIL_MAILER=smtp
        
        MAIL_HOST=sandbox.smtp.mailtrap.io
        
        MAIL_PORT=587
        
        MAIL_USERNAME= your-username
        
        MAIL_PASSWORD= your-password
        
        MAIL_ENCRYPTION=tls
        
        MAIL_FROM_ADDRESS=your-email
        
        MAIL_FROM_NAME="${APP_NAME}"

Queue Management:

        QUEUE_CONNECTION=database

JWT Configuration:

        JWT_SECRET: Secret key for JWT token generation and validation.

Step 4: Generate Application Key

        Run the following command to generate the application key:
        php artisan key:generate
        

5. Configuration
   
        Make sure the following settings are configured properly in your .env file:
        •	Database Connection: Set your database connection details in the .env file.
        •	Mail Configuration: Set up your mail configuration as email notifications are required.
   

6. Database Setup
           
        Step 1: Migrate the Database
   
            Run the database migrations to set up the tables:
       
            php artisan migrate
   
        Step 2: Seed the Database
   
            To seed the database :
       
            php artisan db:seed
       
    
        Step 6: Set Up JWT Secret key
        
        Generate a JWT secret key for the application:
        
        php artisan jwt:secret


7. Running the Application
   
        Step 1: Start the Development Server
        
        Run the following command to start the local development server:
        
        php artisan serve
        
        Access the application by visiting http://localhost:8000 in your browser.
   

Run the following command in separate terminal  to process queue jobs:

        php artisan queue:work
