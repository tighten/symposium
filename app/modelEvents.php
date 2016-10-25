<?php

// UUID-based models
$models = ['App\Models\Talk', 'App\Models\Conference', 'TalkRevision', 'App\Models\Bio'];

foreach ($models as $model) {
    $model::creating(function ($model) {
        $model->{$model->getKeyName()} = (string)\Rhumsaa\Uuid\Uuid::uuid4();
    });
}
