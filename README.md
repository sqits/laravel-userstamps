# Package to maintain the users who created, updated and deleted eloquent models

Provides an Eloquent trait to automatically maintain the created_by, updated_by, and deleted_by (when using softDeletes)
on your models by the currently logged in user.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/sqits/laravel-userstamps.svg?style=flat-square)](https://packagist.org/packages/sqits/laravel-userstamps)
[![Build Status](https://img.shields.io/travis/sqits/laravel-userstamps/master.svg?style=flat-square)](https://travis-ci.org/sqits/laravel-userstamps)
[![Quality Score](https://img.shields.io/scrutinizer/g/sqits/laravel-userstamps.svg?style=flat-square)](https://scrutinizer-ci.com/g/sqits/laravel-userstamps)
[![StyleCI](https://github.styleci.io/repos/180816659/shield)](https://styleci.io/repos/180816659)
[![Total Downloads](https://img.shields.io/packagist/dt/sqits/laravel-userstamps.svg?style=flat-square)](https://packagist.org/packages/sqits/laravel-userstamps)

## Installation and usage

This package requires PHP 7.2 and Laravel 5.6 or higher. Install the package by running the following command in your console;

``` bash
composer require sqits/laravel-userstamps
```

You can publish the config file with:

``` bash
php artisan vendor:publish --provider="Sqits\UserStamps\UserStampsServiceProvider" --tag="config"
```

This is the contents of the published config file:

``` php
return [

    /*
     * Define the table which is used in the database to retrieve the users
     */

    'users_table' => 'users',
    
    /*
     * Define the table column type which is used in the table schema for
     * the id of the user
     *
     * Options: increments, bigIncrements, uuid
     * Default: bigIncrements
     */

    'users_table_column_type' => 'bigIncrements',

    /*
     * Define the name of the column which is used in the foreign key reference
     * to the id of the user
     */

    'users_table_column_id_name' => 'id',
    
    /*
     * Define the mmodel which is used for the relationships on your models
     */
    
    'users_model' => \App\User::class,
    
    /*
     * Define the column which is used in the database to save the user's id
     * which created the model.
     */

    'created_by_column' => 'created_by',

    /*
     * Define the column which is used in the database to save the user's id
     * which updated the model.
     */

    'updated_by_column' => 'updated_by',

    /*
     * Define the column which is used in the database to save the user's id
     * which deleted the model.
     */

    'deleted_by_column' => 'deleted_by',

];
```

Add the macro to your migration of your model

``` php
public function up()
{
    Schema::create('table_name', function (Blueprint $table) {
        ...

        $table->userstamps();
        $table->softUserstamps();
    });
}   
```

Add the Trait to your model

``` php
use Sqits\UserStamps\Concerns\HasUserStamps;

class Example extends Model {

    use HasUserStamps;
}
```

There will be methods available to retrieve the user object which performs the action for creating, updating or deleting

``` php
$model->author; // the user who created the model
$model->editor; // the user who last updated the model
$model->destroyer; // the user who deleted the model
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Security

If you discover any security-related issues, please [email](mailto:info@sqits.nl) to info@sqits.nl instead of using the issue tracker.

## Credits

- [Sqits](https://github.com/sqits)
- [Ruud Schaaphuizen](https://github.com/rschaaphuizen)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
