# Visitors
simple bundle for laravel, that write into db connections into site

## Content
* [installing](#installing)
* [configuring](#configuring)
* [usage](#usage)

## Installing
Insert package into your laravel project. <br>
Example path:
```
/laravel-project
- app
...
- bundles/sawfly/visitors
```
Now visitors ready for usage after configuring.

## Configuring
### Simplest usage
In any case of usage you must run in console:
1. Edit `config/app.php`. Add `Sawfly\Visitors\SawflyVisitorsServiceProvider::class,` in `'providers' => [...]`.
2. Edit `composer.json`. Add `"Sawfly\\Visitors\\": "bundles/sawfly/visitors/src/"` in `"psr-4": {...}`.
3. Run `php artisan vendor:publish`.
4. Run `composer dump-autoload`.
5. Run `php artisan migrate`.
### Using middleware
6. Edit `app/Http/Kernel.php`. Add `\Sawfly\Visitors\Middleware\Connection::class,` in `'protected $middlewareGroups = ['web' => [...]]`.
### Using task schedule
7. Edit `app/Console/Kernel.php`. Add `\Sawfly\Visitors\Console\Commands\VisitorsCount::class,` in `'protected $commands = [...]`. Add `$schedule->command('visitors:count')->dailyAt('00:00');` in `'protected function schedule(Schedule $schedule){...}`.

## Usage 
 * You may directly fire event (configuring steps 1-5):
 `Event::fire(new ConnectionEvent($request));` ;
 * Every request to you app will persist into table visitors (step 6);
 * Once a day rows from visitors will be count and this count will be persisted into table statistics (step 7).
