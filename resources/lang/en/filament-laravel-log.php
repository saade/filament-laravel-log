<?php

return [
    'navigation' => [
        'label' => 'Logs',
    ],

    'page' => [
        'form' => [
            'placeholder' => 'Select or search a log file...',
        ],
    ],

    'actions' => [
        'clear' => [
            'label' => 'Clear',

            'modal' => [
                'heading' => 'Clear this log file?',
                'description' => 'Everything in the selected file will be deleted. This cannot be undone.',

                'actions' => [
                    'confirm' => 'Clear',
                ],
            ],
        ],

        'jumpToStart' => [
            'label' => 'Jump to Start',
        ],

        'jumpToEnd' => [
            'label' => 'Jump to End',
        ],

        'refresh' => [
            'label' => 'Refresh',
        ],
    ],

    'notifications' => [
        'unreadable' => 'The file could not be read.',
        'unwritable' => 'The file could not be cleared.',
    ],
];
