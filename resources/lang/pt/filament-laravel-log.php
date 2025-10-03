<?php

return [
    'navigation' => [
        'group' => 'Sistema',
        'label' => 'Registos',
    ],

    'page' => [
        'title' => 'Registos',

        'form' => [
            'placeholder' => 'Selecione ou pesquise um ficheiro de registo...',
        ],
    ],

    'actions' => [
        'clear' => [
            'label' => 'Limpar',

            'modal' => [
                'heading' => 'Limpar registos do site?',
                'description' => 'Tem a certeza de que pretende limpar todos os registos do site?',

                'actions' => [
                    'confirm' => 'Limpar',
                ],
            ],
        ],

        'jumpToStart' => [
            'label' => 'Ir para o início',
        ],

        'jumpToEnd' => [
            'label' => 'Ir para o fim',
        ],

        'refresh' => [
            'label' => 'Atualizar',
        ],
    ],
];
