<?php

use craft\helpers\App;

return [
    '*' => [
        // Default Week Start Day (0 = Sunday, 1 = Monday...)
        'defaultWeekStartDay' => 1,

        // The maximum number of revisions that should be stored for each element. Set to 0 if you want to store an unlimited number of revisions.
        'maxRevisions' => 1,

        // Whether generated URLs should omit "index.php"
        'omitScriptNameInUrls' => true,

        // Control panel trigger word
        'cpTrigger' => App::env('CP_TRIGGER') ?? 'admin',

        // The secure key Craft will use for hashing and encrypting data
        'securityKey' => App::env('SECURITY_KEY'),

        // Disable CSRF protection
        'enableCsrfProtection' => true,

        'limitAutoSlugsToAscii' => true,

//        'useEmailAsUsername' => true,
    ],
    'dev' => [
        'devMode' => true,
        'runQueueAutomatically' => App::env('RUN_QUEUE_AUTOMATICALLY') ?? true,
    ],
    'production' => [
        // Set this to `false` to prevent administrative changes from being made on production
        'allowAdminChanges' => false,

        'allowUpdates' => false,

        'preventUserEnumeration' => true,
    ],
];
