<?php

return [
    // Rate limiting untuk login attempts
    'login' => [
        'max_attempts' => 5,
        'decay_minutes' => 1,
    ],

    // Rate limiting untuk API/checkout
    'checkout' => [
        'max_attempts' => 10,
        'decay_minutes' => 1,
    ],
];
