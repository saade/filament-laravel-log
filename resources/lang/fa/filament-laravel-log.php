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

    'actions' => [
        'clear' => [
            'label' => 'پاک کردن',

            'modal' => [
                'heading' => 'پاک‌سازی لاگ‌های سایت؟',
                'description' => 'آیا مطمئن هستید که می‌خواهید تمام لاگ‌های سایت را پاک کنید؟',

                'actions' => [
                    'confirm' => 'پاک کن',
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
