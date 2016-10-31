<?php

// UUID-based models
$models = [\App\Talk::class, App\Conference::class, App\TalkRevision::class, App\Bio::class];

foreach ($models as $model) {
    $model::creating(function ($model) {
        $model->{$model->getKeyName()} = (string)\Rhumsaa\Uuid\Uuid::uuid4();
    });
}
