<?php

return [
    'navigation' => [
        'label' => 'سجلات النظام',
    ],

    'page' => [
        'form' => [
            'placeholder' => 'اختر أو ابحث عن ملف سجل...',
        ],
    ],

    'actions' => [
        'clear' => [
            'label' => 'مسح',

            'modal' => [
                'heading' => 'مسح السجلات؟',
                'description' => 'هل أنت متأكد بأنك تريد مسح جميع السجلات؟',

                'actions' => [
                    'confirm' => 'مسح',
                ],
            ],
        ],

        'jumpToStart' => [
            'label' => 'القفز إلى البداية',
        ],

        'jumpToEnd' => [
            'label' => 'القفز إلى النهاية',
        ],

        'refresh' => [
            'label' => 'تحديث',
        ],
    ],
];
