<?php

namespace Sqits\UserStamps\Tests;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Sqits\UserStamps\Tests\Models\User;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{

    protected function getPackageProviders($app)
    {
        return ['Sqits\UserStamps\UserStampsServiceProvider'];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.connections.mysql', [
            'driver' => 'mysql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'testing'),
            'username' => env('DB_USERNAME', 'travis'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ]);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpDatabase();
    }

    protected function setUpDatabase()
    {
        Config::set('userstamps.users_model', User::class);

        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();

            $table->timestamps();
        });

        Schema::create('laravel_userstamps', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');

            $table->timestamps();
            $table->softDeletes();

            $table->userstamps();
            $table->softUserstamps();
        });
    }

}
