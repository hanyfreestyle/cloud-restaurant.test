<?php

return [
    'supportedLocales' => [
        'en' => [
            'name' => 'English',
            'script' => 'Latn',
            'native' => 'English',
            'regional' => 'en_GB',
        ],
        'ar' => [
            'name' => 'Arabic',
            'script' => 'Arab',
            'native' => 'العربية',
            'regional' => 'ar_AE',
        ],
    ],
    
    'useAcceptLanguageHeader' => true,
    
    'hideDefaultLocaleInURL' => false,
    
    'localesOrder' => [
        'en',
        'ar',
    ],
];
