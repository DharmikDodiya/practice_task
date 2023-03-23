# Features

# unauthenticated
* Register user by sending verification mail
* If user register mail is verify than user login
* Login functionality
* Forget Password using mail verification

# authenticated
* Show Login user profile
* Change password using old password
* Show list of all users
* Logout user

# Auth Module
* Changes into handler file
* Add error reporting functionality in handler.php
* Create helper function success and error

# User Model
* Create User Module ,Controller and migration and perform login user profile , logout , list of all user , change password using old password

# create custom artisan command
* hit this command to create pass by number of users create
* php artisan create:users {count}

# installation
* composer create-project laravel/laravel practice_task
* composer require laravel/passport
* php artisan passport:install

# create custom command
* php artisan make:command createUsers
* php artisan make:command DailyReport
* php artisan queue:table
* php artisan make:job SendEmailQueueJob

# Commands
* add code in to handle function to create user pass by number of count
* testing code scheduler
* work on handle function get all user and and send dailyreport mail to all user using scheduler
* changes into kernel.php add a schedule in schedule funcation
* run schedule Command
* php artisan schedule:run
* php artisan report:daily
* If run the php artisan schedule:run then send a daily report mail to all users

# Mail
* create new Mail DailyReport

# View
* create new view file dailyreport


# Import Export In Laravel
* composer require psr/simple-cache:^1.0 maatwebsite/excel
* composer require maatwebsite/excel
* php artisan vendor:publish --provider="Maatwebsite\Excel\ExcelServiceProvider" --tag=config

# Import Data In User Table
* Crate new importUser
* php artisan make:import UsersImport --model=User
* Create new exportUser 
* php artisan make:export UsersImport --model=User
