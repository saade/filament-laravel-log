<?php

return [
    'navigation' => [
        'label' => 'Hiba napló',
    ],

    'page' => [
        'form' => [
            'placeholder' => 'Fájl keresése vagy kiválasztása...',
        ],
    ],

    'actions' => [
        'clear' => [
            'label' => 'Törlés',

            'modal' => [
                'heading' => 'Törölhető a hiba napló?',
                'description' => 'A művelet utólag nem vonható vissza.',

                'actions' => [
                    'confirm' => 'Törlés',
                ],
            ],
        ],

        'jumpToStart' => [
            'label' => 'Ugrás az elejére',
        ],

        'jumpToEnd' => [
            'label' => 'Ugrás a végére',
        ],

        'refresh' => [
            'label' => 'Frissítés',
        ],
    ],
];
