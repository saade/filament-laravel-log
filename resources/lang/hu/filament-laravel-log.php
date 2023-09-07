<?php

return [
    'navigation' => [
        'group' => 'Rendszer',
        'label' => 'Hiba napló',
    ],

    'page' => [
        'title' => 'Hiba napló',

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
