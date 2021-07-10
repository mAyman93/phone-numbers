<?php

return [
    'country_codes' => [
        '237' => 'Cameroon',
        '251' => 'Ethiopia',
        '212' => 'Morocco',
        '258' => 'Mozambique',
        '256' => 'Uganda',
    ],
    'country_regex' => [
        'Cameroon' => '/\(237\)\ ?[2368]\d{7,8}$/',
        'Ethiopia' => '/\(251\)\ ?[1-59]\d{8}$/',
        'Morocco' => '/\(212\)\ ?[5-9]\d{8}$/',
        'Mozambique' => '/\(258\)\ ?[28]\d{7,8}$/',
        'Uganda' => '/\(256\)\ ?\d{9}$/'
    ]
];