<?php

namespace Sqits\UserStamps\Tests;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Sqits\UserStamps\Tests\Models\User;
use Illuminate\Database\Schema\Blueprint;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return ['Sqits\UserStamps\UserStampsServiceProvider'];
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
