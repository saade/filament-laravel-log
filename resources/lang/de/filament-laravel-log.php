<?php

return [
    'navigation' => [
        'group' => 'System',
        'label' => 'Logs',
    ],

    'page' => [
        'title' => 'Logs',

        'form' => [
            'placeholder' => 'Logfile auswählen oder suchen...',
        ],
    ],

    'actions' => [
        'clear' => [
            'label' => 'Leeren',

            'modal' => [
                'heading' => 'Alle Logs leeren?',
                'description' => 'Sind Sie sicher, dass Sie alle Logs leeren möchten?',

                'actions' => [
                    'confirm' => 'Leeren',
                ],
            ],
        ],

        'jumpToStart' => [
            'label' => 'Springe zum Anfang',
        ],

        'jumpToEnd' => [
            'label' => 'Springe zum Ende',
        ],

        'refresh' => [
            'label' => 'Neu laden',
        ],
    ],
];
