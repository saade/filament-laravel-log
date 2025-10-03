<?php

return [
    'navigation' => [
        'group' => 'سیستم',
        'label' => 'لاگ‌ها',
    ],

    'page' => [
        'title' => 'لاگ‌ها',

        'form' => [
            'placeholder' => 'یک فایل لاگ را انتخاب یا جستجو کنید...',
        ],
    ],
    'navigation' => [
        'label' => 'لاگ‌ها'
    ],
    'actions' => [
        'clear' => [
            'label' => 'پاک کردن',

            'modal' => [
                'heading' => 'لاگ های سایت پاک شوند؟',
                'description' => 'آیا مطمئن هستید که می خواهید تمام لاگ های این فایل را پاک کنید؟',

                'actions' => [
                    'confirm' => 'لاگ‌ها را پاک کن',
                ],
            ],
        ],

        'jumpToStart' => [
            'label' => 'برو به ابتدا',
        ],

        'jumpToEnd' => [
            'label' => 'برو به انتها',
        ],

        'refresh' => [
            'label' => 'بازنشانی',
        ],
    ],
];
