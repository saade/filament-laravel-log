<?php

return [
    'navigation' => [
        'group' => 'Systeem',
        'label' => 'Logboeken',
    ],

    'page' => [
        'title' => 'Logboeken',

        'form' => [
            'placeholder' => 'Selecteer of zoek een logbestand...',
        ],
    ],

    'actions' => [
        'clear' => [
            'label' => 'wissen',

            'modal' => [
                'heading' => 'Sitelogboeken wissen?',
                'description' => 'Weet u zeker dat u alle sitelogboeken wilt wissen??',

                'actions' => [
                    'confirm' => 'wissen',
                ],
            ],
        ],

        'jumpToStart' => [
            'label' => 'Ga naar Start',
        ],

        'jumpToEnd' => [
            'label' => 'Spring naar einde',
        ],

        'refresh' => [
            'label' => 'Vernieuwen',
        ],
    ],
];
