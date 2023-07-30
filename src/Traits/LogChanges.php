<?php
// laravel-model-logs/src/Traits/LogsChanges.php

namespace Asif\LaravelModelLogs\Traits;

use Asif\LaravelModelLogs\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;


trait LogChanges
{
    public static function bootLogChanges()
    {
        $events = self::getTrackedEvents();

        if (in_array('created', $events)) {
            static::created(function (Model $model) {
                self::logChange($model, 'created');
            });
        }

        if (in_array('updated', $events)) {
            static::updated(function (Model $model) {
                self::logChange($model, 'updated');
            });
        }

        if (in_array('deleted', $events)) {
            static::deleted(function (Model $model) {
                self::logChange($model, 'deleted');
            });
        }
    }


    private static function logChange(Model $model, string $action)
    {
        $oldValues = ($action === 'created') ? null : $model->getOriginal();
        $newValues = ($action === 'deleted') ? null : $model->getAttributes();
        $userId = Auth::id();

        // Get the fields to be logged from the $loggable property
        $loggableFields = property_exists($model, 'loggable') ? $model->loggable : array_keys($model->getAttributes());


        // Filter the old and new values to include only the loggable fields
        $oldValues = Arr::only($oldValues ?? [], $loggableFields);
        $newValues = Arr::only($newValues ?? [], $loggableFields);

        AuditLog::create([
            'action' => $action,
            'model_type' => get_class($model),
            'model_id' => $model->getKey(),
            'old_values' => json_encode($oldValues),
            'new_values' => json_encode($newValues),
            'user_id' => $userId,
        ]);
    }

    private static function getTrackedEvents()
    {
        if (isset((new static)->trackedEvents) && is_array((new static)->trackedEvents)) {
            return (new static)->trackedEvents;
        }

        // Set a default value to track all events if $trackedEvents is not provided
        return ['created', 'updated', 'deleted'];
    }
}
