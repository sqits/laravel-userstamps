<?php

namespace Sqits\UserStamps\Concerns;

use Sqits\UserStamps\Observers\UserStampObserver;

trait HasUserStamps
{
    /**
     * Bootstrap the trait.
     *
     * @return void
     */
    public static function bootHasUserStamps()
    {
        static::observe(UserStampObserver::class);
    }

    /**
     * Get the user that created the model.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(
            config('userstamps.users_model'),
            config('userstamps.created_by_column')
        );
    }

    /**
     * Get the user that edited the model.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function editor()
    {
        return $this->belongsTo(
            config('userstamps.users_model'),
            config('userstamps.updated_by_column')
        );
    }

    /**
     * Get the user that deleted the model.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function destroyer()
    {
        return $this->belongsTo(
            config('userstamps.users_model'),
            config('userstamps.deleted_by_column')
        );
    }

    /**
     * Has the model loaded the SoftDeletes trait.
     *
     * @return bool
     */
    public function usingSoftDeletes()
    {
        return $usingSoftDeletes = in_array(
            'Illuminate\Database\Eloquent\SoftDeletes',
            class_uses_recursive(
                get_called_class()
            )
        );
    }
}
