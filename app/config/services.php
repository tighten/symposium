<?php
return [
    'mailgun' => [
        'domain' => getenv('mailgun_domain'),
        'secret' => getenv('mailgun_secret'),
    ]
];
