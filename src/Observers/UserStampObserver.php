<?php

namespace Sqits\UserStamps\Observers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class UserStampObserver
{
    /**
     * Handle to the User "creating" event.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function creating(Model $model)
    {
        $model->{config('userstamps.created_by_column')} = Auth::id();
        $model->{config('userstamps.updated_by_column')} = Auth::id();
    }

    /**
     * Handle to the User "updating" event.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function updating(Model $model)
    {
        $model->{config('userstamps.updated_by_column')} = Auth::id();
    }

    /**
     * Handle to the User "deleting" event.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function deleting(Model $model)
    {
        if ($model->usingSoftDeletes()) {
            $model->{config('userstamps.deleted_by_column')} = Auth::id();
            $model->{config('userstamps.updated_by_column')} = Auth::id();
            $this->saveWithoutEventDispatching($model);
        }
    }

    /**
     * Handle to the User "restoring" event.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function restoring(Model $model)
    {
        if ($model->usingSoftDeletes()) {
            $model->{config('userstamps.deleted_by_column')} = null;
            $model->{config('userstamps.updated_by_column')} = Auth::id();
            $this->saveWithoutEventDispatching($model);
        }
    }

    /**
     * Saves a model by igoring all other event dispatchers.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return bool
     */
    private function saveWithoutEventDispatching(Model $model)
    {
        $eventDispatcher = $model->getEventDispatcher();

        $model->unsetEventDispatcher();
        $saved = $model->save();
        $model->setEventDispatcher($eventDispatcher);

        return $saved;
    }
}
