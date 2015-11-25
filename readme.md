Framgia E-learning System
=========

Installation and Requirements
------------
For local development, we use [Homestead](http://laravel.com/docs/5.1/homestead) which is a pre-packaged vagrant box.
Some basic requirements for this project are listed below:
* PHP version >= 5.5.9
* Laravel Framework version 5.1.* (LTS)
* PostgreSQL version 9.4.* (or MySQL version 5.7.*)
* PHP [GD](http://php.net/manual/en/book.image.php) extension.
* NodeJS, NPM, Bower, Gulp, Composer, etc. (no need to worry about these if you're using Homestead)

> For more information about installing framework and Homestead, refer to
[Installation Guides](http://laravel.com/docs/5.1/installation) and
[Homestead Documentation](http://laravel.com/docs/5.1/homestead).

> Homestead box on [Vagrant Cloud](https://atlas.hashicorp.com/laravel/boxes/homestead).

:bulb: __Tips__: On Windows OS, you may want to set some system environment variables to
quickly boot up Homestead virtual machine. Suppose that your [cloned Homestead](https://github.com/laravel/homestead)
directory is stored at __C:\Users\<your_name>\Homestead__ then you may add two new environment variables as following:

| Variables     | Content                                                      |
| :------------ |:-------------------------------------------------------------|
| hson          | cd C:\Users\<your_name>\Homestead & vagrant up & vagrant ssh |
| hsoff         | vagrant halt & exit                                          |

> By setting up these system environment variables, you don't need to remember the location
of Homestead's directory as well as to make a bunch of boring commands in order to boot up
the virtual machine.

###### General Workflow
* To boot up Homestead virtual machine, just fire up Command Prompt and run `%hson%`.
* To shutdown Homestead virtual machine:
    - Run `exit` command from the inside of virtual machine to terminate current SSH session.
    - Run `%hsoff%` to shutdown virtual machine, and close Command Prompt.

> :dizzy_face: Installing Homestead on Windows OS is a 'messy process', you may need to try
several times to reach for success. Some common problems are incompatible Virtual Box version
and timeout SSH operations.

Dependencies & Configurations
------------
### Back-end Dependencies
All back-end dependencies can be viewed in `composer.json` file which is located
at the project's root directory. Normally, there are two types of dependency:
production-related and development-related dependencies which are declared in
`require` object and `require-dev` object respectively. Let's take a closer look at each dependency (package).

#### Production-related Dependencies
* [laravel/socialite](https://packagist.org/packages/laravel/socialite) (version ~2.0):
this is an optional package of the Laravel Framework which provides an expressive interface
to work with OAuth authentication. In this project, we utilize this package to build a simple
OAuth authentication system with three providers: _GitHub_, _Facebook_, and _Google_.
All providers were tested successfully in local environment; however, we still encounter some
_unexpected problems_ in production environment.
* [laravelcollective/html](http://laravelcollective.com/docs/5.1/html) (version 5.1.*):
the `illuminate/html` component was deprecated since version 5.0 of the Laravel framework, and it was
removed from the core of the framework and no longer be maintained officially in later versions.
In this project we use an alternative version of that component which is maintained by
[Laravel Collective](http://laravelcollective.com/).
This package provides a quick way to build up HTML components (two core classes of this package
are `HtmlBuilder` and `FormBuilder`), especially, form-related things. Also in this project,
we extend this package to add our custom form macros by overriding the `HtmlServiceProvider`
class from the package to user our custom `FormBuilder` class (this class extends the original
`FormBuilder` class).
* [laracasts/flash](https://packagist.org/packages/laracasts/flash) (version ~1.3):
this package provides an easy solution for displaying flashed messages.
* [laracasts/utilities](https://packagist.org/packages/laracasts/utilities) (version ~2.0):
this package is used to pass data (simple variables, array, or objects) from server-side (PHP)
to JavaScript. We utilize it in this project to pass dynamically calculated duration of lessons
to JQuery to make the countdown timer taking effect.
* [laracasts/presenter](https://packagist.org/packages/laracasts/presenter) (version ^0.2.1):
this package provides a simple way to create model presenters (isolating view-related things from model).
* [doctrine/dbal](https://packagist.org/packages/doctrine/dbal) (version ~2.5):
this package is required by the framework when working with some database operations such as
`renameColumn` and `dropColumn` in creating migrations.
* [guzzlehttp/guzzle](https://packagist.org/packages/guzzlehttp/guzzle) (version ~5.3|~6.0):
[Mailgun](https://mailgun.com/) is a third-party services used for sending e-mails throughout this project in production.
_Guzzle HTTP library_ is required in order to make Mailgun function properly.
* [cviebrock/eloquent-sluggable](https://packagist.org/packages/cviebrock/eloquent-sluggable) (version ~3.0.0):
this package is used to create unique slugs for model instances such as `User` and `Category`.
Models that utilize this package contain an overridden method from the `Model` super class:
```php
    public function getRouteKey()
    {
        return $this->slug;
    }
```
By overriding this method, we instruct the framework to use `slug` as the route parameter rather than the default `id`.

* [maatwebsite/excel](http://www.maatwebsite.nl/laravel-excel/docs) and [dompdf/dompdf](https://packagist.org/packages/dompdf/dompdf):
these packages are used for importing and exporting Eloquent collection.
* [bugsnag/bugsnag-laravel](https://packagist.org/packages/bugsnag/bugsnag-laravel) (version 1.*):
in this project, we use [Bugsnag](https://bugsnag.com/) service for error-tracking. It is extremely helpful
when we need to track errors and exceptions that occur in the deployed application.
* [intervention/image](http://image.intervention.io/) and [intervention/imagecache](http://image.intervention.io/use/cache):
these packages are used for processing image (avatar processing in our project).
* [fzaninotto/faker](https://github.com/fzaninotto/Faker) (version ~1.4):
normally, this package is a development dependency used to generate random data. However, we put this package
as a production dependency for some special purposes.
* [ext-gd](http://docs.php.net/manual/en/book.image.php):
we use GD extension of PHP for image processing operations. This package is used by Heroku so that those
operations will function properly.
* [iron-io/iron_mq](https://packagist.org/packages/iron-io/iron_mq) and [predis/predis](https://packagist.org/packages/predis/predis):
these two optional packages are required only when we use custom queue and cache drivers.

#### Development-related Dependencies
The following packages are use for testing and debugging purposes only, and they are optional for installation.
Here is the list of those packages:
* [mockery/mockery](http://docs.mockery.io/en/latest/)
* [phpunit/phpunit](https://phpunit.de/)
* [phpspec/phpspec](http://phpspec.readthedocs.org/en/latest/)
* [behat/behat](http://docs.behat.org/en/v2.5/)
* [behat/mink](https://packagist.org/packages/behat/mink)
* [behat/mink-extension](https://packagist.org/packages/behat/mink-extension)
* [laracasts/behat-laravel-extension](https://packagist.org/packages/laracasts/behat-laravel-extension)
* [barryvdh/laravel-debugbar](https://github.com/barryvdh/laravel-debugbar)

### Front-end Dependencies
#### Bower
For greater flexibility, we use [Bower](http://bower.io/) to manage our front-end dependencies.
Bower requires NodeJS to be installed globally first (for more details about NodeJS installation
[click here](https://nodejs.org/en/download/)). To install Bower globally, run this command:
`sudo npm install -g bower` Fortunately, if we use Homestead, all of these softwares
have already been installed out of the box.

##### Integrate Bower with Laravel Application
Firstly, we need to create two files in project's root directory: `.bowerrc` and `bower.json`
* `.bowerrc` is an optional file. This file tells Bower to place downloaded packages into the
custom vendor directory. If we skip this file then Bower will create a directory named __bower_dl__
in the root directory and store items here. In this project, all Bower dependencies are store
at __vendor/bower-components__ directory. The content of `.bowerrc` file is shown below:
```
{
    "directory": "vendor/bower-components"
}
```
* `bower.json` file is used by Bower to keep track of packages to maintain. Think of `bower.json`
as `composer.json` but used for front-end dependency management. This file can be generated using
`bower init` command. Below is the content of `bower.json` file for this project:
```
{
    "name": "FELS",
    "description": "Framgia E-learning System",
    "dependencies": {
        "jquery": "~2.1.4",
        "bootstrap": "~3.3.5",
        "bootstrap-social": "~4.10.1",
        "font-awesome": "~4.4.0",
        "sweetalert": "~1.1.0",
        "jquery.countdown": "~2.1.0"
    }
}
```
##### Some Important Bower Commands
* `bower init`: interactively creates a `bower.json` file.
* `bower install [<options>]`: installs the project dependencies.
* `bower lookup <name>`: looks up a package URL by name.
* `bower search <name>`: finds all packages or a specific package.
* `bower update <name> [<name> ..] [<options>]`: updates installed packages to their newest version.

##### The General Workflow:
* Initialize `bower.json` file using `bower init` command (do this only one time).
* Search for packages using `bower lookup` (if we know the URL of the package) or
`bower search` (if we don't know exactly the package's name).
* After choosing the right package, use `bower install --save` to install the package.
The `--save` option is used to place package name and version inside the `bower.json` file.
* Run `bower update` to update packages to their newest version, if necessary.

> For a complete list of all Bower commands [click here](http://bower.io/docs/api/).

##### List of packages maintained by Bower in this project
* [jQuery](http://jquery.com/)
* [Twitter Bootstrap](http://getbootstrap.com/)
* [Bootstrap Social](http://lipis.github.io/bootstrap-social/)
* [Font Awesome](https://fortawesome.github.io/Font-Awesome/)
* [Sweet Alert](http://t4t5.github.io/sweetalert/)
* [jQuery Countdown](http://hilios.github.io/jQuery.countdown/)

> Refer to documentation of above packages to get more details about them.

#### Elixir and Gulp
##### Overview of Elixir
[Laravel Elixir](http://laravel.com/docs/5.1/elixir) is a wrapper around [Gulp](http://gulpjs.com/).
Traditionally, we need to define a bunch of _complicated gulp tasks_ in `gulpfile.js` for compiling, concatenating,
minimizing, and versioning assets. With the help of Elixir, all of these tedious tasks can be performed
in a much cleaner and more fluent way. Elixir is not a requirement for a Laravel project, but it's
recommended to use Elixir to ease the process of working with raw assets (SASS, CoffeScript, LESS, etc.).

Read more about Elixir on [Elixir Documentation](http://laravel.com/docs/5.1/elixir)

##### Installation
* Install NodeJS ([more information here](https://nodejs.org/en/download/)).
* Install _Gulp_ globally using NodeJS package management `npm` by run this command: `npm install --global gulp`.
* The `package.json` file included with the framework is convenient place to define our Node dependencies.
This file has already defined `gulp` and `laravel-elixir` dependencies by default.
* Install Elixir by running one of the following commands (all dependencies will be stored at __node_modules__ directory by default):
    - `npm install`
    - `npm install --no-bin-links` (for Windows OS)
* Important Elixir (Gulp) commands:
    - `gulp`: runs all tasks defined in the `gulpfile.js`.
    - `gulp --production`: runs all tasks defined in the `gulpfile.js` and minimizes compiled assets.
    - `gulp watch`: watches assets for changes and runs associated tasks, if necessary.

> :cry: Installing Gulp and Elixir on Windows OS is an 'awkward process'. Many unexpected exceptions and errors
could happen in the installation process. However, it is not impossible to run Elixir on Windows environment
(all you need is patience).

##### Configure gulpfile.js
Here is content of the `gulpfile.js` used in this project:

```javascript
var elixir = require('laravel-elixir');

elixir(function (mix) {
    mix.sass('app.sass', 'public/css');

    mix.styles([
        'bootstrap/dist/css/bootstrap.min.css',
        'bootstrap-social/bootstrap-social.css',
        'font-awesome/css/font-awesome.min.css',
        'sweetalert/dist/sweetalert.css'
    ], 'public/css/vendor.css', 'vendor/bower-components');

    mix.styles([
        'vendor.css',
        'app.css'
    ], null, 'public/css');

    mix.coffee('app.coffee', 'public/js');

    mix.scripts([
        'jquery/dist/jquery.min.js',
        'bootstrap/dist/js/bootstrap.min.js',
        'sweetalert/dist/sweetalert.min.js',
        'jquery.countdown/dist/jquery.countdown.min.js'
    ], 'public/js/vendor.js', 'vendor/bower-components');

    mix.scripts([
        'vendor.js',
        'app.js'
    ], null, 'public/js');

    mix.version([
        'public/css/all.css',
        'public/js/all.js'
    ]);
});
```
##### There are 7 main steps when writing this `gulpfile.js` file:
1. `mix.sass('app.sass', 'public/css')`: compiles SASS (.sass syntax) into regular CSS (`app.css` file)
and places compiled file in __public/css__ directory.
2. `mix.styles([...], 'public/css/vendor.css', 'vendor/bower-components')`: concatenates downloaded
assets by Bower into a single file called `vendor.css`, and places this file in __public/css__ directory.
Note that the third argument of the `styles()` method indicates the base directory where Bower dependencies
are installed (__vendor/bower-components__ in this case).
3. `mix.styles(['vendor.css', 'app.css'], null, 'public/css')`: concatenates `app.css` and `vendor.css` in
__public/css__ directory into a single file called `all.css`. Note that the order of files in the first
argument of `styles()` method is important.
4. `mix.coffee('app.coffee', 'public/js')`: compiles CoffeeScript into regular JavaScript (`app.js` file)
and places compiled file in __public/js__ directory.
5. `mix.scripts([...], 'public/js/vendor.js', 'vendor/bower-components')`: the same as step 2 but for JavaScript dependencies.
6. `mix.scripts(['vendor.js', 'app.js'], null, 'public/js')`: concatenates `app.js` and `vendor.js` in __public/js__
directory into a single file called `all.js`. Note that the order of files in the first argument of `scripts()`
method is important.
7. `mix.version(['public/css/all.css', 'public/js/all.js'])`: versions final asset files `all.css` and `all.js`
to allow for cache-busting.

> To get more more information about Elixir and its APIs, refer to [Elixir Documentation](http://laravel.com/docs/5.1/elixir).

### Other Configurations
#### Application Service Provider
Some of global configurations for the project are defined in `AppServiceProvider.php` class
(read more about Laravel [Service Provider](http://laravel.com/docs/5.1/providers)).
The most important method in this class is `configureEnvironments()` where we set different
configurations for different application environments, including: __production__, __local__, and __testing__.
* __Production environment__: we define a method called `configurePostgreSQL()`
that parses the __DATABASE URL__ given by Heroku.
* __Local environment__: we define a method called `logDatabaseQueries()` to
log all database queries that are executed in project, by listening for
`illuminate.query` event. We also register the __DebugBar__ package's service provider here
because we don't want to enable this package for production.
* __Testing environment__: when testing our application, Laravel will automatically
set the application environment to __testing__. All we've done here is to set the database driver to __sqlite__.

##### Environment File (.env)
Environment file is a good place to store sensitive information such as, API keys,
database credentials, secret tokens, etc. `.env.example` file at the root directory
is a template for all environment variables used in this project. When we deploy
application to Heroku, we need to set all environment variables according to template
provided in that file.

> For more information about environment configuration, check the
[Documentation](http://laravel.com/docs/5.1/installation#environment-configuration).

#### Migrations and Seeders
##### Migrations
We followed [instructions](http://laravel.com/docs/5.1/migrations) from the official documentation to write migrations.

##### Seeders
###### Model Factory
Before generating random records and inserting them into database tables
for testing our application. We need to define how model instances will
be populated. [ModelFactory](https://github.com/framgia/fels_78/blob/develop/database/factories/ModelFactory.php)
file serves that purpose; the content of this file is fairly simple, all
we need to concern with is to use Faker library to settle down definition
for each attribute of models.

> For more information about Model Factory, check the [Documentation](http://laravel.com/docs/5.1/testing#model-factories).

###### DatabaseSeeder Class
The [DatabaseSeeder](https://github.com/framgia/fels_78/blob/develop/database/seeds/DatabaseSeeder.php)
class will be called by the framework when we run the command `php artisan db:seed` without
`--class` option. In this project we modified the default [DatabaseSeeder](https://github.com/laravel/laravel/blob/master/database/seeds/DatabaseSeeder.php) class shipped with the framework. These changes include:
* The `$tables` field is an array of table names that we want to seed.
* The `$seeders` field is an array of all seeder classes that will be called by _DatabaseSeeder_ class.
* The `truncateDatabase()` method is used to truncate all database tables when we re-seed them (note that this method works only with MySQL).
* The `run()` method (an overridden method from [Seeder](https://github.com/laravel/framework/blob/5.1/src/Illuminate/Database/Seeder.php) super class) utilizes [Model::unguard()](http://laravel.com/api/5.1/Illuminate/Database/Eloquent/Model.html#method_unguard) and [Model::reguard()](http://laravel.com/api/5.1/Illuminate/Database/Eloquent/Model.html#method_reguard) static methods from [Model](https://github.com/laravel/framework/blob/5.1/src/Illuminate/Database/Eloquent/Model.php) class to disable / enable the mass assignment restrictions. Inside that method, we also check the current database connection and decide whether to call `truncateDatabase()` or not. Finally, we loop through all seeder classes and call them accordingly.

###### Seeder Class
In this project, we use two seeder classes: [UsersTableSeeder](https://github.com/framgia/fels_78/blob/develop/database/seeds/UsersTableSeeder.php) and [CategoriesTableSeeder](https://github.com/framgia/fels_78/blob/develop/database/seeds/CategoriesTableSeeder.php) to populate all possible tables in the database for testing and debugging purposes.

> For more information about how to write seeder class, check the [Documentation](http://laravel.com/docs/5.1/seeding#writing-seeders)

###### Running Seeder Classes
To run seeders, we can use one of the following commands:
* `php artisan db:seed`: runs all available seeder classes.
* `php artisan db:seed --class=<seeder_class>`: runs a custom seeder class, not all.
* `php artisan migrate:refresh --seed`: rolls back all migration classes, migrates them again, and seeds the database.

Deployment
------------
For deployment, we use [Heroku](https://heroku.com/) platform with a free plan. In the upcoming sections, we'll describe in details each step in the deployment process:

> For more information about deploying a PHP application to Heroku, [click here](https://devcenter.heroku.com/articles/getting-started-with-php).
> It's recommended to use _Git Bash_ as console application to work with Heroku.

#### Heroku Configurations
* As the first step, we need to register a free account on Heroku, and access our personal [Dashboard](https://dashboard.heroku.com/apps) which contains our applications.
* Install [Heroku Toolbelt](https://toolbelt.heroku.com/) which provides a CLI to work with Heroku server.
* Create a new application on Heroku.

#### Application Configurations
* By default, all application source codes are placed on `develop` branch; however, Heroku only works with `master` branch. As a result, we need to rebase `develop` branch to `master` branch.
    - `git checkout master`
    - `git rebase develop`
* Login to Heroku in CLI by running `heroku login` command.
* Add Heroku remotely tracked repository by running `heroku git:remote -a <your_app_name>` command.
* Add __Procfile__ to the project's root directory with the content `web: vendor/bin/heroku-php-apache2 public/`, and commit the changes.
* Install Heroku [PHP Buildpack](https://github.com/heroku/heroku-buildpack-php) by running `heroku buildpacks:set https://github.com/heroku/heroku-buildpack-php` command. The purpose of this step is to make sure that Heroku detects the right application type (PHP application in this case). This step is important because Heroku will detect our Laravel application as a NodeJS application by default (our application includes the `package.json` file !!!).
* Install PostgresSQL add-on with a free plan (10.000 records) for our application, [click here](https://elements.heroku.com/addons/heroku-postgresql) for more information. After installing this add-on, Heroku will automatically set __DATABASE URL__ environment variable for our application. Fortunately, our __AppServiceProvider__ class has a method which is responsible to parse this URL and set the proper database credentials such as __DATABASE USERNAME__, __DATABASE HOST__, __DATABASE PASSWORD__, etc environment variables.
* Set remaining environment variables for our Heroku application according to __.env__ file in the project.
* Re-compile all assets (if necessary) by running `gulp --production`, remove `public/build`, `public/css`, and `public/js` from the `.gitignore` file, and commit all changes.
* Push our application to Heroku by running `git push heroku master`.
* Migrate database remotely by running `heroku run 'php artisan migrate'`.
* Run seeders remotely (for testing purpose only) by running the following commands:
    - `heroku run 'php artisan db:seed --class=UsersTableSeeder'`
    - `heroku run 'php artisan db:seed --class=CategoriesTableSeeder'`
* Ensure that at least one instance of the application is running by executing this command `heroku ps:scale web=1`.
* Optimize the Laravel application by running `heroku run 'php artisan optimize'`.
* Cache application routes by running `heroku run 'php artisan route:cache'`.
* Cache application configuration files by running `heroku run 'php artisan config:cache'`.
* Open deployed application in browser by running `heroku open`.

#### Deployed Application
A demo application can be accessed [here](http://fels-78.herokuapp.com/).
