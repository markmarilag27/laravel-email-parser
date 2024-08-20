## Developers
How to get started working on this project is below.
### Requirements
To run this application you need to have:
- [PHP](https://www.php.net/releases/8.3/en.php) Version: `^8.3`
- Exif PHP Extension
- GD PHP Extension
- Imagick PHP Extension
- BCMath PHP Extension
- Ctype PHP Extension
- JSON PHP Extension
- Fileinfo PHP extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension


### Official and third-party libraries
List of used packages:

- [Laravel Sanctum](https://laravel.com/docs/11.x/sanctum) for SPA authentication.
- [PHPRedis](https://github.com/phpredis/phpredis) a PHP extension for Redis
- [Laravel IDE Helper Generator](https://github.com/barryvdh/laravel-ide-helper) to generate accurate autocompletion.
- [Laravel Pint](https://laravel.com/docs/11.x/pint) is an opinionated PHP code style fixer for minimalists. Pint is built on top of PHP-CS-Fixer and makes it simple to ensure that your code style stays clean and consistent.
- [Larastan](https://github.com/larastan/larastan) scans your whole codebase and looks for both obvious & tricky bugs. Even in those rarely executed if statements that certainly aren't covered by tests.
- [PHPStan Strict Rules](https://github.com/phpstan/phpstan-strict-rules) Extra strict and opinionated rules for PHPStan


### Laravel Coding Standard
You can now run the test simply typing
<pre><code>./vendor/bin/pint</code></pre>

### Static Analysis Tool
PHPStan scans your whole codebase and looks for both obvious & tricky bugs. Even in those rarely executed if statements that certainly aren't covered by tests.
<pre><code>./vendor/bin/phpstan analyse</code></pre>

### Laravel IDE Helper
This package generates helper files that enable your IDE to provide accurate autocompletion. Generation is done based on the files in your project, so they are always up-to-date.
<pre><code>php artisan ide-helper:generate</code></pre>
<pre><code>php artisan ide-helper:meta</code></pre>
I recommend to use this with VSCode extension called [Laravel Intellisense](https://marketplace.visualstudio.com/items?itemName=mohamedbenhida.laravel-intellisense)

### Getting Started
Clone the repository
```
$ git clone git@github.com:markmarilag27/laravel-email-parser.git
```
Copy and edit environment file
```
$ cp .env.example .env
```
Run to build the app container
```
$ docker compose build app
```
Run to boot up development, composer install and etc.
```
$ bash ./run-start.sh
```
Enter on container shell
```
$ bash ./run-exec-container.sh
```
### Finding bugs on your code
Run this script before commit
```
$ bash ./run-before-commit.sh
```
### Seed the data
Inside the container
```
$ php artisan db:seed
```

### API Endpoints
You can access API endpoints for authentication, successful emails

##### Login
To get access token
```
URL: domain/api/auth/login
METHOD: POST
JSON: {
    "email": "test@example.com",
    "password": "password"
}
```
##### Logout
To get access token
```
URL: domain/api/auth/logout
METHOD: POST
Authorization: Bearer XXXX
```
##### Get All records
By default it will give you latest collection of data limited to 10
```
URL: domain/api/successful-emails
METHOD: GET
Authorization: Bearer XXXX
```
Available parameters:
- paginate: to get the record in pagination
- page: (only if paginate)
- limit: 10 (default) to increase the record display

##### Store
Create new record on `successful_emails`
```
URL: domain/api/successful-emails
METHOD: POST
Authorization: Bearer XXXX
JSON: {
    "affiliate_id": 1 // required|integer,
    "envelope": "text" // required|string,
    "from": "text" // required|string|max 255 characters,
    "subject": "text" // required|string,
    "dkim": null // null|string,
    "SPF": "text" // required|string|max 255 characters,
    "spam_score": null // null|numeric,
    "email": "long text" // required|string,
    "raw_text": null // null|string (If not provided it will be filled base on email),
    "sender_ip": "127.0.0.1" // required|string|max 50 characters,
    "to": "target" // required|string
}
```
##### Show
Display the record information
```
URL: domain/api/successful-emails/{successfulEmailId}
METHOD: GET
Authorization: Bearer XXXX
```
##### Update
Update the record information
```
URL: domain/api/successful-emails/{successfulEmailId}
METHOD: PUT
Authorization: Bearer XXXX
JSON: {
    "affiliate_id": 1 // required|integer,
    "envelope": "text" // required|string,
    "from": "text" // required|string|max 255 characters,
    "subject": "text" // required|string,
    "dkim": null // null|string,
    "SPF": "text" // required|string|max 255 characters,
    "spam_score": null // null|numeric,
    "email": "long text" // required|string,
    "raw_text": null // null|string (If not provided it will be filled base on email),
    "sender_ip": "127.0.0.1" // required|string|max 50 characters,
    "to": "target" // required|string
}
```
##### Soft Delete
Soft delete the selected record
```
URL: domain/api/successful-emails/{successfulEmailId}
METHOD: DELETE
Authorization: Bearer XXXX
```
#### Scheduler
Run base on the set schedule
`php artisan schedule:work`

To display the list run the command below:
`php artisan schedule:list`

##### GetUnprocessedSuccessfulEmailJob
Run every: Hour
Description: It updates the `successful_emails.raw_text` base on the value of `successful_emails.email`
