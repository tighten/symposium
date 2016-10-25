<?php

// UUID-based models
$models = [\App\Models\Talk::class, App\Models\Conference::class, App\Models\TalkRevision::class, App\Models\Bio::class];

foreach ($models as $model) {
    $model::creating(function ($model) {
        $model->{$model->getKeyName()} = (string)\Rhumsaa\Uuid\Uuid::uuid4();
    });
}
