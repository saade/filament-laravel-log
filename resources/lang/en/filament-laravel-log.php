<?php

return [
    'navigation' => [
        'group' => 'System',
        'label' => 'Logs',
    ],

    'page' => [
        'title' => 'Logs',

        'form' => [
            'placeholder' => 'Select or search a log file...',
        ],
    ],

    'actions' => [
        'clear' => [
            'label' => 'Clear',

            'modal' => [
                'heading' => 'Clear Site Logs?',
                'description' => 'Are you sure you want to clear all site logs?',

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
];
