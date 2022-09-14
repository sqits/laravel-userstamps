<?php

namespace Sqits\UserStamps\Database\Schema\Macros;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\SQLiteConnection;
use Illuminate\Support\Facades\DB;

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
            if (config('userstamps.users_table_column_type') === 'bigIncrements') {
                $this->unsignedBigInteger(config('userstamps.created_by_column'))->nullable();
                $this->unsignedBigInteger(config('userstamps.updated_by_column'))->nullable();
            } elseif (config('userstamps.users_table_column_type') === 'uuid') {
                $this->uuid(config('userstamps.created_by_column'))->nullable();
                $this->uuid(config('userstamps.updated_by_column'))->nullable();
            } else {
                $this->unsignedInteger(config('userstamps.created_by_column'))->nullable();
                $this->unsignedInteger(config('userstamps.updated_by_column'))->nullable();
            }

            $this->foreign(config('userstamps.created_by_column'))
                ->references(config('userstamps.users_table_column_id_name'))
                ->on(config('userstamps.users_table'))
                ->onDelete('no action');

            $this->foreign(config('userstamps.updated_by_column'))
                ->references(config('userstamps.users_table_column_id_name'))
                ->on(config('userstamps.users_table'))
                ->onDelete('no action');

            return $this;
        });
    }

    private function registerSoftUserstamps()
    {
        Blueprint::macro('softUserstamps', function () {
            if (config('userstamps.users_table_column_type') === 'bigIncrements') {
                $this->unsignedBigInteger(config('userstamps.deleted_by_column'))->nullable();
            } elseif (config('userstamps.users_table_column_type') === 'uuid') {
                $this->uuid(config('userstamps.deleted_by_column'))->nullable();
            } else {
                $this->unsignedInteger(config('userstamps.deleted_by_column'))->nullable();
            }

            $this->foreign(config('userstamps.deleted_by_column'))
                ->references(config('userstamps.users_table_column_id_name'))
                ->on(config('userstamps.users_table'))
                ->onDelete('no action');

            return $this;
        });
    }

    private function registerDropUserstamps()
    {
        Blueprint::macro('dropUserstamps', function () {
            if (! DB::connection() instanceof SQLiteConnection) {
                $this->dropForeign([
                    config('userstamps.created_by_column'),
                ]);
            }

            if (! DB::connection() instanceof SQLiteConnection) {
                $this->dropForeign([
                    config('userstamps.updated_by_column'),
                ]);
            }

            $this->dropColumn([
                config('userstamps.created_by_column'),
                config('userstamps.updated_by_column'),
            ]);
        });
    }

    private function registerDropSoftUserstamps()
    {
        Blueprint::macro('dropSoftUserstamps', function () {
            if (! DB::connection() instanceof SQLiteConnection) {
                $this->dropForeign([
                    config('userstamps.deleted_by_column'),
                ]);
            }

            $this->dropColumn(config('userstamps.deleted_by_column'));
        });
    }
}
