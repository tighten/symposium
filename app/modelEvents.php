<?php

// UUID-based models
$models = ['Talk', 'Conference', 'TalkVersion', 'TalkVersionRevision'];

foreach ($models as $model) {
    $model::creating(function ($model) {
        $model->{$model->getKeyName()} = (string)\Rhumsaa\Uuid\Uuid::uuid4();
    });
}
