<?php

namespace Sqits\UserStamps\Database\Schema\Macros;

use Illuminate\Database\Schema\Blueprint;

class UserStampsMacro implements MacroInterface
{

    /**
     * Bootstrap the schema macro.
     *
     * @return void
     */
    public function register()
    {
        $this->registerUserstamps();
        $this->registerSoftUserstamps();
        $this->registerDropUserstamps();
        $this->registerDropSoftUserstamps();
    }

    private function registerUserstamps()
    {
        Blueprint::macro('userstamps', function () {
            $this->unsignedInteger(config('userstamps.created_by_column'))->nullable();
            $this->unsignedInteger(config('userstamps.updated_by_column'))->nullable();

            $this->foreign(config('userstamps.created_by_column'))
                ->references('id')
                ->on(config('userstamps.users_table'))
                ->onDelete('set null');

            $this->foreign(config('userstamps.updated_by_column'))
                ->references('id')
                ->on(config('userstamps.users_table'))
                ->onDelete('set null');

            return $this;
        });
    }

    private function registerSoftUserstamps()
    {
        Blueprint::macro('softUserstamps', function () {
            $this->unsignedInteger(config('userstamps.deleted_by_column'))->nullable();

            $this->foreign(config('userstamps.deleted_by_column'))
                ->references('id')
                ->on(config('userstamps.users_table'))
                ->onDelete('set null');

            return $this;
        });
    }

    private function registerDropUserstamps()
    {
        Blueprint::macro('dropUserstamps', function () {
           $this->dropForeign([
               config('userstamps.created_by_column'),
           ]);

            $this->dropForeign([
                config('userstamps.updated_by_column'),
            ]);

           $this->dropColumn(config('userstamps.created_by_column'));
           $this->dropColumn(config('userstamps.updated_by_column'));
        });
    }

    private function registerDropSoftUserstamps()
    {
        Blueprint::macro('dropSoftUserstamps', function () {
            $this->dropForeign([
                config('userstamps.deleted_by_column'),
            ]);

            $this->dropColumn(config('userstamps.deleted_by_column'));
        });
    }

}