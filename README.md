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
Run to boot up development, create minio bucket, dynamodb table and composer install and etc.
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
