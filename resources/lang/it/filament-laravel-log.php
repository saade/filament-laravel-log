<?php

return [
    'navigation' => [
        'group' => 'Sistema',
        'label' => 'Log',
    ],

    'page' => [
        'title' => 'Log',

        'form' => [
            'placeholder' => 'Seleziona o cerca un file di log...',
        ],
    ],

    'actions' => [
        'clear' => [
            'label' => 'Cancella',

            'modal' => [
                'heading' => 'Cancellare i log del sito?',
                'description' => 'Sei sicuro di voler cancellare tutti i log del sito?',

                'actions' => [
                    'confirm' => 'Cancella',
                ],
            ],
        ],

        'jumpToStart' => [
            'label' => 'Vai all\'inizio',
        ],

        'jumpToEnd' => [
            'label' => 'Vai alla fine',
        ],

        'refresh' => [
            'label' => 'Aggiorna',
        ],
    ],
];
