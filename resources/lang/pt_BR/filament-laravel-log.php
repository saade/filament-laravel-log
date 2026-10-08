<?php

return [
    'navigation' => [
        'label' => 'Registros',
    ],

    'page' => [
        'form' => [
            'placeholder' => 'Selecione ou pesquise um arquivo de log...',
        ],
    ],

    'actions' => [
        'clear' => [
            'label' => 'Limpar',

            'modal' => [
                'heading' => 'Limpar registros do site?',
                'description' => 'Tem certeza de que deseja limpar todos os registros do site?',

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
