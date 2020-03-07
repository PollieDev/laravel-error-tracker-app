# Laravel Error Tracker App
This is an application that shows you errors that happened on your productions websites. It includes all the information that ignitions shows you (the error page of Laravel) and gives you the possibility to mark reports to be resolved. This way you can keep track of errors that happens or get more information if a user tells you that the site went into a 500 page without providing much information.  
  
This repo is the app (website) itself. To receive the errors on your app you'll need to install the package on your laravel app. You can find the package and more information of it here: https://github.com/PollieDev/laravel-error-tracker

## Installation
The package runs on Laravel 7 which means your minimum required PHP version must be 7.2.5.

1. First of all clone the repo
```bash
git clone https://github.com/PollieDev/laravel-error-tracker-app.git
```

2. Install the composer dependencies
```bash
composer install
```

3. Create an app key
```bash
php artisan key:generate
```

4. Install node dependencies
```bash
npm ci
```

5. Parse the SCSS & JS (vue)
```bash
npm run prod
```

Now you should be able to access your app.

## Create a first user
When you just created the app you won't have any users in the database. You could go into the database and add the user yourself or you could use the provided artisan command.  
  
The artisan command is as follow:
```
php artisan create:admin <email> <password>
```
This will create an admin user with the provided information and a temporary name.
Once logged in on the app you'll be able to change your name and password as you wish.

## Screenshots
![image](/screenshots/reports.png)
![image](/screenshots/report_detail.png)
![image](/screenshots/report_detail_occurrences.png)
