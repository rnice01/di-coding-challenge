## Dealer Inspire PHP Code Challenge

Thanks for reviewing my submission, I have decided to use Laravel as it is a PHP framework I am familiar with
and knew it would allow me to focus on the required tasks. I find the layers of abstractions for routing, DB access, CLI, and mail
to to be useful to quickly scaffolding a working application.

### Starting the app
Because I am using Laravel, I ask that you please run the command below so the application
works with best results. 

`composer install`

The app is configured to use a development MySQL install with the root@localhost user having no password. Please update the .env file with the appropriate credentials if this is different for your environment. Once that is configured run the following commands to create the databse and tables, run the tests, and serve the app.

```
php artisan app:init
phpunit
php -S 127.0.0.1:9999 -t public
```

### Caveats
While I know it is bad practice to version control ENV files, I decided to add it to the repo
in this case so there's less steps for you the reviewer to get the app started. 

While I could have created the application using 'vanilla' PHP, I opted to use a framework in this case as I felt it
would help me focus on the required tasks efficiently as well as to show that I am capable of working with and learning
frameworks and tools.

The tests provided are focused on ensuring the correct response is returned based on the input POSTed from the form. For testing the ContactGuy class, I normally would add tests and checks for validating the Contact object and throwing exceptions when needed. However, in the case of this challenge to save time I decided to leave the tests and checks in the ::notify method out.

The email for the application is only being logged and not actually sent out. To enable the feature, please
update the .env file with the appropriate SMTP settings.



