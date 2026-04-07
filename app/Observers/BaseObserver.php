<?php

// app/Observers/BaseObserver.php
namespace App\Observers;

use App\Services\ActivityLogger;

class BaseObserver
{
    protected string $module;
    protected string $titleField; // which field to use as the label

    public function __construct(string $module, string $titleField = 'title')
    {
        $this->module     = $module;
        $this->titleField = $titleField;
    }

    public function created($model): void
    {
        ActivityLogger::log(
            'created',
            $this->module,
            "Created {$this->module}: " . $model->{$this->titleField},
            $model
        );
    }

    public function updated($model): void
    {
        $changes = array_keys($model->getChanges());

        // skip if only timestamps changed
        if ($changes === ['updated_at']) return;

        ActivityLogger::log(
            'updated',
            $this->module,
            "Updated {$this->module}: " . $model->{$this->titleField},
            $model,
            [
                'changed'  => $model->getChanges(),
                'original' => array_intersect_key($model->getOriginal(), $model->getChanges()),
            ]
        );
    }

    public function deleted($model): void
    {
        ActivityLogger::log(
            'deleted',
            $this->module,
            "Deleted {$this->module}: " . $model->{$this->titleField},
            $model
        );
    }
}
