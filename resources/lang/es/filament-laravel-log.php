<?php

return [
    'navigation' => [
        'group' => 'Sistema',
    ],

    'page' => [
        'title' => 'Logs',
        'form' => [
            'placeholder' => 'Selecciona o busca un archivo de registro...',
        ],
    ],

    'actions' => [
        'clear' => [
            'label' => 'Vaciar',

            'modal' => [
                'heading' => '¿Vaciar este archivo?',
                'description' => '¿Estás seguro de que quieres vaciar todos los registros de este archivo?',

                'actions' => [
                    'confirm' => 'Vaciar',
                ],
            ],
        ],

        'jumpToStart' => [
            'label' => 'Ir al inicio',
        ],

        'jumpToEnd' => [
            'label' => 'Ir al final',
        ],

        'refresh' => [
            'label' => 'Actualizar',
        ],
    ],
];
